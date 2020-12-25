<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class DispLocal{
	 static $_TSPEC;
	 static $_SCFNAME = 'DispLocal';

	private $DispLocalID;
	private $PID;
	private $LocalName;
	private $LocalID;
	private $FullPath;
	private $ListName;
	private $IsVisible;
	private $Depth;
	private $Order;
	private $Type;

	 public function __construct($DispLocalID = '', $PID = '', $LocalName = '', $LocalID = '', $FullPath = '', $ListName = '', $IsVisible = '', $Depth = '', $Order = '', $Type = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'DispLocalID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'PID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'LocalName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'LocalID',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'FullPath',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'ListName',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'IsVisible',
					'sortId' => 7,
					'type' => SCFType::BOOL,
				),

				8=>array(
					'var' => 'Depth',
					'sortId' => 8,
					'type' => SCFType::I16,
				),

				9=>array(
					'var' => 'Order',
					'sortId' => 9,
					'type' => SCFType::I32,
				),

				10=>array(
					'var' => 'Type',
					'sortId' => 10,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return DispLocal::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		DispLocal::$_TSPEC = $_TSPEC;
	}

	public function getDispLocalID()
	{
		return $this->DispLocalID;
	}

	public function setDispLocalID($DispLocalID)
	{
		$this->DispLocalID = $DispLocalID;
	}

	public function getPID()
	{
		return $this->PID;
	}

	public function setPID($PID)
	{
		$this->PID = $PID;
	}

	public function getLocalName()
	{
		return $this->LocalName;
	}

	public function setLocalName($LocalName)
	{
		$this->LocalName = $LocalName;
	}

	public function getLocalID()
	{
		return $this->LocalID;
	}

	public function setLocalID($LocalID)
	{
		$this->LocalID = $LocalID;
	}

	public function getFullPath()
	{
		return $this->FullPath;
	}

	public function setFullPath($FullPath)
	{
		$this->FullPath = $FullPath;
	}

	public function getListName()
	{
		return $this->ListName;
	}

	public function setListName($ListName)
	{
		$this->ListName = $ListName;
	}

	public function getIsVisible()
	{
		return $this->IsVisible;
	}

	public function setIsVisible($IsVisible)
	{
		$this->IsVisible = $IsVisible;
	}

	public function getDepth()
	{
		return $this->Depth;
	}

	public function setDepth($Depth)
	{
		$this->Depth = $Depth;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}

	public function getType()
	{
		return $this->Type;
	}

	public function setType($Type)
	{
		$this->Type = $Type;
	}


}