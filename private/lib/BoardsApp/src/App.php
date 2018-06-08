<?php
/**
 * @author Salomón Córdova <salojc2006@gmail.com>
 * 
 * Edit your application here!
 */
namespace BoardsApp;

use Webos\Application;
use BoardsApp\Windows\Main;
use salodev\Mysql;

class App extends Application {
	
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
		$w = $this->openWindow(Main::class);
	}
	
	public function setup() {
		$this->setDBConnection();
	}
	
	public function setDBConnection() {
		return;
		$mysqlConnection = new Mysql\Connection($conn->host, $conn->user, $conn->pass, $conn->db);
		Mysql::AddConnection('default', $mysqlConnection);
	}
}