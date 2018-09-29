<?php

namespace BoardsApp\Model\Users;
use BoardsApp\Model\Repository;
use BoardsApp\Model\Exception;
use salodev\Mysql;

class Users {
	
	static public function GetList(int $offset = 0, int $limit = 0, array $filters = [], array $orders = [], array $options = []): array {
		$q = Mysql::Table('users');
		$q->limits($offset, $limit);
		foreach($filters as $fieldName => $fieldValue) {
			if (in_array($fieldName, ['userName', 'id', 'email'])) {
				$q->filter($fieldName, $fieldValue);
			}
			if ($fieldName == 'userID NOT') {
				$q->customFilter("id NOT IN('{$fieldValue}')");
			}
		}
		return $q->fetchObjects(User::class);
	}
	
	static public function GetUnique(array $filters = [], array $orders = []): User {
		$rs = self::GetList(0, 1, $filters, $orders);
		if (!count($rs)) {
			throw new Exception('Record not foud!');
		}
		return $rs[0];
	}
	
	static public function GetByUserID(int $userID): User {
		return self::GetUnique(['id' => $userID]);
	}
	
	static public function GetByUserName(string $userName): User {
		return self::GetUnique(['userName'=>$userName]);
	}
	
	static public function Create(string $userName, string $name, string $email, string $type): User {
		Mysql::Transaction();
		$rs = self::GetList(0, 1, [
			'email' => $email,
		]);
		if (count($rs)) {
			throw new \Exception('User email already exists. Please try another');
		}
		
		$rs = self::GetList(0, 1, [
			'userName' => $userName,
		]);
		if (count($rs)) {
			throw new \Exception('UserName already exists. Please try another');
		}
		
		$insertID = Mysql::Insert('users', [
			'userName' => $userName,
			'name'     => $name,
			'email'    => $email,
			'type'     => $type,
			'seed'     => md5(time()),
		]);
		
		Mysql::Commit();
		
		return self::GetByUserID($insertID);
	}
	
	static public function Edit(int $userID, string $userName, string $name, string $email, string $type): User {
		Mysql::Transaction();
		$rs = self::GetList(0, 1, [
			'email' => $email,
			'userID NOT' => $userID,
		]);
		if (count($rs)) {
			throw new \Exception('User email already exists. Please try another');
		}
		
		$rs = self::GetList(0, 1, [
			'userName' => $userName,
			'userID NOT' => $userID,
		]);
		if (count($rs)) {
			throw new \Exception('UserName already exists. Please try another');
		}
		
		Mysql::Update('users', [
			'id'       => $userID,
			'userName' => $userName,
			'name'     => $name,
			'email'    => $email,
			'type'     => $type,
			'seed'     => md5(time()),
		], 'id');
		
		Mysql::Commit();
		
		return self::GetByUserID($userID);
	}
	
	static public function Activate(int $userID): bool {
		Mysql::Update('users', [
			'id'       => $userID,
			'status' => 'ACTIVE',
		], 'id');
		return true;
	}
	
	static public function Block(int $userID): bool {
		Mysql::Update('users', [
			'id'       => $userID,
			'status' => 'BLOCKED',
		], 'id');
		return true;
	}
	
	static public function MarkDeleted(int $userID): bool {
		Mysql::Update('users', [
			'id'       => $userID,
			'status' => 'DELETED',
		], 'id');
		return true;
	}
}