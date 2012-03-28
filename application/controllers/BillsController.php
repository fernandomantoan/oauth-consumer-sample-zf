<?php

class BillsController extends Zend_Controller_Action
{
	protected $_mapper;
	
	public function init()
	{
		$this->_mapper = new Application_Model_BillMapper();
	}
	
	public function indexAction()
	{
		$this->view->balance = $this->_mapper->findAll($this->_getUser()->id);
	}
	
	public function addAction()
	{
		$this->view->headTitle('Add Finance', 'PREPEND');
		$form = new Application_Form_Bill();
		
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			if ($form->isValid($data)) {
				$bill = new Application_Model_Bill($form->getValues());
				$bill->setUserId($this->_getUser()->id);
				
				$this->_mapper->insert($bill);
				
				$this->_helper->FlashMessenger(array('type' => 'success', 'message' => 'Finance inserted successfully'));
				return $this->_helper->redirector('index');
			}
		}
		
		$this->view->form = $form;
	}
	
	public function editAction()
	{
		$this->view->headTitle('Edit Finance', 'PREPEND');
		$form = new Application_Form_Bill();
		
		if ($this->getRequest()->isPost()) {
			$data = $this->getRequest()->getPost();
			
			if ($form->isValid($data)) {
				$bill = new Application_Model_Bill($form->getValues());
				$bill->setUserId($this->_getUser()->id);
			
				$this->_mapper->update($bill);
			
				$this->_helper->FlashMessenger(array('type' => 'success', 'message' => 'Finance updated successfully'));
				return $this->_helper->redirector('index');
			}
		} else {
			$id = $this->_getParam('id', null);
			
			$bill = $this->_mapper->findById($id);
			
			if (is_null($bill))
				return $this->_helper->redirector('index');
			
			$form->populate($bill->toArray());
		}
		
		$this->view->form = $form;
	}
	
	public function deleteAction()
	{
		$id = $this->_getParam('id', null);
		
		if (!is_null($id)) {
			if ($this->_mapper->delete($id)) {
				$this->_helper->FlashMessenger(array('type' => 'success', 'message' => 'Finance removed successfully'));
			}
			return $this->_helper->redirector('index');
		}
	}
	
	protected function _getUser()
	{
		return Zend_Auth::getInstance()->getIdentity();
	}
}