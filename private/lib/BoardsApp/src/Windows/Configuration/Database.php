<?php

namespace BoardsApp\Windows\Configuration;
use Webos\Visual\Window;

class Database extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Database Connection Setup';
		$this->width=400;
		$this->createTextBox('Host / Server name / IP', 'host', ['width'=>200,'labelWidth'=>170]);
		$this->createTextBox('Username',      'username');
		$this->createTextBox('Password',      'password');
		$this->createTextBox('Database name', 'database');
		$buttonsBar = $this->createButtonsBar();
		$buttonsBar->addButton('Test connection..');
		$buttonsBar->addButton('Save');
		$buttonsBar->addButton('Close')->closeWindow();
	}
}