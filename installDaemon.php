#!/usr/bin/php
<?php

require_once(dirname(__FILE__)) . '/private/start.php';

use salodev\Worker;
use salodev\IO;

class Installer {
	public $serviceName;
	public $serviceDescription;
	public $commandLine;
	public $userName;
	
	static public function Instance(): self {
		return new self;
	}
	
	public function getInfo() {
		IO::WriteLine('Please privide following data');
		IO::Write('Service name: ');
		IO::ReadLine(function($content) {
			$this->serviceName = $content;
			IO::Write('Short description: ');
			IO::ReadLine(function($content) {
				$this->serviceDescription = $content;
				IO::WriteLine('Command line to spawn service: ');
				IO::ReadLine(function($content) {
					$this->commandLine = $content;
					IO::WriteLine('User for your service (root): ');
					IO::ReadLine(function($content) {
						$this->userName = $content;
						$this->showData();
						IO::Write('This information is correct(yes/no)?');
						IO::ReadLine(function($content) {
							if ($content=='yes') {
								IO::WriteLine('Here start daemon installation!');
							} else {
								$this->getInfo();
							}
						});
					});
				});
			});
		});		
	}
	public function showData() {
		IO::WriteLine();
		IO::WriteLine('You have entered following data');
		IO::WriteLine("Service name     : {$this->serviceName}");
		IO::WriteLine("Short description: {$this->serviceDescription}");
		IO::WriteLine("Command line     : {$this->commandLine}");
		IO::WriteLine("User service     : {$this->userName}");
		IO::WriteLine();
	}
	
	public function start() {
		$this->getInfo();
		Worker::Start();
	}
	
	// public function 
}

Installer::Instance()->start();