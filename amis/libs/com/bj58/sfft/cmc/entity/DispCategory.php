<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfft\cmc\entity\DispBiz;

class DispCategory{
	 static $_TSPEC;
	 static $_SCFNAME = 'DispCategory';

	private $DispCategoryID;
	private $PID;
	private $CateName;
	private $DispCategoryGroup;
	private $Depth;
	private $FullPath;
	private $Order;
	private $CateID;
	private $Filter;
	private $ListName;
	private $System;
	private $Type;
	private $IsVisible;
	private $CateidList;
	private $BusinessType;
	private $Conditions;
	private $DispBiz;
	private $InfoCateidList;

	 public function __construct($DispCategoryID = '', $PID = '', $CateName = '', $DispCategoryGroup = '', $Depth = '', $FullPath = '', $Order = '', $CateID = '', $Filter = '', $ListName = '', $System = '', $Type = '', $IsVisible = '', $CateidList = '', $BusinessType = '', $Conditions = '', $DispBiz = '', $InfoCateidList = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'DispCategoryID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'PID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'CateName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'DispCategoryGroup',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'Depth',
					'sortId' => 5,
					'type' => SCFType::I16,
				),

				6=>array(
					'var' => 'FullPath',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Order',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'CateID',
					'sortId' => 8,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'Filter',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'ListName',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'System',
					'sortId' => 11,
					'type' => SCFType::I16,
				),

				12=>array(
					'var' => 'Type',
					'sortId' => 12,
					'type' => SCFType::I16,
				),

				13=>array(
					'var' => 'IsVisible',
					'sortId' => 13,
					'type' => SCFType::BOOL,
				),

				14=>array(
					'var' => 'CateidList',
					'sortId' => 14,
					'type' => SCFType::STRING,
				),

				15=>array(
					'var' => 'BusinessType',
					'sortId' => 15,
					'type' => SCFType::I32,
				),

				16=>array(
					'var' => 'Conditions',
					'sortId' => 16,
					'type' => SCFType::STRING,
				),

				17=>array(
					'var' => 'DispBiz',
					'sortId' => 17,
					'type' => SCFType::OBJECT,
					'class' => new DispBiz(),
				),

				18=>array(
					'var' => 'InfoCateidList',
					'sortId' => 18,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return DispCategory::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		DispCategory::$_TSPEC = $_TSPEC;
	}

	public function getDispCategoryID()
	{
		return $this->DispCategoryID;
	}

	public function setDispCategoryID($DispCategoryID)
	{
		$this->DispCategoryID = $DispCategoryID;
	}

	public function getPID()
	{
		return $this->PID;
	}

	public function setPID($PID)
	{
		$this->PID = $PID;
	}

	public function getCateName()
	{
		return $this->CateName;
	}

	public function setCateName($CateName)
	{
		$this->CateName = $CateName;
	}

	public function getDispCategoryGroup()
	{
		return $this->DispCategoryGroup;
	}

	public function setDispCategoryGroup($DispCategoryGroup)
	{
		$this->DispCategoryGroup = $DispCategoryGroup;
	}

	public function getDepth()
	{
		return $this->Depth;
	}

	public function setDepth($Depth)
	{
		$this->Depth = $Depth;
	}

	public function getFullPath()
	{
		return $this->FullPath;
	}

	public function setFullPath($FullPath)
	{
		$this->FullPath = $FullPath;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}

	public function getCateID()
	{
		return $this->CateID;
	}

	public function setCateID($CateID)
	{
		$this->CateID = $CateID;
	}

	public function getFilter()
	{
		return $this->Filter;
	}

	public function setFilter($Filter)
	{
		$this->Filter = $Filter;
	}

	public function getListName()
	{
		return $this->ListName;
	}

	public function setListName($ListName)
	{
		$this->ListName = $ListName;
	}

	public function getSystem()
	{
		return $this->System;
	}

	public function setSystem($System)
	{
		$this->System = $System;
	}

	public function getType()
	{
		return $this->Type;
	}

	public function setType($Type)
	{
		$this->Type = $Type;
	}

	public function getIsVisible()
	{
		return $this->IsVisible;
	}

	public function setIsVisible($IsVisible)
	{
		$this->IsVisible = $IsVisible;
	}

	public function getCateidList()
	{
		return $this->CateidList;
	}

	public function setCateidList($CateidList)
	{
		$this->CateidList = $CateidList;
	}

	public function getBusinessType()
	{
		return $this->BusinessType;
	}

	public function setBusinessType($BusinessType)
	{
		$this->BusinessType = $BusinessType;
	}

	public function getConditions()
	{
		return $this->Conditions;
	}

	public function setConditions($Conditions)
	{
		$this->Conditions = $Conditions;
	}

	public function getDispBiz()
	{
		return $this->DispBiz;
	}

	public function setDispBiz($DispBiz)
	{
		$this->DispBiz = $DispBiz;
	}

	public function getInfoCateidList()
	{
		return $this->InfoCateidList;
	}

	public function setInfoCateidList($InfoCateidList)
	{
		$this->InfoCateidList = $InfoCateidList;
	}


}