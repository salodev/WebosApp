<?php

namespace BoardsApp\Windows;

use Webos\Visual\Controls\HtmlContainer;
use Webos\Visual\Windows\Application as Window;
use Webos\Visual\Controls\TextBox;
use Webos\Visual\Controls\ComboBox;
use BoardsApp\Windows\Issues\AddComment;
use salodev\Mysql;

class Main extends Window {
	public function initialize(array $params = []): void {
		$this->title = 'Boards view';
		$this->menuBar = $this->createMenuBar();
		
		$menuApp    = $this->menuBar->createButton('Application');
		$menuConfig = $this->menuBar->createButton('Configuration');
		$menuHelp   = $this->menuBar->createButton('Help!');
		
		$menuApp->createItem('My Account');
		$menuApp->createItem('Exit')->finishApplication();
		$menuConfig->createItem('Database')->openWindow(Configuration\Database::class);
		$menuConfig->createItem('Users');
		$menuConfig->createItem('Boards');
		$menuConfig->createItem('Preferences');
		
		$menuHelp->createItem('Contact Support');
		$menuHelp->createItem('Open Manual');
		$menuHelp->createItem('About App');
		
		$this->splitVertical(200);
		$this->rightPanel->splitHorizontal(200);
		
		$this->tree = $this->leftPanel->createTree([
			'top'   => 0,
			'right' => 0,
			'left'  => 0,
			'bottom' => 0,
		]);
		
		
		$t = $this->rightPanel->topPanel->createToolBar();
		$t->createObject(TextBox::class, ['width'=>150,'placeholder'=>'search text...']);
		$t->createObject(ComboBox::class, [
			'width'=>170,
			'options' => [
				'current' => 'CURRENT BOARD',
				'all'     => 'ALL BOARDS',
			],
			'assoc' => true,
		]);
		$t->addButton('Search');
		$t->addButton('+ Board');
		$t->addButton('+ Issue');
		
		$this->list = $this->rightPanel->topPanel->createDataTable();
		
		$this->list->addColumn()->label('Title'  )->fieldName('title'       )->width(400);
		$this->list->addColumn()->label('Owner'  )->fieldName('owner.name.0');
		$this->list->addColumn()->label('Status' )->fieldName('status'      );
		$this->list->addColumn()->label('Created')->fieldName('creationTime');
		
		$this->list->onRowClick(function($source) {
			$data = $source->getSelectedRowData();
			$this->refreshPreview($data);
		});
		
		$this->rightPanel->bottomPanel->splitVertical(-350);
		$previewPanel = $this->rightPanel->bottomPanel->leftPanel;
		$tb = $previewPanel->createToolBar();
		$tb->addButton('Close')->width(50);
		$tb->addButton('Done')->width(50);
		$tb->addButton('Move')->width(50);
		$tb->addButton('Assign To')->width(80);
		$tb->addButton('Attach File')->width(80);
		$tb->addButton('Edit')->width(50);
		
		$this->preview = $previewPanel->createObject(HtmlContainer::class, [
			'top' => 30,
			'bottom' => 0,
			'left' => 0,
			'right' => 0,
			'overflow-x'=>'scroll',
		]);
		$details = $this->details = $this->rightPanel->bottomPanel->rightPanel;		$details = $this->details;
		$details->createLabelBox('Created by',      'owner.name',   ['labelWidth'=>120,'width'=>220,'enabled'=>false]);
		$details->createLabelBox('Creation time',   'creationTime'  );
		$details->createLabelBox('Priority',        'priority' );
		$details->createLabelBox('Status',          'status'        );
		$details->createLabelBox('Taken by',        'takenBy.name'  );
		$details->createLabelBox('Dedication time', 'dedicationTime');
		
		$this->createNodes();
		$this->refreshList();
	}
	
	public function getAllowedActions(): array {
		return array_merge(parent::getAllowedActions(), ['scroll']);
	}
	
	public function createNodes() {
		$n = $this->tree->addNode('My Tasks (2)');
		
		$n = $this->tree->addNode('Be Noticed (3)');
		$n->addNode('Newest (0)');
		$n->addNode('Updated (3)');
		
		$n = $this->tree->addNode('My boards');
		$n->addNode('My tasks');
		$n->addNode('Requests');
		$n->addNode('Ideas');
		
		$n = $this->tree->addNode('Involved boards');
		$n->addNode('Area');
		$n->addNode('Bug reports');
		$n->addNode('Dev requests');
		
		$n = $this->tree->addNode('Others');
		$n->addNode('Sales');
		$n->addNode('Sysadmins');
		$n1 = $n->addNode('Development');
		$n1->addNode('Bugs');
		$n1->addNode('Requires');
		$n1 = $n->addNode('Company');
		$n1->addNode('Project EvoSys');
		$n1->addNode('Backoffice');
	}
	
