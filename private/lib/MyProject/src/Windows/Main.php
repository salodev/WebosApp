<?php

namespace MyProject\Windows;

use Webos\Visual\Windows\Application as Window;
use MyProject\Windows\Example;

class Main extends Window {
	
	public function initialize(array $params = []) {
		parent::initialize($params);
		$this->menuBar = $this->createMenuBar();
		$this->createMenu1();
		$this->createMenu2();
		$this->createMenu3();
	}
	
	public function createMenu1() {		
		$button = $this->menuBar->createButton('Menus');
		$button->createItem('Menu item example');
		$button->createSeparator();
		$button->createItem('Menu item with click')->onClick(function() {
			$this->messageWindow('Hello!');
		});
		$button->createItem('Open simple window')->onClick(function() {
			$this->openWindow(Example::class);
		});
		$button->createSeparator();
		$button->createItem('Start MysqlNav')->onClick(function() {
			$this->getApplication()->getWorkSpace()->startApplication('MysqlNav\App');
		});
		$button->createSeparator();
		$button->createItem('Start BoardsApp')->onClick(function() {
			$this->getApplication()->getWorkSpace()->startApplication('BoardsApp\App');
		});
	}
	
	public function createMenu2() {		
		$button = $this->menuBar->createButton('Windows');
		$button->createItem('Message Window')->onClick(function() {
			$this->messageWindow('Welcome!!');
		});
		$button->createItem('Wait Window')->onClick(function() {
			$this->waitWindow('Please wait 5 seconds..', function() {
				sleep(5);
				$this->messageWindow('Thanks!!');
			});
		});
		$button->createItem('Prompt Window')->onClick(function() {
			$this->onPrompt('Hello! Your birthday?', function($data) {
				$this->messageWindow($data['value']);
			});
		});
		$button->createItem('Confirm Window')->onClick(function() {
			$this->onConfirm('Are you a PHP developer?', function($data) {
				$this->messageWindow('Welcome!!');
			});
		});
	}
	
	public function createMenu3() {		
		$button = $this->menuBar->createButton('Forms & controls!');
		$button->createItem('Basic Form')->onClick(function() {
			$this->openWindow(Example::class);
		});
		$button->createItem('MultiTab')->onClick(function() {
			$this->openWindow(MultiTab::class);
		});
		$button->createItem('Html Container')->onClick(function() {
			$this->openWindow(Html::class);
		});
		$button->createItem('Boards')->onClick(function() {
			$this->openWindow(Boards::class);
		});
	}
}