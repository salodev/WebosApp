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
		$connection = new Connection('Localhost', 'localhost', 'root', 'root', 'sg_template');
		$this->_connectionsList[] = $connection;
		$this->_connection = $connection;
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

		$mysqlConnection = new Mysql\Connection($conn->host, $conn->user, $conn->pass, $conn->db);
		Mysql::AddConnection('default', $mysqlConnection);
		/*Mysql::SetDBConnection(
			$conn->host, 
			$conn->user, 
			$conn->pass, 
			$conn->db
		);*/
	}
}