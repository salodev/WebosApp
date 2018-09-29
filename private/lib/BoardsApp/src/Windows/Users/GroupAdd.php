<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Window;
use BoardsApp\Model\Users\Groups;

class GroupAdd extends Window {
	
	public function createGeneralTab() {
		$tabs = $this->tabs;
		$tab = $this->tabGeneral =  $tabs->addTab('General');
		$tab->createTextBox('ID', 'id')->disable();
		$tab->createTextBox('Name', 'name', ['width'=>400]);
		$tab->createTextBox('Description', 'description')->multiline(true)->height(80);
		$tab->createWindowButton('Save')->onClick(function() {
			$data = $this->tabGeneral->getFormData();
			if (!empty($this->params['id'])) {
				Groups::Edit($this->params['id'], $data['name'], $data['description']);
			} else {
				$group = Groups::Create($data['name'], $data['description']);
				$this->close();
				/*$w = $this->openWindow(GroupEdit::class, [
					'id' => $group->id,
				]);
				$w->top = $this->top;
				$w->left = $this->left;*/
			}
			$this->newData();
		});
		$tab->createWindowButton('Close')->closeWindow();
		
		if (!empty($this->params['id'])) {
			$userData = (array) Groups::Get($this->params['id']);
			$this->tabGeneral->setFormData($userData);
		}
	}
	
	public function initialize(array $params = []) {
		$this->params = $params;
		$this->title = 'Add new group';
		$tabs = $this->tabs = $this->createTabsFolder();
		$this->createGeneralTab();
		$this->height = 300;
	}
}