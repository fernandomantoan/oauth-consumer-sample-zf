<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initMyLayout()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->headTitle('MinhasContas')
						  ->setSeparator(' | ');
	}
	
	protected function _initLogoutUrl()
	{
		$userServiceConfig = $this->getOption('userService');
		Zend_Registry::set('logoutUrl', $userServiceConfig['logout']);
	}
}