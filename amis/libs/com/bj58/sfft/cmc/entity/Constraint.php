<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Constraint{
	 static $_TSPEC;
	 static $_SCFNAME = 'Constraint';

	private $OperationID;
	private $ControlObject;
	private $Case;
	private $Type;
	private $Object;
	private $ObjectCase;
	private $Order;

	 public function __construct($OperationID = '', $ControlObject = '', $Case = '', $Type = '', $Object = '', $ObjectCase = '', $Order = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'OperationID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'ControlObject',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'Case',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'Type',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

				5=>array(
					'var' => 'Object',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'ObjectCase',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Order',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Constraint::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Constraint::$_TSPEC = $_TSPEC;
	}

	public function getOperationID()
	{
		return $this->OperationID;
	}

	public function setOperationID($OperationID)
	{
		$this->OperationID = $OperationID;
	}

	public function getControlObject()
	{
		return $this->ControlObject;
	}

	public function setControlObject($ControlObject)
	{
		$this->ControlObject = $ControlObject;
	}

	public function getCase()
	{
		return $this->Case;
	}

	public function setCase($Case)
	{
		$this->Case = $Case;
	}

	public function getType()
	{
		return $this->Type;
	}

	public function setType($Type)
	{
		$this->Type = $Type;
	}

	public function getObject()
	{
		return $this->Object;
	}

	public function setObject($Object)
	{
		$this->Object = $Object;
	}

	public function getObjectCase()
	{
		return $this->ObjectCase;
	}

	public function setObjectCase($ObjectCase)
	{
		$this->ObjectCase = $ObjectCase;
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