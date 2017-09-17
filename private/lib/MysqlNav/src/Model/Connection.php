<?php

namespace MysqlNav\Model;

class Connection {
	public $host = null;
	public $user = null;
	public $pass = null;
	public $db   = null;
	public $name = null;
	
	public function __construct($name, $host, $user, $pass, $db) {
		$this->name = $name;
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->db   = $db  ;
	}
}