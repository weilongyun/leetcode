<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class ParaControlValues2{
	 static $_TSPEC;
	 static $_SCFNAME = 'ParaControlValues2';

	private $ParaInstanceID;
	private $PID;
	private $ParameterID;
	private $LocalID;
	private $Value;
	private $Text;
	private $Order;
	private $State;
	private $ListName;

	 public function __construct($ParaInstanceID = '', $PID = '', $ParameterID = '', $LocalID = '', $Value = '', $Text = '', $Order = '', $State = '', $ListName = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ParaInstanceID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'PID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'ParameterID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'LocalID',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'Value',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'Text',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Order',
					'sortId' => 7,
					'type' => SCFType::I16,
				),

				8=>array(
					'var' => 'State',
					'sortId' => 8,
					'type' => SCFType::BYTE,
				),

				9=>array(
					'var' => 'ListName',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return ParaControlValues2::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ParaControlValues2::$_TSPEC = $_TSPEC;
	}

	public function getParaInstanceID()
	{
		return $this->ParaInstanceID;
	}

	public function setParaInstanceID($ParaInstanceID)
	{
		$this->ParaInstanceID = $ParaInstanceID;
	}

	public function getPID()
	{
		return $this->PID;
	}

	public function setPID($PID)
	{
		$this->PID = $PID;
	}

	public function getParameterID()
	{
		return $this->ParameterID;
	}

	public function setParameterID($ParameterID)
	{
		$this->ParameterID = $ParameterID;
	}

	public function getLocalID()
	{
		return $this->LocalID;
	}

	public function setLocalID($LocalID)
	{
		$this->LocalID = $LocalID;
	}

	public function getValue()
	{
		return $this->Value;
	}

	public function setValue($Value)
	{
		$this->Value = $Value;
	}

	public function getText()
	{
		return $this->Text;
	}

	public function setText($Text)
	{
		$this->Text = $Text;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}

	public function getState()
	{
		return $this->State;
	}

	public function setState($State)
	{
		$this->State = $State;
	}

	public function getListName()
	{
		return $this->ListName;
	}

	public function setListName($ListName)
	{
		$this->ListName = $ListName;
	}


}