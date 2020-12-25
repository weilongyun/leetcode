<?php
namespace com\bj58\spat\umc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class CreditItem{
	 static $_TSPEC;
	 static $_SCFNAME = 'UMC.CreditItem';

	private $count;
	private $description;
	private $action;
	private $amount;
	private $addTime;

	 public function __construct($count = '', $description = '', $action = '', $amount = '', $addTime = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'count',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'description',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'action',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'amount',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'addTime',
					'sortId' => 5,
					'type' => SCFType::DATE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CreditItem::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CreditItem::$_TSPEC = $_TSPEC;
	}

	public function getCount()
	{
		return $this->count;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function setAction($action)
	{
		$this->action = $action;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function getAddTime()
	{
		return $this->addTime;
	}

	public function setAddTime($addTime)
	{
		$this->addTime = $addTime;
	}


}