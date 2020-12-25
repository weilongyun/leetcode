<?php
namespace com\bj58\sfft\imc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Info{
	 static $_TSPEC;
	 static $_SCFNAME = 'Info';

	private $InfoID;
	private $Content;
	private $Title;
	private $CateID;
	private $UserID;
	private $UserIP;
	private $Pic;
	private $AddDate;
	private $PostDate;
	private $EffectiveDate;
	private $State;
	private $Source;
	private $Tag;
	private $Phone;
	private $Email;
	private $IM;
	private $HideItem;
	private $SortID;
	private $InfoType;
	private $IsBiz;
	private $UserTag;
	private $Url;
	private $Locals;
	private $Params;

	 public function __construct($InfoID = '', $Content = '', $Title = '', $CateID = '', $UserID = '', $UserIP = '', $Pic = '', $AddDate = '', $PostDate = '', $EffectiveDate = '', $State = '', $Source = '', $Tag = '', $Phone = '', $Email = '', $IM = '', $HideItem = '', $SortID = '', $InfoType = '', $IsBiz = '', $UserTag = '', $Url = '', $Locals = '', $Params = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'InfoID',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'Content',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'Title',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'CateID',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'UserID',
					'sortId' => 5,
					'type' => SCFType::I64,
				),

				6=>array(
					'var' => 'UserIP',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Pic',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'AddDate',
					'sortId' => 8,
					'type' => SCFType::DATE,
				),

				9=>array(
					'var' => 'PostDate',
					'sortId' => 9,
					'type' => SCFType::DATE,
				),

				10=>array(
					'var' => 'EffectiveDate',
					'sortId' => 10,
					'type' => SCFType::DATE,
				),

				11=>array(
					'var' => 'State',
					'sortId' => 11,
					'type' => SCFType::I16,
				),

				12=>array(
					'var' => 'Source',
					'sortId' => 12,
					'type' => SCFType::I16,
				),

				13=>array(
					'var' => 'Tag',
					'sortId' => 13,
					'type' => SCFType::STRING,
				),

				14=>array(
					'var' => 'Phone',
					'sortId' => 14,
					'type' => SCFType::STRING,
				),

				15=>array(
					'var' => 'Email',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'IM',
					'sortId' => 16,
					'type' => SCFType::STRING,
				),

				17=>array(
					'var' => 'HideItem',
					'sortId' => 17,
					'type' => SCFType::STRING,
				),

				18=>array(
					'var' => 'SortID',
					'sortId' => 18,
					'type' => SCFType::I64,
				),

				19=>array(
					'var' => 'InfoType',
					'sortId' => 19,
					'type' => SCFType::I16,
				),

				20=>array(
					'var' => 'IsBiz',
					'sortId' => 20,
					'type' => SCFType::BOOL,
				),

				21=>array(
					'var' => 'UserTag',
					'sortId' => 21,
					'type' => SCFType::STRING,
				),

