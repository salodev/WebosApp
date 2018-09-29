<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Window;
use BoardsApp\Model\Users\Users;

class UserAdd extends Window {
	
	public function createGeneralTab() {
		$tabs = $this->tabs;
		$tab = $this->tabGeneral =  $tabs->addTab('General');
		$tab->createTextBox('ID', 'id')->disable();
		$tab->createTextBox('Alias', 'userName', ['width'=>200]);
		$tab->createTextBox('Name', 'name');
		$tab->createTextBox('Email', 'email');
		$tab->createTextBox('Type', 'type');
		$tab->createWindowButton('Save')->onClick(function() {
			$data = $this->tabGeneral->getFormData();
			if (!empty($this->params['id'])) {
				Users::Edit($this->params['id'], $data['userName'], $data['name'], $data['email'], $data['type']);
			} else {
				$user = Users::Create($data['userName'], $data['name'], $data['email'], $data['type']);
				$this->close();
				$w = $this->openWindow(UserEdit::class, [
					'id' => $user->id,
				]);
				$w->top = $this->top;
				$w->left = $this->left;
			}
			$this->newData();
		});
		$tab->createWindowButton('Close')->closeWindow();
		
		if (!empty($this->params['id'])) {
			$userData = (array) Users::GetByUserID($this->params['id']);
			$this->tabGeneral->setFormData($userData);
		}
	}
	
	public function initialize(array $params = []) {
		$this->params = $params;
		$this->title = 'Add new user';
		$tabs = $this->tabs = $this->createTabsFolder();
		$this->createGeneralTab();
		$this->height = 300;
	}
}