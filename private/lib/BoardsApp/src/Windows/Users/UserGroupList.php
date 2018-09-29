<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Windows\DataList;
use BoardsApp\Model\Users\UserGroups;
use BoardsApp\Model\Users\Users;

class UserGroupList extends DataList {
	
	public function initialize(array $params = []) {
		$this->params = $params;
		$user = Users::GetByUserID($this->params['userID']);
		$this->title = 'Group List for ' . $user->name;
		parent::initialize($params);
		$this->addColumn()->fieldName('id'       )->label('#'       )->width( 60);
		$this->addColumn()->fieldName('groupID'  )->label('Group ID')->width( 80);
		$this->addColumn()->fieldName('groupName')->label('Name'    )->width(200);
		$this->addColumn()->fieldName('role'     )->label('Role'    )->width(100);
		
		$this->addToolButton('Add')->onClick(function() {
			$this->openWindow(GroupListSeeker::class)->onNewData(function($data) {
				$userID  = $this->params['userID'];
				$groupID = $data['id'];
				UserGroups::Add($userID, $groupID, 'USER');
				$this->newData();
			});
		});
		
		$this->createActionsMenu(function($data) {
			$menu = $data['menu'];
			if ($this->dataTable->hasSelectedRow()) {
				
				$menu->createItem('View group')->onClick(function() {
					$this->openWindow(GroupEdit::class, [
						'id' => $this->dataTable->getSelectedRowData('groupID'),
					])->syncDataWith($this);
				});
				
				$menu->createItem('Remove')->onClick(function() {
					UserGroups::Remove($this->dataTable->getSelectedRowData('id'));
					$this->newData();
				});
				
				$role = $this->dataTable->getSelectedRowData('role');
				
				if ($role == 'USER') {
					$menu->createItem("Set ADMIN role")->onClick(function() {
						UserGroups::UpdateRole($this->dataTable->getSelectedRowData('id'), 'ADMIN');
						$this->newData();
					});
				}
				
				if ($role == 'ADMIN') {
					$menu->createItem("Set USER role")->onClick(function() {
						UserGroups::UpdateRole($this->dataTable->getSelectedRowData('id'), 'USER');
						$this->newData();
					});
				}
				
				$menu->createSeparator();
			}
			$menu->createItem('Refresh...')->onClick(function() {
				$this->refreshList();
			});
		});
	}
	
	public function getData(): array {
		return UserGroups::GetList(0, 30, [
			'userID' => $this->params['userID'],
		]);
	}
}