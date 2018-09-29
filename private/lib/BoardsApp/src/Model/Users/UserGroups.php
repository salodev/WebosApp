<?php

namespace BoardsApp\Model\Users;
use BoardsApp\Model\Repository;
use BoardsApp\Model\Exception;
use salodev\Mysql;

class UserGroups {
	
	use Repository;
	
	static public function GetList(int $offset = 0, int $limit = 0, array $filters = [], array $orders = [], array $options = []): array {
		$q = Mysql::Table('user_groups');
		$q->limits($offset, $limit);
		foreach($filters as $fieldName => $fieldValue) {
			if (in_array($fieldName, ['id', 'userID', 'groupID'])) {
				$q->filter($fieldName, $fieldValue);
			}
		}
		$list = $q->fetchObjects(UserGroup::class);
		foreach($list as $userGroup) {
			$userGroup->userName  = Users::GetByUserID($userGroup->userID)->name;
			$userGroup->groupName = Groups::Get($userGroup->groupID)->name;
		}
		
		return $list;
	}
	
	static public function Get(int $id): UserGroup {
		return self::GetUnique(['id' => $id]);
	}
	
	static public function GetListByUserID(int $userID, int $offset = 0, int $limit = 0, array $filters = [], array $orders = []): array {
		$filters['userID'] = $userID;
		return self::GetList($offset, $limit, $filters, $orders);
	}
	
	static public function Add(int $userID, int $groupID, string $role): UserGroup {
		Mysql::Transaction();
		
		$insertID = Mysql::Insert('user_groups', [
			'userID'  => $userID,
			'groupID' => $groupID,
			'role'    => $role,
		]);
		
		Mysql::Commit();
		
		return self::Get($insertID);
	}
	
	static public function Remove(int $id): bool {
		Mysql::Transaction();
		
		Mysql::Delete('user_groups', [
			'id' => $id,
		]);
		
		Mysql::Commit();
		return true;
	}
	
	static public function UpdateRole(int $id, string $role): bool {
		Mysql::Transaction();
		
		Mysql::Update('user_groups', [
			'id'   => $id,
			'role' => $role,
		], 'id');
		
		Mysql::Commit();
		return true;
	}
}