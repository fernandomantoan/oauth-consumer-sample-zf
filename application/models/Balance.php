<?php

class Application_Model_Balance
{
	const POSITIVE_BALANCE = 'positive';
	const NEGATIVE_BALANCE = 'negative';
	
	private $_debit;
	private $_credit;
	private $_balance;
	private $_bills;
	private $_balanceType;
	
	public function __construct(array $bills)
	{
		$this->setBills($bills);
		$this->calculate();
	}
	
	public function getDebit()
	{
		return $this->_debit;
	}

	public function setDebit($_debit)
	{
		$this->_debit = $_debit;
	}

	public function getCredit()
	{
		return $this->_credit;
	}

	public function setCredit($_credit)
	{
		$this->_credit = $_credit;
	}

	public function getBalance()
	{
		return $this->_balance;
	}

	public function setBalance($_balance)
	{
		$this->_balance = $_balance;
	}
	
	public function getBills()
	{
		return $this->_bills;
	}
	
	public function setBills(array $bills)
	{
		$this->_bills = $bills;
	}
	
	public function getBalanceType()
	{
		return $this->_balanceType;
	}

	public function setBalanceType($_balanceType)
	{
		$this->_balanceType = $_balanceType;
	}

	protected function calculate()
	{
		$this->_debit = 0;
		$this->_credit = 0;
		$this->_balance = 0;
		$this->_balanceType = self::POSITIVE_BALANCE;
		if (sizeof($this->_bills) > 0) {
			
			foreach ($this->_bills as $bill) {
				if ($bill->getType() == Application_Model_BillType::CREDIT)
					$this->_credit += $bill->getPrice();
				else
					$this->_debit += $bill->getPrice();
			}
			
			$this->_balance = $this->_credit - $this->_debit;
			
			$this->_balanceType = ($this->_balance >= 0) ? self::POSITIVE_BALANCE : self::NEGATIVE_BALANCE;
		}
	}
}