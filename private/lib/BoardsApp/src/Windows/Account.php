<?php

namespace BoardsApp\Windows;
use Webos\Visual\Window;

class Account extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'My Account';
		$this->createLabelBox('User Name', 'userName', ['width'=>200]);
		$this->createLabelBox('Name',      'name'    );
		$this->createLabelBox('Last Name', 'lastName');
		$this->createLabelBox('eMail',     'email'   );
		$user = $this->getApplication()->getUser();
		$this->setFormData((array) $user);
	}
}