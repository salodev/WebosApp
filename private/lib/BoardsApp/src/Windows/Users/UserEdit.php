<?php

namespace BoardsApp\Windows\Users;
use BoardsApp\Model\Users\Users;

class UserEdit extends UserAdd {
	
	public function initialize(array $params = []) {
		parent::initialize($params);
		$user = Users::GetByUserID($params['id']);
		$this->title = "Edit user #{$user->id} - {$user->name}";
		$tab = $this->tabs->addTab('Groups');
		$tab->embedWindow(UserGroupList::class, [
			'userID' => $params['id'],
		]);
		
		$tab = $this->tabs->addTab('Boards');
		$tab = $this->tabs->addTab('Tasks');
	}
}