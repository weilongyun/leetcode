<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class TagRela{
	 static $_TSPEC;
	 static $_SCFNAME = 'TagRela';

	private $TagRelaID;
	private $TagID;
	private $DispLocalID;
	private $IsCate;
	private $CateID;
	private $ObjectTypeValue;
	private $Order;

	 public function __construct($TagRelaID = '', $TagID = '', $DispLocalID = '', $IsCate = '', $CateID = '', $ObjectTypeValue = '', $Order = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'TagRelaID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'TagID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'DispLocalID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'IsCate',
					'sortId' => 4,
					'type' => SCFType::BOOL,
				),

				5=>array(
					'var' => 'CateID',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'ObjectTypeValue',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Order',
					'sortId' => 7,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return TagRela::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		TagRela::$_TSPEC = $_TSPEC;
	}

	public function getTagRelaID()
	{
		return $this->TagRelaID;
	}

	public function setTagRelaID($TagRelaID)
	{
		$this->TagRelaID = $TagRelaID;
	}

	public function getTagID()
	{
		return $this->TagID;
	}

	public function setTagID($TagID)
	{
		$this->TagID = $TagID;
	}

	public function getDispLocalID()
	{
		return $this->DispLocalID;
	}

	public function setDispLocalID($DispLocalID)
	{
		$this->DispLocalID = $DispLocalID;
	}

	public function getIsCate()
	{
		return $this->IsCate;
	}

	public function setIsCate($IsCate)
	{
		$this->IsCate = $IsCate;
	}

	public function getCateID()
	{
		return $this->CateID;
	}

	public function setCateID($CateID)
	{
		$this->CateID = $CateID;
	}

	public function getObjectTypeValue()
	{
		return $this->ObjectTypeValue;
	}

	public function setObjectTypeValue($ObjectTypeValue)
	{
		$this->ObjectTypeValue = $ObjectTypeValue;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}


}