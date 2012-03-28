<?php

class Zend_View_Helper_LogoutUrl extends Zend_View_Helper_Abstract
{
	public function logoutUrl()
	{
		return Zend_Registry::get('logoutUrl');
	}
}