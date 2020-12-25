<?php
namespace com\bj58\dia\recommend\displayservice\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class RecommendCommonRequestEntity{
	 static $_TSPEC;
	 static $_SCFNAME = 'RecommendCommonRequestEntity';

	private $entryDeviceType;
	private $entryOSType;
	private $entryAppType;
	private $businessCatIds;
	private $businessLocalId;
	private $businessLocalIds;
	private $visitorUserid;
	private $visitorSessionid;
	private $visitorCookieid;
	private $visitorUserIP;
	private $visitorURL;
	private $visitorREFURL;
	private $visitFlashCookieId;
	private $visitDeviceId;
	private $longitude;
	private $latitude;

	 public function __construct($entryDeviceType = '', $entryOSType = '', $entryAppType = '', $businessCatIds = '', $businessLocalId = '', $businessLocalIds = '', $visitorUserid = '', $visitorSessionid = '', $visitorCookieid = '', $visitorUserIP = '', $visitorURL = '', $visitorREFURL = '', $visitFlashCookieId = '', $visitDeviceId = '', $longitude = '', $latitude = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'entryDeviceType',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'entryOSType',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'entryAppType',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'businessCatIds',
					'sortId' => 24,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'businessLocalId',
					'sortId' => 25,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'businessLocalIds',
					'sortId' => 26,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'visitorUserid',
					'sortId' => 41,
					'type' => SCFType::I64,
				),

				8=>array(
					'var' => 'visitorSessionid',
					'sortId' => 42,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'visitorCookieid',
					'sortId' => 43,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'visitorUserIP',
					'sortId' => 44,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'visitorURL',
					'sortId' => 45,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'visitorREFURL',
					'sortId' => 46,
					'type' => SCFType::STRING,
				),

				13=>array(
					'var' => 'visitFlashCookieId',
					'sortId' => 47,
					'type' => SCFType::STRING,
				),

				14=>array(
					'var' => 'visitDeviceId',
					'sortId' => 48,
					'type' => SCFType::STRING,
				),

				15=>array(
					'var' => 'longitude',
					'sortId' => 49,
					'type' => SCFType::DOUBLE,
				),

				16=>array(
					'var' => 'latitude',
					'sortId' => 50,
					'type' => SCFType::DOUBLE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return RecommendCommonRequestEntity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RecommendCommonRequestEntity::$_TSPEC = $_TSPEC;
	}

	public function getEntryDeviceType()
	{
		return $this->entryDeviceType;
	}

	public function setEntryDeviceType($entryDeviceType)
	{
		$this->entryDeviceType = $entryDeviceType;
	}

	public function getEntryOSType()
	{
		return $this->entryOSType;
	}

	public function setEntryOSType($entryOSType)
	{
		$this->entryOSType = $entryOSType;
	}

	public function getEntryAppType()
	{
		return $this->entryAppType;
	}

	public function setEntryAppType($entryAppType)
	{
		$this->entryAppType = $entryAppType;
	}

	public function getBusinessCatIds()
	{
		return $this->businessCatIds;
	}

	public function setBusinessCatIds($businessCatIds)
	{
		$this->businessCatIds = $businessCatIds;
	}

	public function getBusinessLocalId()
	{
		return $this->businessLocalId;
	}

	public function setBusinessLocalId($businessLocalId)
	{
		$this->businessLocalId = $businessLocalId;
	}

	public function getBusinessLocalIds()
	{
		return $this->businessLocalIds;
	}

	public function setBusinessLocalIds($businessLocalIds)
	{
		$this->businessLocalIds = $businessLocalIds;
	}

	public function getVisitorUserid()
	{
		return $this->visitorUserid;
	}

	public function setVisitorUserid($visitorUserid)
	{
		$this->visitorUserid = $visitorUserid;
	}

	public function getVisitorSessionid()
	{
		return $this->visitorSessionid;
	}

	public function setVisitorSessionid($visitorSessionid)
	{
		$this->visitorSessionid = $visitorSessionid;
	}

	public function getVisitorCookieid()
	{
		return $this->visitorCookieid;
	}

	public function setVisitorCookieid($visitorCookieid)
	{
		$this->visitorCookieid = $visitorCookieid;
	}

	public function getVisitorUserIP()
	{
		return $this->visitorUserIP;
	}

	public function setVisitorUserIP($visitorUserIP)
	{
		$this->visitorUserIP = $visitorUserIP;
	}

	public function getVisitorURL()
	{
		return $this->visitorURL;
	}

	public function setVisitorURL($visitorURL)
	{
		$this->visitorURL = $visitorURL;
	}

	public function getVisitorREFURL()
	{
		return $this->visitorREFURL;
	}

	public function setVisitorREFURL($visitorREFURL)
	{
		$this->visitorREFURL = $visitorREFURL;
	}

	public function getVisitFlashCookieId()
	{
		return $this->visitFlashCookieId;
	}

	public function setVisitFlashCookieId($visitFlashCookieId)
	{
		$this->visitFlashCookieId = $visitFlashCookieId;
	}

	public function getVisitDeviceId()
	{
		return $this->visitDeviceId;
	}

	public function setVisitDeviceId($visitDeviceId)
	{
		$this->visitDeviceId = $visitDeviceId;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}

	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
	}


}