	public function refreshList() {
		$rows = [];
		$rows[] = [
			'title' => 'Error al guardar datos',
			'owner' => [
				'id' => 2,
				'name' => ['Cesia','Cordova'],
			],
			'text' => 'Cuando quiero cambiar los datos del perfil aparece un mensaje de error sin texto.',
			'section' => 'Development',
			'subsection' => 'Bugs',
			'status' => 'TAKEN',
			'creationTime' => '2018-05-08 12:22',
			'comments' => [],
		];
		
		$rows[] = [
			'title' => 'No valida la clave',
			'owner' => [
				'id' => 3,
				'name' => ['Benjamin','Cordova'],
			],
			'text' => 'Al registrar un usuario me deja poner claves como 321321 o aaaa',
			'section' => 'Development',
			'subsection' => 'Bugs',
			'status' => 'TAKEN',
			'creationTime' => '2018-05-08 12:22',
			'comments' => [],
		];
		
		$rows[] = [
			'title' => 'Sitio Lento',
			'owner' => [
				'id' => 4,
				'name' => ['Salomon','Cordova'],
			],
			'text' => 'Tarda muchísimo en cargar, esto nos va a bajar las ventas.',
			'section' => 'Development',
			'subsection' => 'Bugs',
			'status' => 'TAKEN',
			'creationTime' => '2018-05-08 12:22',
			'comments' => [],
		];
		
		$rows[] = [
			'title' => 'Link roto',
			'owner' => [
				'id' => 2,
				'name' => ['Cesia','Cordova'],
			],
			'text' => 
				'Hola salo, por lo que vi el enlace que muestra los datos del cliente, dejo de funcionar. Cuando hago click me recarga toda la página sin levarme a ningun lado.<br /><br />' .
				'Por favor te encarezco que funcione porque nos ayuda muchisimo poder acceder a esa información. Sucede que muchos clientes llaman y no conocen si quiera su numero en el sistema o tienen pagos atrasados, y con ese link lo veíamos enseguida. <br /><br />' .
				'Yo la semana que viene salgo de vacaciones, me gustaría estar segura de que quede funcionando. Cualquier duda que tengas preguntame y te damos mas información.',
			'section'    => 'Development',
			'subsection' => 'Bugs',
			'status'     => 'TAKEN',
			'priority'   => 'HIGH',
			'creationTime' => '2018-05-08 12:22',
			'comments' => [
				['name'=>'Salomón', 'text'=>'Acabo de comprobarlo y funciona. Pasame una captura donde pueda verlo'],
				['name'=>'Cesia',   'text'=>'Es el que te mostré recién'],
				['name'=>'Salomón', 'text'=>'Ahí lo vi... no es que está roto, es que no elejiste ningún cliente.'],
				['name'=>'Cesia',   'text'=>'Y no le podés poner una opción sobre la lista o algo para que sea fácil entender cómo hacer? Antes era más intuitivo porque era otro flujo, ahora está bien pero estaría bueno que los chicos se den cuenta cómo hacer.'],
				['name'=>'Salomón', 'text'=>'Un menú contextual, que lo usan en los otros listados. Si así lo entienden eso es mejor.'],
				['name'=>'Cesia',   'text'=>'Bueno dale, probemos con eso. Para cuando lo podrás tener?'],
			]
		];
		$this->list->rows = $rows;
	}
	
	public function refreshPreview(array $data) {
		$preview = $this->preview;
		$preview->removeChilds();
		$preview->modified();
		$preview->h2($data['title']);
		$preview->a($data['section'] . ' &gt; ' . $data['subsection'])->onClick(function() {
			$this->messageWindow('Click en el titulo');
		});
		$preview->br();
		$preview->p($data['text']);
		foreach($data['comments'] as $comment) {
			$preview->blockquote("<b>{$comment['name']}</b>: {$comment['text']}");
		}
		$preview->createButton('Comentar')->left(50)->width(80)->openWindow(AddComment::class, [
			'issueID' => 0,
		]);
		$preview->br();
		$preview->br();
		$this->details->setFormData($data);
	}
}