<?php

namespace BoardsApp\Model\Users;

class Group {
	public $id;
	public $name;
	public $description;
	public $status;
	
	/**
	 * 
	 * @param array $data
	 */
	public function __construct(array $data = []) {
		foreach($data as $name => $value) {
			$this->$name = $value;
		}
	}
	
	public function createBoard(string $name, string $description) {
		
	}
}