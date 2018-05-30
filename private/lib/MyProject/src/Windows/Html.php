<?php

namespace MyProject\Windows;

use Webos\Visual\Window;
use Webos\Visual\Controls\HtmlContainer;

class Html extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Html example!';
		$container = $this->createObject(HtmlContainer::class, [
			'top' => 0,
			'left' => 0,
			'right' => 0,
			'bottom' => 0,
			'overflow-x'=>'scroll',
		]);
		
		$container->h1('Titulo del documento')->onClick(function() {
			$this->messageWindow('Hiciste click en el titulo');
		});
		$container->a('Section > Subsection')->onClick(function() {
			$this->messageWindow('Hiciste click en el subtitulo');
		});
		$container->br();
		$container->createButton('Editar', ['width'=>50])->onClick(function() {
			$this->messageWindow('No puedes editar este documento', 'Acceso denegado');
		});
		$container->br();
		$container->p('<b>Lorem Ipsum</b> es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.');
		$container->p('Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum.');
	}
	
		public function getAllowedActions(): array {
		return array_merge(parent::getAllowedActions(), ['scroll']);
	}
}