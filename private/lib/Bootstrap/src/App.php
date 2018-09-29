<?php

namespace Bootstrap;
use Webos\Application;
use Webos\Visual\BootstrapUI\PageWrapper;
use Webos\Visual\BootstrapUI\WebPage;
use Webos\Visual\BootstrapUI\Form\Form;
use Webos\Visual\BootstrapUI\Form\Text;
use Webos\Visual\BootstrapUI\Form\Password;
use Webos\Visual\BootstrapUI\Form\Button;
use Webos\Visual\BootstrapUI\Bar;

class App extends Application {
	public function main(array $data = []) {
		$this->getWorkSpace()->setPageWrapper(new PageWrapper);
		$w = $this->openWindow(WebPage::class);
		$b = $w->createObject(Bar::class)->setTitle('Test bar');
		$f = $w->createObject(Form::class);
		$f->createObject(Text::class, ['label'=>'usuario']);
		$f->createObject(Password::class, ['label'=>'clave']);
		$button = $f->createObject(Button::class, ['text'=>'login', 'color'=>'primary']);
		$button->onClick(function() {
			$this->openMessageWindow('hola', 'hola');
		});
	}

	public function getName(): string {
		return 'BootstrapApp';
	}

	public function getVersion(): string {
		return '1';
		
	}

	public function getProvider(): string {
		return 'salojc2006';
	}
}