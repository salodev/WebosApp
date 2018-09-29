<?php
/**
 * @author Salomón Córdova <salojc2006@gmail.com>
 * 
 * Edit your application here!
 */
namespace BoardsApp;

use Webos\Application;
use BoardsApp\Windows\Main;
use BoardsApp\Model\Users\Users;
use BoardsApp\Model\Users\User;
use salodev\Mysql;

class App extends Application {
	
	private $_user = null;
	
	public function getName(): string {
		return 'Boards and Tasks';
	}

	public function getProvider(): string {
		return 'salojc2006';
	}

	public function getVersion(): string {
		return '0.0.0';
	}

	public function main(array $data = []) {
		$this->setup();
		$this->authUser();
		
		$w = $this->openWindow(Main::class);
	}
	
	public function setup() {
		$this->setDBConnection();
	}
	
	public function setDBConnection() {
		$mysqlConnection = new Mysql\Connection('localhost', 'root', 'root', 'boards_app');
		Mysql::AddConnection('default', $mysqlConnection);
	}
	
	public function authUser() {
		$userName = $this->getWorkSpace()->getName();
		$user = Users::GetByUserName($userName);
		$this->setUser($user);
	}
	
	public function setUser(User $user) {
		$this->_user = $user;
	}
	
	public function getUser(): User {
		return $this->_user;
	}
}