<?php

class FernandoMantoan_Auth_OAuth_Plugin extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$auth = Zend_Auth::getInstance();
		if (!$auth->hasIdentity()) {
			if ($request->getControllerName() != 'auth') {
				$request->setControllerName('auth');
				$request->setActionName('login');
				$request->setModuleName('default');
			}
		} else if ($request->getControllerName() == 'auth' && $request->getActionName() == 'login') {
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			$redirector->gotoSimple('index', 'bills');
		}
	}
}