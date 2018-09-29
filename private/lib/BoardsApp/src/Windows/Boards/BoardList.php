<?php

namespace BoardsApp\Windows\Boards;
use Webos\Visual\Windows\DataList;
use BoardsApp\Model\Boards\Boards;

class BoardList extends DataList {
	
	public function initialize(array $params = []) {
		$this->title = 'Boards List';
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
				$menu->createItem('Edit')->onClick(function() {
					$this->openWindow(GroupEdit::class, [
						'id' => $this->dataTable->getSelectedRowData('id'),
					])->onNewData(function() {
						$this->newData();
					});
				});
				$menu->createSeparator();
				if ($this->dataTable->getSelectedRowData('status')!='ACTIVE') {
					$menu->createItem('Activate')->onClick(function() {
						Groups::Activate($this->dataTable->getSelectedRowData('id'));
						$this->newData();
					});
				} else {
					$menu->createItem('Disable')->onClick(function() {
						Groups::Disable($this->dataTable->getSelectedRowData('id'));
						$this->newData();
					});
				}
				$menu->createItem('Remove')->onClick(function() {
					Groups::MarkDeleted($this->dataTable->getSelectedRowData('id'));
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
		return Boards::GetList(0, 30);
	}
}