<?php

namespace BoardsApp\Windows\Issues;
use Webos\Visual\Window;
use Webos\Visual\Controls\TextBox;

class AddComment extends Window {
	
	public function initialize(array $params = []) {
		$this->title = 'Add comment for issue..';
		$this->width=440;
		$t = $this->createObject(TextBox::class, [
			'multiline' => true,
			'top' => 0,
			'width' => '100%',
			'bottom' => 35,
		]);
		$buttonsBar = $this->createButtonsBar();
		$buttonsBar->addButton('Add');
		$buttonsBar->addButton('Cancel')->closeWindow();
		$this->height = 200;
		$t->focus();
		
		$this->onKeyEscape(function() {
			$this->close();
		});
		
		$this->onKeyF5(function() {
			$this->messageWindow('Apretaste F5')->onKeyEscape(function($source) {
				$source->close();
			});
		});
	}
}