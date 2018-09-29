<?php

namespace BoardsApp\Model\Users;

class UserGroup {
	public $id;
	public $userID;
	public $role;
	public $groupID;
	public $groupName;
	
	/**
	 *
	 * @var User 
	 */
	public $user;
	
	/**
	 * 
	 * @var Group;
	 */
	public $group;
	
	/**
	 * 
	 * @param array $data
	 */
	public function __construct(array $data = []) {
		foreach($data as $name => $value) {
			$this->$name = $value;
		}
	}
}