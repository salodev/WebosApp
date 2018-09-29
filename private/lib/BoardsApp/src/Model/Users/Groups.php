<?php

namespace BoardsApp\Model\Users;
use BoardsApp\Model\Repository;
use BoardsApp\Model\Exception;
use salodev\Mysql;

class Groups {
	
	use Repository;
	
	static public function GetList(int $offset = 0, int $limit = 0, array $filters = [], array $orders = [], array $options = []): array {
		$q = Mysql::Table('groups');
		$q->limits($offset, $limit);
		foreach($filters as $fieldName => $fieldValue) {
			if (in_array($fieldName, ['id', 'status'])) {
				$q->filter($fieldName, $fieldValue);
			}
		}
		return $q->fetchObjects(Group::class);
	}
	
	static public function Get(int $id): Group {
		return self::GetUnique(['id' => $id]);
	}
	
	static public function Create(string $name, string $description): Group {
		Mysql::Transaction();
		
		$insertID = Mysql::Insert('groups', [
			'name'        => $name,
			'description' => $description,
		]);
		
		Mysql::Commit();
		
		return self::Get($insertID);
	}
}