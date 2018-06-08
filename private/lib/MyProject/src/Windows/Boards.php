<?php

namespace MyProject\Windows;

use Webos\Visual\Window;
use Webos\Visual\Controls\HtmlContainer;

class Boards extends Window {
	
	public function initialize(array $params = []): void {
		$this->title = 'Boards view';
		$this->splitVertical();
		$this->rightPanel->splitHorizontal();
		
		$this->tree = $this->leftPanel->createTree([
			'top'   => 0,
			'right' => 0,
			'left'  => 0,
			'bottom' => 0,
		]);
		
		
		$t = $this->rightPanel->topPanel->createToolBar();
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
		
		$this->preview = $this->rightPanel->bottomPanel->createObject(HtmlContainer::class, [
			'top' => 0,
			'bottom' => 0,
			'left' => 0,
			'right' => 0,
			'overflow-x'=>'scroll',
		]);
		
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
			'text' => 'Hola salo, por lo que vi el enlace que muestra los datos del cliente, dejo de funcionar. Cuando hago click me recarga toda la página sin levarme a ningun lado.',
			'section' => 'Development',
			'subsection' => 'Bugs',
			'status' => 'TAKEN',
			'creationTime' => '2018-05-08 12:22',
			'comments' => [
				['name'=>'Salomón', 'text'=>'Acabo de comprobarlo y funciona. Pasame una captura donde pueda verlo'],
				['name'=>'Cesia',   'text'=>'Es el que te mostré recién'],
				['name'=>'Salomón', 'text'=>'Ahí lo vi... no es que está roto, es que no elejiste ningún cliente.'],
			]
		];
		$this->list->rows = $rows;
	}
	
	public function refreshPreview(array $data) {
		$preview = $this->preview;
		$preview->removeChilds();
		
		$preview->h2($data['title']);
		$preview->a($data['section'] . ' &gt; ' . $data['subsection'])->onClick(function() {
			$this->messageWindow('Click en el titulo');
		});
		$preview->p($data['text']);
		foreach($data['comments'] as $comment) {
			$preview->blockquote("<b>{$comment['name']}</b>: {$comment['text']}");
		}
	}
}