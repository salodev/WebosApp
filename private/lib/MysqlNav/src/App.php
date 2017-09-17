<?php
/**
 * @author Salomón Córdova <salojc2006@gmail.com>
 * 
 * Edit your application here!
 */
namespace MysqlNav;
use Webos\Application;
use MysqlNav\Windows\Main;
use MysqlNav\Model\Connection;
use salodev\Mysql;

class App extends Application {
	
	private $_connection      = null;
	private $_connectionsList = [];
	
	public function getName(): string {
		return 'MyProject application';
	}

	public function getProvider(): string {
		return 'salojc2006';
	}

	public function getVersion(): string {
		return '0.0.0';
	}

	public function main(array $data = []) {
		$this->_connectionsList[] = new Connection('Localhost', 'localhost', 'root', 'root', null);
		$w = $this->openWindow(Main::class);
	}
	
	public function setup() {
		$this->configureDBConnection();
	}
	
	public function getConnectionsList() {
		return $this->_connectionsList;
	}
	
	public function setConnection(Connection $connection) {
		$this->_connection = $connection;
		$this->configureDBConnection();
	}
	
	public function getConnection() {
		return $this->_connection;
	}
	
	public function configureDBConnection() {
		if (empty($this->_connection)) {
			return;
		}
		$conn = $this->_connection;
		Mysql::SetDBConnection(
			$conn->host, 
			$conn->user, 
			$conn->pass, 
			$conn->db
		);
	}
}