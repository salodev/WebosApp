<?php

namespace BoardsApp\Windows\Users;
use Webos\Visual\Windows\DataSeeker;
use BoardsApp\Model\Users\Users;

class UserListSeeker extends DataSeeker {
	
	public function initialize(array $params = []) {
		parent::initialize($params);
		$this->title = 'Users List';
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
	}
	
	public function getData(): array {
		return Users::GetList(0, 30);
	}
}