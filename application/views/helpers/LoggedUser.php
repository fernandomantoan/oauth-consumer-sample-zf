<?php

class Zend_View_Helper_LoggedUser extends Zend_View_Helper_Abstract
{
	public function loggedUser()
	{
		$user = Zend_Auth::getInstance()->getIdentity();
		return $user->realname;
	}
}