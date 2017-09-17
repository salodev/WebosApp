<?php

namespace MysqlNav\Windows\Connections;

use Webos\Visual\Window;

class Add extends Window { 
	
	public function initialize(array $params = []) {
		$this->title = 'Add connection';
		
		$this->createTextBox('Name', 'name', ['width'=>150, 'labelWidth'=>100]);
		$this->createTextBox('Host', 'host', ['value'=>'localhost']);
		$this->createTextBox('User', 'user', ['value'=>'root']);
		$this->createTextBox('Pass', 'pass');
		$this->createTextBox('DB', 'db');
		
		$this->createWindowButton('Test Connection...')->onClick(function() {
			$this->waitWindow('Testing...', function() {
				
			});
		});
		$this->createWindowButton('Create');
		$this->createWindowButton('Close');
		$this->width = 350;
		
		$this->pass->focus();
	}
}