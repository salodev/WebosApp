<?php
spl_autoload_register(function($className) {
	$baseDir = __DIR__;
	$className = str_replace('\\','/', $className);
	
	$parts = explode('/', $className);
	
	$baseNamespace = array_shift($parts);
	
	array_unshift($parts, $baseNamespace, 'src');
	
	$classFile = $baseDir . '/' . implode('/', $parts) . '.php';
	
    if (file_exists($classFile)) {
        require_once($classFile);
		return;
	}	
	$interfaceFile = "{$baseDir}/{$className}.interface.php";
	if (file_exists($interfaceFile)) {
		require_once($interfaceFile);
	}
});
