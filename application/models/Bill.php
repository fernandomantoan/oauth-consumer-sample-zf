<?php

class Application_Model_Bill
{
	private $_id;
	private $_title;
	private $_price;
	private $_type;
	private $_userId;
	
	public function __construct(array $data)
	{
		if (isset($data['id'])) {
			$this->setId($data['id']);
		}
		$this->setTitle($data['title']);
		$this->setPrice($data['price']);
		$this->setType($data['type']);
	}
	
	public function getId()
	{
		return $this->_id;
	}

	public function setId($id)
	{
		$this->_id = $id;
	}

	public function getTitle()
	{
		return $this->_title;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
	}

	public function getPrice()
	{
		return $this->_price;
	}

	public function setPrice($price)
	{
		$this->_price = $price;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function setType($type)
	{
		$this->_type = $type;
	}
	
	public function getUserId()
	{
		return $this->_userId;
	}

	public function setUserId($_userId)
	{
		$this->_userId = $_userId;
	}
	
	public function toArray()
	{
		$data = array('id' => $this->getId(),
					  'title' => $this->getTitle(),
					  'price' => $this->getPrice(),
					  'type' => $this->getType());
		return $data;
	}
}