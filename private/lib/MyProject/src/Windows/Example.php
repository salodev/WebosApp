<?php

namespace MyProject\Windows;

use Webos\Visual\Window;

class Example extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Hello! Let me know who are you!';
		$this->createTextBox('Your name', 'name', ['labelWidth'=>150,'width'=>150]);
		$this->createTextBox('Your age', 'name');
		$this->createComboBox('Your gender', 'gender', [
			'options' => ['Male', 'Female'],
		]);
		$this->createWindowButton('Store!');
		$this->createWindowButton('Close!')->closeWindow();
	}
	
	public function createMenus() {		
		$button = $this->menuBar->createButton('Menus');
		$button->createItem('Menu item example');
		$button->createSeparator();
		$button->createItem('Menu item with click')->onClick(function() {
			$this->messageWindow('Hello!');
		});
		$button->createItem('Open simple window')->onClick(function() {
			$this->openWindow(Example::class);
		});
	}
	
}