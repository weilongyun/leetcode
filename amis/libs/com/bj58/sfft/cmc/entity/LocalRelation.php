<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class LocalRelation{
	 static $_TSPEC;
	 static $_SCFNAME = 'LocalRelation';

	private $ID;
	private $LocalID;
	private $RelaLocalID;
	private $Order;

	 public function __construct($ID = '', $LocalID = '', $RelaLocalID = '', $Order = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ID',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'LocalID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'RelaLocalID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'Order',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return LocalRelation::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		LocalRelation::$_TSPEC = $_TSPEC;
	}

	public function getID()
	{
		return $this->ID;
	}

	public function setID($ID)
	{
		$this->ID = $ID;
	}

	public function getLocalID()
	{
		return $this->LocalID;
	}

	public function setLocalID($LocalID)
	{
		$this->LocalID = $LocalID;
	}

	public function getRelaLocalID()
	{
		return $this->RelaLocalID;
	}

	public function setRelaLocalID($RelaLocalID)
	{
		$this->RelaLocalID = $RelaLocalID;
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