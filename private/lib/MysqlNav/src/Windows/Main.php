<?php

namespace MysqlNav\Windows;

use MysqlNav\Windows\Connections\Add as ConnectionAdd;
use MysqlNav\Model\Connection;
use Webos\Visual\Windows\Application as Window;
use Webos\Visual\Controls\TreeNode;
use Webos\Visual\Controls\TabFolder;
use salodev\Mysql;

class Main extends Window {
	
	public $_tabsList = [];
	
	public function initialize(array $params = []) {
		$this->title = 'MysqlNav dev';
		$m = $this->createMenuBar();
		$b = $m->createButton('Connections');
		$b->createItem('Add')->onClick(function() {
			$this->openWindow(ConnectionAdd::class);
		});
		$b->createItem('List');
		$b->createItem('Refresh');
		$b->createSeparator();
		$b->createItem('Exit')->onClick(function() {
			$this->getApplication()->finish();
		});
		
		$this->tree = $this->createTree([
			'top'   => 30,
			'width' => 200,
			'left'  => 0,
			'bottom' => 0,
		]);
		// $this->height = null;
		//$this->tree->height = null;
		
		$this->tabs = $this->createTabsFolder([
			'top'   => 30,
			'left' => 205,
			'right'  => 0,
			'bottom' => 0,
		]);
		
		$this->connectionsNode = $this->tree->addNode('Connections');
		$this->configNode = $this->tree->addNode('Config');

		$this->refreshConnections();
	}
	
	public function refreshConnections() {
		$list = $this->getApplication()->getConnectionsList();
		foreach($list as $item) {
			$node = $this->connectionsNode->addNode($item->name, [
				'connection' => $item
			]);
			$node->onExpand(function($data) {
				$node = $data['node'];
				if (!$node->loaded) {
					$this->setConnection($node->data['connection']);
					$rs = Mysql::GetData('SHOW DATABASES');
					foreach($rs as $row) {
						$newConnection = clone $node->data['connection'];
						$newConnection->db = $row['Database'];
						$nodeData = ['connection' => $newConnection];
						$dbNode = $node->addNode($row['Database']);
						$dbNode->addNode('Tables', $nodeData)->onClick(function($data) {
							$node = $data['node'];
							$this->setConnection($node->data['connection']);
							$this->createTablesTab($node->data['connection']);
						});
						$dbNode->addNode('Queries', $nodeData);
						$dbNode->addNode('Stored Procedures', $nodeData);
						$dbNode->addNode('Functions', $nodeData);
					}
					$node->loaded = true;
				}
			});
		}
	}
	
	public function setConnection(Connection $connection) {
		$this->getApplication()->setConnection($connection);
	}
	
	public function createTablesTab(Connection $connection){
		$dbName = $connection->db;
		if (isset($this->_tabsList[$dbName])) {
			$this->_tabsList[$dbName]->select();
			return;
		}
		
		$tab = $this->tabs->addClosableTab($dbName, [
			'connection' => $connection,
			'name' => $dbName,
		]);
		$this->_tabsList[$dbName] = $tab;
		
		$this->tabs->onClose(function($data) {
			$tabName = $data['tab']->name;
			unset($this->_tabsList[$tabName]);
		});
		
		$toolBar = $tab->createToolBar();
		$toolBar->createTextBox(['placeholder'=>'Search...'])->onLeaveTyping(function($source, $data) {
			$value = $data['value'];
			$tab = $source->getParentByClassName(TabFolder::class);
			$rs = Mysql::GetData($value ? 
					"SHOW TABLE STATUS LIKE '%{$value}%'":
					"SHOW TABLE STATUS");
			$tab->list->rows = $rs;
		});
		$toolBar->createButton('Refresh');
		$toolBar->createButton('New Table');
		$toolBar->createButton('Db Options...');
		$tab->list = $tab->createDataTable();
		
		$tab->list->addColumn('Name',           'Table'  )->width = 300;
		$tab->list->addColumn('Engine',         'Engine' );
		$tab->list->addColumn('Rows',           'Rows'   )->align = 'right';
		$tab->list->addColumn('Auto_increment', 'A/I'    )->align = 'right';
		$tab->list->addColumn('Create_time',    'Created');
		$tab->list->addColumn('Update_time',    'Updated');
		$tab->list->onContextMenu(function($data) {
			$menu = $data['menu'];
			$menu->createItem('Open table')->onClick(function($source) {
				$tab = $source->getParentWindow()->tabs->getActiveTab();
				$list = $tab->list;
				$connection = $tab->connection;
				$this->getApplication()->setConnection($connection);
				if (!$list->hasSelectedRow) {
					$tableName = $list->getSelectedRowData('Name');
					$this->createTableTab($connection, $tableName);
				}
			});
			$menu->createItem('Query..');
			$menu->createItem('Edit');
		});
		

		$rs = Mysql::GetData("SHOW TABLE STATUS");
		$tab->list->rows = $rs;
	}
	
	public function createTableTab(Connection $connection, $tableName) {
		$dbName = $connection->db;
		$tabName = "{$dbName}.{$tableName}";
		if (isset($this->_tabsList[$tabName])) {
			$this->_tabsList[$tabName]->select();
			return;
		}
		
		$tab = $this->tabs->addClosableTab($tabName, ['name'=>$tabName]);
		$this->_tabsList[$tabName] = $tab;
		
		$this->tabs->onClose(function($data) {
			$tabName = $data['tab']->name;
			unset($this->_tabsList[$tabName]);
		});
		
		$tab->list = $tab->createDataTable();
		$rs = Mysql::GetData("DESCRIBE {$tableName}");
		foreach($rs as $row) {
			$tab->list->addColumn($row['Field'], $row['Field']);
		}
		$rs = Mysql::Table($tableName)->limits(0, 100)->select();
		$tab->list->rows = $rs;
	}
}