<?php

namespace BoardsApp\Model\Boards;
use BoardsApp\Model\Users\User;
use BoardsApp\Model\Users\Group;

class Board {
	
	public $id;
	public $name;
	public $description;
	public $priority;
	public $creationTime;
	public $finishedTime;
	public $status;
	
	private $_owner;
	private $_group;
	
	public function __construct(int $id, string $name, string $description, User $owner = null, Group $group = null) {
		$this->id          = $id;
		$this->name        = $name;
		$this->description = $description;
		$this->_owner      = $user;
		$this->_group      = $group;
	}
	
	public function getOwner(): User {
		return $this->_owner;
	}
	
	public function setOwner(User $user): self {
		$this->_owner = $user;
		return $this;
	}
	
	public function getGroup(): Group {
		return $this->_group;
	}
	
	public function setGroup(Group $group): self {
		$this->_group = $group;
		return $this;
	}
	
}