				22=>array(
					'var' => 'Url',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				23=>array(
					'var' => 'Locals',
					'sortId' => 23,
					'type' => SCFType::STRING,
				),

				24=>array(
					'var' => 'Params',
					'sortId' => 24,
					'type' => SCFType::STRING,
				),

			);
		}

		$this->InfoID = $InfoID;
		$this->Content = $Content;
		$this->Title = $Title;
		$this->CateID = $CateID;
		$this->UserID = $UserID;
		$this->UserIP = $UserIP;
		$this->Pic = $Pic;
		$this->AddDate = $AddDate;
		$this->PostDate = $PostDate;
		$this->EffectiveDate = $EffectiveDate;
		$this->State = $State;
		$this->Source = $Source;
		$this->Tag = $Tag;
		$this->Phone = $Phone;
		$this->Email = $Email;
		$this->IM = $IM;
		$this->HideItem = $HideItem;
		$this->SortID = $SortID;
		$this->InfoType = $InfoType;
		$this->IsBiz = $IsBiz;
		$this->UserTag = $UserTag;
		$this->Url = $Url;
		$this->Locals = $Locals;
		$this->Params = $Params;
	}

	 public static function getTSPEC()
	{
		 return Info::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Info::$_TSPEC = $_TSPEC;
	}

	public function getInfoID()
	{
		return $this->InfoID;
	}

	public function setInfoID($InfoID)
	{
		$this->InfoID = $InfoID;
	}

	public function getContent()
	{
		return $this->Content;
	}

	public function setContent($Content)
	{
		$this->Content = $Content;
	}

	public function getTitle()
	{
		return $this->Title;
	}

	public function setTitle($Title)
	{
		$this->Title = $Title;
	}

	public function getCateID()
	{
		return $this->CateID;
	}

	public function setCateID($CateID)
	{
		$this->CateID = $CateID;
	}

	public function getUserID()
	{
		return $this->UserID;
	}

	public function setUserID($UserID)
	{
		$this->UserID = $UserID;
	}

	public function getUserIP()
	{
		return $this->UserIP;
	}

	public function setUserIP($UserIP)
	{
		$this->UserIP = $UserIP;
	}

	public function getPic()
	{
		return $this->Pic;
	}

	public function setPic($Pic)
	{
		$this->Pic = $Pic;
	}

	public function getAddDate()
	{
		return $this->AddDate;
	}

	public function setAddDate($AddDate)
	{
		$this->AddDate = $AddDate;
	}

	public function getPostDate()
	{
		return $this->PostDate;
	}

	public function setPostDate($PostDate)
	{
		$this->PostDate = $PostDate;
	}

	public function getEffectiveDate()
	{
		return $this->EffectiveDate;
	}

	public function setEffectiveDate($EffectiveDate)
	{
		$this->EffectiveDate = $EffectiveDate;
	}

	public function getState()
	{
		return $this->State;
	}

	public function setState($State)
	{
		$this->State = $State;
	}

	public function getSource()
	{
		return $this->Source;
	}

	public function setSource($Source)
	{
		$this->Source = $Source;
	}

	public function getTag()
	{
		return $this->Tag;
	}

	public function setTag($Tag)
	{
		$this->Tag = $Tag;
	}

	public function getPhone()
	{
		return $this->Phone;
	}

	public function setPhone($Phone)
	{
		$this->Phone = $Phone;
	}

	public function getEmail()
	{
		return $this->Email;
	}

	public function setEmail($Email)
	{
		$this->Email = $Email;
	}

	public function getIM()
	{
		return $this->IM;
	}

	public function setIM($IM)
	{
		$this->IM = $IM;
	}

	public function getHideItem()
	{
		return $this->HideItem;
	}

	public function setHideItem($HideItem)
	{
		$this->HideItem = $HideItem;
	}

	public function getSortID()
	{
		return $this->SortID;
	}

	public function setSortID($SortID)
	{
		$this->SortID = $SortID;
	}

	public function getInfoType()
	{
		return $this->InfoType;
	}

	public function setInfoType($InfoType)
	{
		$this->InfoType = $InfoType;
	}

	public function getIsBiz()
	{
		return $this->IsBiz;
	}

	public function setIsBiz($IsBiz)
	{
		$this->IsBiz = $IsBiz;
	}

	public function getUserTag()
	{
		return $this->UserTag;
	}

	public function setUserTag($UserTag)
	{
		$this->UserTag = $UserTag;
	}

	public function getUrl()
	{
		return $this->Url;
	}

	public function setUrl($Url)
	{
		$this->Url = $Url;
	}

	public function getLocals()
	{
		return $this->Locals;
	}

	public function setLocals($Locals)
	{
		$this->Locals = $Locals;
	}

	public function getParams()
	{
		return $this->Params;
	}

	public function setParams($Params)
	{
		$this->Params = $Params;
	}


}