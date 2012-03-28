<?php

class Zend_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract
{
	public function flashMessenger()
	{
		$flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		$messages = $flashMessenger->getMessages();
		if (sizeof($messages) > 0)
			return $this->_createHTMLDiv($messages[0]['message'], $messages[0]['type']);
		
		return null;
	}
	
	protected function _createHTMLDiv($message, $type)
	{
		$div = <<<DIV
			<div class="$type">
				$message
			</div>
DIV;
		return $div;
	}
}