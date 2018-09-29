<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Windows\DataList;
use BoardsApp\Model\Users\Users;

class UserList extends DataList {
	
	public function initialize(array $params = []) {
		$this->title = 'Users List';
		parent::initialize($params);
		$this->addColumn()->fieldName('id'      )->label('#'     );
		$this->addColumn()->fieldName('userName')->label('User'  );
		$this->addColumn()->fieldName('email'   )->label('Email' );
		$this->addColumn()->fieldName('type'    )->label('Type'  );
		$this->addColumn()->fieldName('status'  )->label('Status');
		
		$this->addToolButton('Create')->onClick(function() {
			$this->openWindow(UserAdd::class)->onNewData(function() {
				$this->newData();
			});
		});
		
		$this->createActionsMenu(function($data) {
			$menu = $data['menu'];
			if ($this->dataTable->hasSelectedRow()) {
				$menu->createItem('Edit')->onClick(function() {
					$this->openWindow(UserEdit::class, [
						'id' => $this->dataTable->getSelectedRowData('id'),
					])->onNewData(function() {
						$this->newData();
					});
				});
				$menu->createSeparator();
				if ($this->dataTable->getSelectedRowData('status')!='ACTIVE') {
					$menu->createItem('Activate')->onClick(function() {
						Users::Activate($this->dataTable->getSelectedRowData('id'));
						$this->newData();
					});
				} else {
					$menu->createItem('Block')->onClick(function() {
						Users::Block($this->dataTable->getSelectedRowData('id'));
						$this->newData();
					});
				}
				$menu->createItem('Remove')->onClick(function() {
					Users::MarkDeleted($this->dataTable->getSelectedRowData('id'));
					$this->newData();
				});
				$menu->createSeparator();
			}
			$menu->createItem('Refresh...')->onClick(function() {
				$this->refreshList();
			});
		});
	}
	
	public function getData(): array {
		return Users::GetList(0, 30);
	}
}