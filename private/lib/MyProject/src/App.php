<?php
/**
 * @author Salomón Córdova <salojc2006@gmail.com>
 * 
 * Edit your application here!
 */
namespace MyProject;
use Webos\Application;
use MyProject\Windows\Main as MainWindow;

class App extends Application {
	
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
		$this->openWindow(MainWindow::class);
		$this->openMessageWindow('Hello!', 'Welcome to your first Office Application!');
	}

}