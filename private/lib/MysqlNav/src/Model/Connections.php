<?php

namespace MysqlNav\Model;
use Webos\StorageDriver;

class Connections {
	
	static public function GetList()  {
		$content = StorageDriver::ReadFile('MysqlNav.connections.txt');
	}
}