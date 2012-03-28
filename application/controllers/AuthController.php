<?php

class AuthController extends Zend_Controller_Action
{
	protected $_oauthConfig;
	
	protected $_oauthConsumer = null;
	
	protected $_session = null;
	
	public function init()
	{
		$oauthParams = $this->getInvokeArg('bootstrap')->getOption('oauth');
		$this->_session = new Zend_Session_Namespace('oauth');
		$this->_oauthConfig = array('callbackUrl' => $oauthParams['callback'], 
					'siteUrl' => $oauthParams['siteUrl'], 
					'consumerKey' => $oauthParams['consumerKey'], 
					'consumerSecret' => $oauthParams['consumerSecret']);
		
		$this->_oauthConsumer = new Zend_Oauth_Consumer($this->_oauthConfig);
		$this->_oauthConsumer->setAuthorizeUrl($oauthParams['authorizeUrl']);
	}
	
	public function indexAction()
	{
		return $this->_helper->redirector('login');
	}
	
	public function loginAction()
	{
		$token = $this->_oauthConsumer->getRequestToken();
		
		$this->_session->token = serialize($token);
		$this->_oauthConsumer->redirect();
	}
	
	public function callbackAction()
	{
		$sessionToken = $this->_session->token;
		$get = $this->getRequest()->getQuery();
		
		if (sizeof($get) > 0 && ! empty($sessionToken)) {
			$token = $this->_oauthConsumer->getAccessToken($get, unserialize($sessionToken));
			
			$this->_session->accessToken = serialize($token);
			unset($this->_session->token);
			
			$userServiceConfig = $this->getInvokeArg('bootstrap')->getOption('userService');
			
			$httpClient = $token->getHttpClient($this->_oauthConfig);
			$httpClient->setUri($userServiceConfig['endpoint']);
			$httpClient->setMethod(Zend_Http_Client::POST);
			$response = $httpClient->request();
			
			Zend_Auth::getInstance()->getStorage()->write(Zend_Json::decode($response->getBody(), Zend_Json::TYPE_OBJECT)->user);
			return $this->_helper->redirector('index', 'bills');
		} else {
			exit('Erro ao efetuar a autorização');
		}
	}
	
	public function logoutAction()
	{
		Zend_Auth::getInstance()->clearIdentity();
		return $this->_helper->redirector('index');
	}
}