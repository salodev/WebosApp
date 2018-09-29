<?php

namespace BoardsApp\Model\Users;

class User {
	/**
	 *
	 * @var int 
	 */
	public $id;
	
	/**
	 *
	 * @var string 
	 */
	public $userName;
	
	/**
	 *
	 * @var string 
	 */
	public $name;
	
	/**
	 *
	 * @var string 
	 */
	public $type;
	
	/**
	 *
	 * @var string 
	 */
	public $email;
	
	/**
	 * 
	 * @var string
	 */
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
	
	public function getGroups(): array {
		return Groups::GetListByUserName($this->username);
	}
	
	public function createBoard(string $name, string $description, Group $group = null) {
		
	}
	
	public function getOwnBoards() {
		
	}
	
	public function getInvolvedBoards() {
		
	}
}