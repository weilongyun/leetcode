<?php
namespace com\bj58\xxzl\captcha\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;

class CaptchaRequestV2{
	static $_TSPEC;
	static $_SCFNAME = 'CaptchaRequestV2';

	public $Url;
	public $userId;
	public $userIp;
	public $telNumber;
	public $cateId;
	public $cityId;
	public $id58;
	public $level;
	public $createTime;
	public $sysId;
	public $userAgent;
	public $strategy;
	public $from;
	public $macAddress;
	public $smsId;
	public $smsCont;
	public $smsPasd;
	public $attachJson;

	public function __construct($Url = '', $userId = '', $userIp = '', $telNumber = '', $cateId = '', $cityId = '', $id58 = '', $level = '', $createTime = '', $sysId = '', $userAgent = '', $strategy = '', $from = '', $macAddress = '', $smsId = '', $smsCont = '', $smsPasd = '', $attachJson = '' ) {
		if (!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				1=>array(
					'var' => 'Url',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'userId',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'userIp',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'telNumber',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'cateId',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'cityId',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'id58',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'level',
					'sortId' => 8,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'createTime',
					'sortId' => 9,
					'type' => SCFType::I64,
				),

				10=>array(
					'var' => 'sysId',
					'sortId' => 10,
					'type' => SCFType::I32,
				),

				11=>array(
					'var' => 'userAgent',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'strategy',
					'sortId' => 12,
					'type' => SCFType::I32,
				),

				13=>array(
					'var' => 'from',
					'sortId' => 13,
					'type' => SCFType::I32,
				),

				14=>array(
					'var' => 'macAddress',
					'sortId' => 14,
					'type' => SCFType::I32,
				),

				15=>array(
					'var' => 'smsId',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'smsCont',
					'sortId' => 16,
					'type' => SCFType::ARAY,
					'elem' => array(
						'type' => SCFType::STRING,
					)
				),

				17=>array(
					'var' => 'smsPasd',
					'sortId' => 17,
					'type' => SCFType::STRING,
				),

				18=>array(
					'var' => 'attachJson',
					'sortId' => 18,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	public static function getTSPEC()
	{
		return CaptchaRequestV2::$_TSPEC;
	}
	public static function setTSPEC($_TSPEC)
	{
		CaptchaRequestV2::$_TSPEC = $_TSPEC;
	}

	public function getUrl()
	{
		return $this->Url;
	}

	public function setUrl($Url)
	{
		$this->Url = $Url;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function getUserIp()
	{
		return $this->userIp;
	}

	public function setUserIp($userIp)
	{
		$this->userIp = $userIp;
	}

	public function getTelNumber()
	{
		return $this->telNumber;
	}

	public function setTelNumber($telNumber)
	{
		$this->telNumber = $telNumber;
	}

	public function getCateId()
	{
		return $this->cateId;
	}

	public function setCateId($cateId)
	{
		$this->cateId = $cateId;
	}

	public function getCityId()
	{
		return $this->cityId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function getId58()
	{
		return $this->id58;
	}

	public function setId58($id58)
	{
		$this->id58 = $id58;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getCreateTime()
	{
		return $this->createTime;
	}

	public function setCreateTime($createTime)
	{
		$this->createTime = $createTime;
	}

	public function getSysId()
	{
		return $this->sysId;
	}

	public function setSysId($sysId)
	{
		$this->sysId = $sysId;
	}

	public function getUserAgent()
	{
		return $this->userAgent;
	}

	public function setUserAgent($userAgent)
	{
		$this->userAgent = $userAgent;
	}

	public function getStrategy()
	{
		return $this->strategy;
	}

	public function setStrategy($strategy)
	{
		$this->strategy = $strategy;
	}

	public function getFrom()
	{
		return $this->from;
	}

	public function setFrom($from)
	{
		$this->from = $from;
	}

	public function getMacAddress()
	{
		return $this->macAddress;
	}

	public function setMacAddress($macAddress)
	{
		$this->macAddress = $macAddress;
	}

	public function getSmsId()
	{
		return $this->smsId;
	}

	public function setSmsId($smsId)
	{
		$this->smsId = $smsId;
	}

	public function getSmsCont()
	{
		return $this->smsCont;
	}

	public function setSmsCont($smsCont)
	{
		$this->smsCont = $smsCont;
	}

	public function getSmsPasd()
	{
		return $this->smsPasd;
	}

	public function setSmsPasd($smsPasd)
	{
		$this->smsPasd = $smsPasd;
	}

	public function getAttachJson()
	{
		return $this->attachJson;
	}

	public function setAttachJson($attachJson)
	{
		$this->attachJson = $attachJson;
	}


}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */