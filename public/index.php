<?php
require_once(dirname(dirname(__FILE__)) . '/private/start.php');

use Webos\Implementations\Service;
use Webos\Implementations\Authentication;
Service::$dev = true;

Service::SetApplication('MyProject\App', []);

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

Service::Start();
