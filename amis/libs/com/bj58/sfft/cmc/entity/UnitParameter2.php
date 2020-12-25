<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class UnitParameter2{
	 static $_TSPEC;
	 static $_SCFNAME = 'UnitParameter2';

	private $ParameterID;
	private $PID;
	private $CateID;
	private $ParameterName;
	private $ValueType;
	private $Length;
	private $Default;
	private $Null;
	private $Order;
	private $CreateControlType;
	private $Unit;
	private $Describe;
	private $IsCreateIndex;
	private $State;
	private $UnitParameterRegexs;

	 public function __construct($ParameterID = '', $PID = '', $CateID = '', $ParameterName = '', $ValueType = '', $Length = '', $Default = '', $Null = '', $Order = '', $CreateControlType = '', $Unit = '', $Describe = '', $IsCreateIndex = '', $State = '', $UnitParameterRegexs = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ParameterID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'PID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'CateID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'ParameterName',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'ValueType',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'Length',
					'sortId' => 6,
					'type' => SCFType::I16,
				),

				7=>array(
					'var' => 'Default',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'Null',
					'sortId' => 8,
					'type' => SCFType::BOOL,
				),

				9=>array(
					'var' => 'Order',
					'sortId' => 9,
					'type' => SCFType::I16,
				),

				10=>array(
					'var' => 'CreateControlType',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'Unit',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'Describe',
					'sortId' => 12,
					'type' => SCFType::STRING,
				),

				13=>array(
					'var' => 'IsCreateIndex',
					'sortId' => 13,
					'type' => SCFType::BOOL,
				),

				14=>array(
					'var' => 'State',
					'sortId' => 14,
					'type' => SCFType::BYTE,
				),

				15=>array(
					'var' => 'UnitParameterRegexs',
					'sortId' => 15,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new UnitParameterRegex(),
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return UnitParameter2::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		UnitParameter2::$_TSPEC = $_TSPEC;
	}

	public function getParameterID()
	{
		return $this->ParameterID;
	}

	public function setParameterID($ParameterID)
	{
		$this->ParameterID = $ParameterID;
	}

	public function getPID()
	{
		return $this->PID;
	}

	public function setPID($PID)
	{
		$this->PID = $PID;
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

	public function getNull()
	{
		return $this->Null;
	}

	public function setNull($Null)
	{
		$this->Null = $Null;
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

	public function getState()
	{
		return $this->State;
	}

	public function setState($State)
	{
		$this->State = $State;
	}

	public function getUnitParameterRegexs()
	{
		return $this->UnitParameterRegexs;
	}

	public function setUnitParameterRegexs($UnitParameterRegexs)
	{
		$this->UnitParameterRegexs = $UnitParameterRegexs;
	}


}