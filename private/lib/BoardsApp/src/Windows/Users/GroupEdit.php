<?php

namespace BoardsApp\Windows\Users;
use BoardsApp\Model\Users\Groups;
use BoardsApp\Windows\Boards\BoardList;
use BoardsApp\Windows\Boards\TaskList;

class GroupEdit extends GroupAdd {
	
	public function initialize(array $params = []) {
		parent::initialize($params);
		$group = Groups::Get($params['id']);
		$this->title = "Edit group #{$group->id} - {$group->name}";
		$this->tabs->addTab('Users')->embedWindow(GroupUserList::class, [
			'groupID' => $params['id'],
		])->syncDataWith($this);
		$this->tabs->addTab('Boards')->embedWindow(GroupList::class, [
			'groupID' => $params['id'],
		]);
		/*$this->tabs->addTab('Tasks')->embedWindow(TaskList::class, [
			'groupID' => $params['id'],
		]);*/
	}
}