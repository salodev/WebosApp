<?php

namespace MysqlNav\Windows\Connections;

use Webos\Visual\Window;
use salodev\Mysql;

class Add extends Window { 
	
	public function initialize(array $params = []) {
		$this->title = 'Add connection';
		
		$this->createTextBox('Name', 'name', ['width'=>150, 'labelWidth'=>100, 'value'=>'Localhost']);
		$this->createTextBox('Host', 'host', ['value'=>'localhost']);
		$this->createTextBox('User', 'user', ['value'=>'root']);
		$this->createTextBox('Pass', 'pass');
		$this->createTextBox('DB', 'db');
		
		$this->createWindowButton('Test Connection...')->onClick(function() {
			$this->waitWindow('Testing...', function() {
				$data = $this->getFormData();
				$host = $data['host'];
				$user = $data['user'];
				$pass = $data['pass'];
				$db   = $data['db'  ];
				$connection = new \salodev\Mysql\Connection($host, $user, $pass, $db);
				$connection->connect();
				$this->messageWindow('Connection was successful!');
			});
		});
		$this->createWindowButton('Create');
		$this->createWindowButton('Close');
		$this->width = 350;
		
		$this->pass->focus();
	}
}