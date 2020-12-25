<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class ParaControlValues{
	 static $_TSPEC;
	 static $_SCFNAME = 'ParaControlValues';

	private $ParaInstanceID;
	private $ParameterID;
	private $LocalID;
	private $Value;
	private $Text;
	private $Order;

	 public function __construct($ParaInstanceID = '', $ParameterID = '', $LocalID = '', $Value = '', $Text = '', $Order = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ParaInstanceID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'ParameterID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'LocalID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'Value',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'Text',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'Order',
					'sortId' => 6,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return ParaControlValues::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ParaControlValues::$_TSPEC = $_TSPEC;
	}

	public function getParaInstanceID()
	{
		return $this->ParaInstanceID;
	}

	public function setParaInstanceID($ParaInstanceID)
	{
		$this->ParaInstanceID = $ParaInstanceID;
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


}