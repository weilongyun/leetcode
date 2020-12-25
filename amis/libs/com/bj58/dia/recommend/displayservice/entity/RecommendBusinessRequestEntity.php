<?php
namespace com\bj58\dia\recommend\displayservice\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class RecommendBusinessRequestEntity{
	 static $_TSPEC;
	 static $_SCFNAME = 'RecommendBusinessRequestEntity';

	private $businessEntityType;
	private $businessEntitySubType;
	private $businessEntityId;
	private $displayPageId;
	private $displayRegionId;
	private $displayNumLimit;
	private $businessEntitySalary;
	private $businessEntityWorkyears;
	private $businessEntityBirthday;
	private $businessEntityGender;
	private $businessEntityAdddate;
	private $businessEntityUpdatedate;
	private $businessEntityComplete;
	private $businessEntityEducation;
	private $businessParams;

	 public function __construct($businessEntityType = '', $businessEntitySubType = '', $businessEntityId = '', $displayPageId = '', $displayRegionId = '', $displayNumLimit = '', $businessEntitySalary = '', $businessEntityWorkyears = '', $businessEntityBirthday = '', $businessEntityGender = '', $businessEntityAdddate = '', $businessEntityUpdatedate = '', $businessEntityComplete = '', $businessEntityEducation = '', $businessParams = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'businessEntityType',
					'sortId' => 21,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'businessEntitySubType',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'businessEntityId',
					'sortId' => 23,
					'type' => SCFType::I64,
				),

				4=>array(
					'var' => 'displayPageId',
					'sortId' => 61,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'displayRegionId',
					'sortId' => 62,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'displayNumLimit',
					'sortId' => 63,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'businessEntitySalary',
					'sortId' => 64,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'businessEntityWorkyears',
					'sortId' => 65,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'businessEntityBirthday',
					'sortId' => 66,
					'type' => SCFType::I64,
				),

				10=>array(
					'var' => 'businessEntityGender',
					'sortId' => 67,
					'type' => SCFType::I16,
				),

				11=>array(
					'var' => 'businessEntityAdddate',
					'sortId' => 68,
					'type' => SCFType::I64,
				),

				12=>array(
					'var' => 'businessEntityUpdatedate',
					'sortId' => 69,
					'type' => SCFType::I64,
				),

				13=>array(
					'var' => 'businessEntityComplete',
					'sortId' => 70,
					'type' => SCFType::I32,
				),

				14=>array(
					'var' => 'businessEntityEducation',
					'sortId' => 71,
					'type' => SCFType::I32,
				),

				15=>array(
					'var' => 'businessParams',
					'sortId' => 80,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return RecommendBusinessRequestEntity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RecommendBusinessRequestEntity::$_TSPEC = $_TSPEC;
	}

	public function getBusinessEntityType()
	{
		return $this->businessEntityType;
	}

	public function setBusinessEntityType($businessEntityType)
	{
		$this->businessEntityType = $businessEntityType;
	}

	public function getBusinessEntitySubType()
	{
		return $this->businessEntitySubType;
	}

	public function setBusinessEntitySubType($businessEntitySubType)
	{
		$this->businessEntitySubType = $businessEntitySubType;
	}

	public function getBusinessEntityId()
	{
		return $this->businessEntityId;
	}

	public function setBusinessEntityId($businessEntityId)
	{
		$this->businessEntityId = $businessEntityId;
	}

	public function getDisplayPageId()
	{
		return $this->displayPageId;
	}

	public function setDisplayPageId($displayPageId)
	{
		$this->displayPageId = $displayPageId;
	}

	public function getDisplayRegionId()
	{
		return $this->displayRegionId;
	}

	public function setDisplayRegionId($displayRegionId)
	{
		$this->displayRegionId = $displayRegionId;
	}

	public function getDisplayNumLimit()
	{
		return $this->displayNumLimit;
	}

	public function setDisplayNumLimit($displayNumLimit)
	{
		$this->displayNumLimit = $displayNumLimit;
	}

	public function getBusinessEntitySalary()
	{
		return $this->businessEntitySalary;
	}

	public function setBusinessEntitySalary($businessEntitySalary)
	{
		$this->businessEntitySalary = $businessEntitySalary;
	}

	public function getBusinessEntityWorkyears()
	{
		return $this->businessEntityWorkyears;
	}

	public function setBusinessEntityWorkyears($businessEntityWorkyears)
	{
		$this->businessEntityWorkyears = $businessEntityWorkyears;
	}

	public function getBusinessEntityBirthday()
	{
		return $this->businessEntityBirthday;
	}

	public function setBusinessEntityBirthday($businessEntityBirthday)
	{
		$this->businessEntityBirthday = $businessEntityBirthday;
	}

	public function getBusinessEntityGender()
	{
		return $this->businessEntityGender;
	}

	public function setBusinessEntityGender($businessEntityGender)
	{
		$this->businessEntityGender = $businessEntityGender;
	}

	public function getBusinessEntityAdddate()
	{
		return $this->businessEntityAdddate;
	}

	public function setBusinessEntityAdddate($businessEntityAdddate)
	{
		$this->businessEntityAdddate = $businessEntityAdddate;
	}

	public function getBusinessEntityUpdatedate()
	{
		return $this->businessEntityUpdatedate;
	}

	public function setBusinessEntityUpdatedate($businessEntityUpdatedate)
	{
		$this->businessEntityUpdatedate = $businessEntityUpdatedate;
	}

	public function getBusinessEntityComplete()
	{
		return $this->businessEntityComplete;
	}

	public function setBusinessEntityComplete($businessEntityComplete)
	{
		$this->businessEntityComplete = $businessEntityComplete;
	}

	public function getBusinessEntityEducation()
	{
		return $this->businessEntityEducation;
	}

	public function setBusinessEntityEducation($businessEntityEducation)
	{
		$this->businessEntityEducation = $businessEntityEducation;
	}

	public function getBusinessParams()
	{
		return $this->businessParams;
	}

	public function setBusinessParams($businessParams)
	{
		$this->businessParams = $businessParams;
	}


}