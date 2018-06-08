<?php
require_once(__DIR__ . '/config.php');
require_once(PATH_AUTOLOAD);
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
use Webos\Implementations\Service;
use Webos\Implementations\Authentication;
Service::$dev = true;

Authentication::SetLoginFn(function ($username, $password) {
	return $username=='root' && $password=='root';
});

Authentication::SetRegisterFn(function (array $params) {
	foreach(['username','password','password2','email','email2'] as $name) {
		if (empty($params[$name])) {
			throw new Exception("The '{$name}' param is requried");
		}
		
		if ($params['username'] == 'root') {
			throw new Exception("Are you crazy?");
		}
		
		if ($params['password'] != $params['password2']) {
			throw new Exception("Please, repeat right the password");
		}
		
		if ($params['email'] != $params['email2']) {
			throw new Exception("Please, repeat right the email");
		}
		return true;
	}
});