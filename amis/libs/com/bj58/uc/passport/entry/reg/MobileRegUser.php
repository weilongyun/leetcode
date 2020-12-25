<?php
namespace com\bj58\uc\passport\entry\reg;

use com\bj58\spat\scf\serialize\component\SCFType;

class MobileRegUser{
	 static $_TSPEC;
	 static $_SCFNAME = 'MobileRegUser';

	private $username;
	private $mobile;
	private $password;
	private $needSendSms;
	private $smsTemplateId;
	private $smsTemplatePassword;
	private $cityId;
	private $source;
	private $ext;

	 public function __construct($username = '', $mobile = '', $password = '', $needSendSms = FALSE, $smsTemplateId = 0, $smsTemplatePassword = '', $cityId = 0, $source = '', $ext = array() ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'username',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'mobile',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'password',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'needSendSms',
					'sortId' => 4,
					'type' => SCFType::BOOL,
				),

				5=>array(
					'var' => 'smsTemplateId',
					'sortId' => 5,
					'type' => SCFType::I32,
				),
				
				6=>array(
					'var' => 'smsTemplatePassword',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'cityId',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'source',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'ext',
					'sortId' => 9,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::STRING,
					),
				),

			);
		}
		
		$this->username = $username;
		$this->mobile = $mobile;
		$this->password = $password;
		$this->needSendSms = $needSendSms;
		$this->smsTemplateId = $smsTemplateId;
		$this->smsTemplatePassword = $smsTemplatePassword;
		$this->cityId = $cityId;
		$this->source = $source;
		$this->ext = $ext;
	}

	 public static function getTSPEC()
	{
		 return MobileRegUser::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		MobileRegUser::$_TSPEC = $_TSPEC;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getMobile()
	{
		return $this->mobile;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getNeedSendSms()
	{
		return $this->needSendSms;
	}

	public function setNeedSendSms($needSendSms)
	{
		$this->needSendSms = $needSendSms;
	}

	public function getSmsTemplateId()
	{
		return $this->smsTemplateId;
	}

	public function setSmsTemplateId($smsTemplateId)
	{
		$this->smsTemplateId = $smsTemplateId;
	}
	
	public function getSmsTemplatePassword()
	{
		return $this->smsTemplatePassword;
	}

	public function setSmsTemplatePassword($smsTemplatePassword)
	{
		$this->smsTemplatePassword = $smsTemplatePassword;
	}
	
	public function getCityId()
	{
		return $this->cityId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function setSource($source)
	{
		$this->source = $source;
	}

	public function getExt()
	{
		return $this->ext;
	}

	public function setExt($ext)
	{
		$this->ext = $ext;
	}


}
