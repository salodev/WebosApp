<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Windows\DataList;
use BoardsApp\Model\Users\UserGroups;

class GroupUserList extends DataList {
	
	public function initialize(array $params = []) {
		$this->title = 'Group Users List';
		$this->params = $params;
		parent::initialize($params);
		$this->addColumn()->fieldName('id'       )->label('#'       )->width( 60);
		$this->addColumn()->fieldName('userID'   )->label('User ID' )->width( 80);
		$this->addColumn()->fieldName('userName' )->label('Name'    )->width(200);
		$this->addColumn()->fieldName('role'     )->label('Role'    )->width(100);
		
		$this->addToolButton('Add')->onClick(function() {
			$this->openWindow(UserListSeeker::class)->onNewData(function($data) {
				$groupID = $this->params['groupID'];
				$userID  = $data['id'];
				UserGroups::Add($userID, $groupID, 'USER');
				$this->newData();
			});
		});
		
		$this->createActionsMenu(function($data) {
			$menu = $data['menu'];
			if ($this->dataTable->hasSelectedRow()) {
				
				$menu->createItem('View user')->onClick(function() {
					$this->openWindow(UserEdit::class, [
						'id' => $this->dataTable->getSelectedRowData('userID'),
					])->syncDataWith($this);
				});
				
				$menu->createItem('View user groups')->onClick(function() {
					$this->openWindow(UserGroupList::class, [
						'userID' => $this->dataTable->getSelectedRowData('userID'),
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
			'groupID' => $this->params['groupID'],
		]);
	}
}