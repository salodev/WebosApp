<?php

namespace BoardsApp\Windows\Issues;
use Webos\Visual\Window;

class Create extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Create issue';
		$this->createComboBox('Priority', 'priority', [
			'width' => 250,
			'options' => ['TOP','HIGH','NORMAL','LOW'],
		])->value = 'NORMAL';
		$this->createTextBox('Title', '_title',['width'=>250])->focus();
		$this->createTextBox('Description', 'description', [
			'width' => 450,
			'multiline' => true,
			'height' => 120,
		]);
		
		$this->createWindowButton('Add');
		$this->createWindowButton('Cancel')->closeWindow();
		
		$this->onKeyEscape(function() {
			$this->close();
		});
	}
}