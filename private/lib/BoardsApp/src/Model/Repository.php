<?php

namespace BoardsApp\Model;

trait Repository {
	
	static public function GetUnique(array $filters = [], array $orders = []) {
		$rs = self::GetList(0, 1, $filters, $orders);
		if (!count($rs)) {
			throw new Exception('Record not foud!');
		}
		return $rs[0];
	}
	
}