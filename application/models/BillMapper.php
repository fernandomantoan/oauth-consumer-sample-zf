<?php

class Application_Model_BillMapper
{
	protected $_dbTable;
	
	public function __construct()
	{
		$this->_dbTable = new Application_Model_DbTable_Bill();
	}
	
	public function insert(Application_Model_Bill $bill)
	{
		$data = array('title' => $bill->getTitle(),
					  'price' => $bill->getPrice(),
					  'type' => $bill->getType(),
					  'user_id' => $bill->getUserId());
		$bill->setId($this->_dbTable->insert($data));
		return $bill;
	}
	
	public function update(Application_Model_Bill $bill)
	{
		$data = array('title' => $bill->getTitle(),
					  'price' => $bill->getPrice(),
					  'type' => $bill->getType(),
					  'user_id' => $bill->getUserId());
		$this->_dbTable->update($data, "id = {$bill->getId()}");
	}
	
	public function delete($id)
	{
		return $this->_dbTable->delete("id = {$id}");
	}
	
	public function findById($id)
	{
		if (empty($id))
			return null;
		
		$data = $this->_dbTable->find($id);
		$bill = new Application_Model_Bill($data[0]->toArray());
		return $bill;
	}
	
	public function findAll($userId)
	{
		$data = $this->_dbTable->fetchAll('user_id = ' . (int) $userId);
		
		$entries = array();
		
		foreach ($data as $entry) {
			$bill = new Application_Model_Bill($entry->toArray());
			array_push($entries, $bill);
		}
		
		$balance = new Application_Model_Balance($entries);
		
		return $balance;
	}
}