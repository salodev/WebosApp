<?php

namespace MyProject\Windows;

use Webos\Visual\Window;

class MultiTab extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Multitab example!';
		$this->tabs = $this->createTabsFolder();
		$this->tab1();
		$this->tab2();
		$this->tab3();
	}
	
	public function tab1() {
		$tab = $this->tabs->addTab('Single Form');
		$tab->createTextBox('Your Name', 'name', ['labelWidth'=> 150, 'width'=>150]);
		$tab->createTextBox('Your Last Name', 'lastname');
		$tab->createTextBox('Your e-Mail', 'email');
		$tab->createTextBox('Gender', 'gender', ['options'=>[
			'male',
			'female',
		]]);
		$tab->createWindowButton('Save');
	}
	
	public function tab2() {
		$tab = $this->tabs->addTab('Data Table');
		$dataTable = $tab->createDataTable();
		$dataTable->addColumn('id', '#', 80);
		$dataTable->addColumn('name', 'Name', 150);
		$dataTable->addColumn('email', 'E-Mail', 150);
		$dataTable->rows = [
			['id' => 1,'name'=>'Salomón Córdova','email'=>'salojc2006@gmail.com'],
			['id' => 2,'name'=>'Diana Lope','email'=>'dianalope@webos.com'],
		];
		
	}
	
	public function tab3() {
		$tab = $this->tabs->addTab('Tree');
		$tree = $tab->createTree(/*[
			'top' => 0,
			'left' => 0,
			'right' => 0,
			'bottom' => 0,
		]*/);
		$tree->addColumn('value', 'Value', 200);
		$n1 = $tree->addNode('General');
			$n1->addNode('Project Name', ['value'=>'MyProject']);
			$n1->addNode('Project Version', ['value'=>'0.0.0']);
			$n1->addNode('Project Provider', ['value'=>'Salomón Córdova']);
			$n1->addNode('Project Email', ['value'=>'salojc2006@gmail.com']);
		$n2 = $tree->addNode('Misc');
		$n3 = $tree->addNode('Test');
	
	}
	
}