<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Windows\DataList;
use BoardsApp\Model\Users\Groups;

class GroupListSeeker extends DataList {
	
	public function initialize(array $params = []) {
		$this->title = 'Select a Group';
		parent::initialize($params);
		$this->addColumn()->fieldName('id'      )->label('#'     )->width(50);
		$this->addColumn()->fieldName('name'    )->label('Name'  )->width(150);
		$this->addColumn()->fieldName('description'    )->label('Description'  )->width(250);
		$this->addColumn()->fieldName('status'  )->label('Status');
		
		$this->addToolButton('Create')->onClick(function() {
			$this->openWindow(GroupAdd::class)->onNewData(function() {
				$this->newData();
			});
		});

		
		$this->createActionsMenu(function($data) {
			$menu = $data['menu'];
			if ($this->dataTable->hasSelectedRow()) {
				$menu->createItem('Select')->onClick(function() {
					$this->newData([
						'id' => $this->dataTable->getSelectedRowData('id'),
					]);
				});
				$menu->createSeparator();
			}
			$menu->createItem('Refresh...')->onClick(function() {
				$this->refreshList();
			});
		});
	}
	
	public function getData(): array {
		return Groups::GetList(0, 30);
	}
}