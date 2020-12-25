<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfft\cmc\entity\ParaControlValues;

class UnitParameter{
	 static $_TSPEC;
	 static $_SCFNAME = 'UnitParameter';

	private $ParameterID;
	private $CateID;
	private $ParameterName;
	private $ValueType;
	private $Length;
	private $Default;
	private $Order;
	private $CreateControlType;
	private $Unit;
	private $Describe;
	private $IsCreateIndex;
	private $UnitParameterRegexs;
	private $ParaControlValuess;

	 public function __construct($ParameterID = '', $CateID = '', $ParameterName = '', $ValueType = '', $Length = '', $Default = '', $Order = '', $CreateControlType = '', $Unit = '', $Describe = '', $IsCreateIndex = '', $UnitParameterRegexs = '', $ParaControlValuess = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ParameterID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'CateID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'ParameterName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'ValueType',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'Length',
					'sortId' => 5,
					'type' => SCFType::I16,
				),

				6=>array(
					'var' => 'Default',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Order',
					'sortId' => 7,
					'type' => SCFType::I16,
				),

				8=>array(
					'var' => 'CreateControlType',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'Unit',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'Describe',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'IsCreateIndex',
					'sortId' => 11,
					'type' => SCFType::BOOL,
				),

				12=>array(
					'var' => 'UnitParameterRegexs',
					'sortId' => 12,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new UnitParameterRegex(),
					),
				),

				13=>array(
					'var' => 'ParaControlValuess',
					'sortId' => 13,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new ParaControlValues(),
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return UnitParameter::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		UnitParameter::$_TSPEC = $_TSPEC;
	}

	public function getParameterID()
	{
		return $this->ParameterID;
	}

	public function setParameterID($ParameterID)
	{
		$this->ParameterID = $ParameterID;
	}

	public function getCateID()
	{
		return $this->CateID;
	}

	public function setCateID($CateID)
	{
		$this->CateID = $CateID;
	}

	public function getParameterName()
	{
		return $this->ParameterName;
	}

	public function setParameterName($ParameterName)
	{
		$this->ParameterName = $ParameterName;
	}

	public function getValueType()
	{
		return $this->ValueType;
	}

	public function setValueType($ValueType)
	{
		$this->ValueType = $ValueType;
	}

	public function getLength()
	{
		return $this->Length;
	}

	public function setLength($Length)
	{
		$this->Length = $Length;
	}

	public function getDefault()
	{
		return $this->Default;
	}

	public function setDefault($Default)
	{
		$this->Default = $Default;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}

	public function getCreateControlType()
	{
		return $this->CreateControlType;
	}

	public function setCreateControlType($CreateControlType)
	{
		$this->CreateControlType = $CreateControlType;
	}

	public function getUnit()
	{
		return $this->Unit;
	}

	public function setUnit($Unit)
	{
		$this->Unit = $Unit;
	}

	public function getDescribe()
	{
		return $this->Describe;
	}

	public function setDescribe($Describe)
	{
		$this->Describe = $Describe;
	}

	public function getIsCreateIndex()
	{
		return $this->IsCreateIndex;
	}

	public function setIsCreateIndex($IsCreateIndex)
	{
		$this->IsCreateIndex = $IsCreateIndex;
	}

	public function getUnitParameterRegexs()
	{
		return $this->UnitParameterRegexs;
	}

	public function setUnitParameterRegexs($UnitParameterRegexs)
	{
		$this->UnitParameterRegexs = $UnitParameterRegexs;
	}

	public function getParaControlValuess()
	{
		return $this->ParaControlValuess;
	}

	public function setParaControlValuess($ParaControlValuess)
	{
		$this->ParaControlValuess = $ParaControlValuess;
	}


}