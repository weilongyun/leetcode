<?php
namespace com\bj58\xxzl\captcha\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;

class CaptchaCheckRequestV2{
	 static $_TSPEC;
	 static $_SCFNAME = 'CaptchaCheckRequestV2';

	private $responseId;
	private $sysId;
	private $level;
	private $userInput;
	private $userIp;
	private $id58;
	private $macAddress;
	private $fromGetStr;
	private $keepInCache;
	private $attachJson;
	private $tel;

	 public function __construct($responseId = '', $sysId = '', $level = '', $userInput = '', $userIp = '', $id58 = '', $macAddress = '', $fromGetStr = '', $keepInCache = '', $attachJson = '', $tel = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'responseId',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'sysId',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'level',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'userInput',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'userIp',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'id58',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'macAddress',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'fromGetStr',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'keepInCache',
					'sortId' => 9,
					'type' => SCFType::BOOL,
				),

				10=>array(
					'var' => 'attachJson',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'tel',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CaptchaCheckRequestV2::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CaptchaCheckRequestV2::$_TSPEC = $_TSPEC;
	}

	public function getResponseId()
	{
		return $this->responseId;
	}

	public function setResponseId($responseId)
	{
		$this->responseId = $responseId;
	}

	public function getSysId()
	{
		return $this->sysId;
	}

	public function setSysId($sysId)
	{
		$this->sysId = $sysId;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getUserInput()
	{
		return $this->userInput;
	}

	public function setUserInput($userInput)
	{
		$this->userInput = $userInput;
	}

	public function getUserIp()
	{
		return $this->userIp;
	}

	public function setUserIp($userIp)
	{
		$this->userIp = $userIp;
	}

	public function getId58()
	{
		return $this->id58;
	}

	public function setId58($id58)
	{
		$this->id58 = $id58;
	}

	public function getMacAddress()
	{
		return $this->macAddress;
	}

	public function setMacAddress($macAddress)
	{
		$this->macAddress = $macAddress;
	}

	public function getFromGetStr()
	{
		return $this->fromGetStr;
	}

	public function setFromGetStr($fromGetStr)
	{
		$this->fromGetStr = $fromGetStr;
	}

	public function getKeepInCache()
	{
		return $this->keepInCache;
	}

	public function setKeepInCache($keepInCache)
	{
		$this->keepInCache = $keepInCache;
	}

	public function getAttachJson()
	{
		return $this->attachJson;
	}

	public function setAttachJson($attachJson)
	{
		$this->attachJson = $attachJson;
	}

	public function getTel()
	{
		return $this->tel;
	}

	public function setTel($tel)
	{
		$this->tel = $tel;
	}

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */