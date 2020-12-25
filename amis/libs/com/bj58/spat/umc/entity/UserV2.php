<?php
namespace com\bj58\spat\umc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class UserV2{
	 static $_TSPEC;
	 static $_SCFNAME = 'UMC.UserV2';

	private $uid;
	private $name;
	private $password;
	private $email;
	private $mobile;
	private $verifiedEmail;
	private $verifiedMobile;
	private $verifiedRealName;
	private $verifiedBusiness;
	private $regCityId;
	private $regIp;
	private $regSource;
	private $regTime;
	private $locked;
	private $realName;
	private $nickName;
	private $sex;
	private $birthday;
	private $qq;
	private $msn;
	private $phone;
	private $postZip;
	private $address;
	private $aboutMe;
	private $face;
	private $verifiedFace;
	private $workLocationId;
	private $workPlace;
	private $livingLocationId;
	private $livingPlace;
	private $hometownId;
	private $agents;
	private $extend;
	private $lastUpdateTime;
	private $credit;
	private $loginIp;
	private $loginCity;
	private $loginSource;
	private $loginTime;

	 public function __construct($uid = '', $name = '', $password = '', $email = '', $mobile = '', $verifiedEmail = '', $verifiedMobile = '', $verifiedRealName = '', $verifiedBusiness = '', $regCityId = '', $regIp = '', $regSource = '', $regTime = '', $locked = '', $realName = '', $nickName = '', $sex = '', $birthday = '', $qq = '', $msn = '', $phone = '', $postZip = '', $address = '', $aboutMe = '', $face = '', $verifiedFace = '', $workLocationId = '', $workPlace = '', $livingLocationId = '', $livingPlace = '', $hometownId = '', $agents = '', $extend = '', $lastUpdateTime = '', $credit = '', $loginIp = '', $loginCity = '', $loginSource = '', $loginTime = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'uid',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'name',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'password',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'email',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'mobile',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'verifiedEmail',
					'sortId' => 6,
					'type' => SCFType::BOOL,
				),

				7=>array(
					'var' => 'verifiedMobile',
					'sortId' => 7,
					'type' => SCFType::BOOL,
				),

				8=>array(
					'var' => 'verifiedRealName',
					'sortId' => 8,
					'type' => SCFType::BOOL,
				),

				9=>array(
					'var' => 'verifiedBusiness',
					'sortId' => 9,
					'type' => SCFType::BOOL,
				),

				10=>array(
					'var' => 'regCityId',
					'sortId' => 10,
					'type' => SCFType::I32,
				),

				11=>array(
					'var' => 'regIp',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'regSource',
					'sortId' => 12,
					'type' => SCFType::STRING,
				),

				13=>array(
					'var' => 'regTime',
					'sortId' => 13,
					'type' => SCFType::DATE,
				),

				14=>array(
					'var' => 'locked',
					'sortId' => 14,
					'type' => SCFType::BOOL,
				),

				15=>array(
					'var' => 'realName',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'nickName',
					'sortId' => 16,
					'type' => SCFType::STRING,
				),

				17=>array(
					'var' => 'sex',
					'sortId' => 17,
					'type' => SCFType::I32,
				),

				18=>array(
					'var' => 'birthday',
					'sortId' => 18,
					'type' => SCFType::DATE,
				),

				19=>array(
					'var' => 'qq',
					'sortId' => 19,
					'type' => SCFType::STRING,
				),

				20=>array(
					'var' => 'msn',
					'sortId' => 20,
					'type' => SCFType::STRING,
				),

				21=>array(
					'var' => 'phone',
					'sortId' => 21,
					'type' => SCFType::STRING,
				),

				22=>array(
					'var' => 'postZip',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				23=>array(
					'var' => 'address',
					'sortId' => 23,
					'type' => SCFType::STRING,
				),

				24=>array(
					'var' => 'aboutMe',
					'sortId' => 24,
					'type' => SCFType::STRING,
				),

				25=>array(
					'var' => 'face',
					'sortId' => 25,
					'type' => SCFType::STRING,
				),

				26=>array(
					'var' => 'verifiedFace',
					'sortId' => 26,
					'type' => SCFType::BOOL,
				),

				27=>array(
					'var' => 'workLocationId',
					'sortId' => 27,
					'type' => SCFType::I32,
				),

				28=>array(
					'var' => 'workPlace',
					'sortId' => 28,
					'type' => SCFType::STRING,
				),

				29=>array(
					'var' => 'livingLocationId',
					'sortId' => 29,
					'type' => SCFType::I32,
				),

				30=>array(
					'var' => 'livingPlace',
					'sortId' => 30,
					'type' => SCFType::STRING,
				),

				31=>array(
					'var' => 'hometownId',
					'sortId' => 31,
					'type' => SCFType::I32,
				),

				32=>array(
					'var' => 'agents',
					'sortId' => 32,
					'type' => SCFType::STRING,
				),

				33=>array(
					'var' => 'extend',
					'sortId' => 33,
					'type' => SCFType::STRING,
				),

				34=>array(
					'var' => 'lastUpdateTime',
					'sortId' => 34,
					'type' => SCFType::DATE,
				),

				35=>array(
					'var' => 'credit',
					'sortId' => 35,
					'type' => SCFType::I32,
				),

				36=>array(
					'var' => 'loginIp',
					'sortId' => 36,
					'type' => SCFType::STRING,
				),

				37=>array(
					'var' => 'loginCity',
					'sortId' => 37,
					'type' => SCFType::I32,
				),

				38=>array(
					'var' => 'loginSource',
					'sortId' => 38,
					'type' => SCFType::STRING,
				),

				39=>array(
					'var' => 'loginTime',
					'sortId' => 39,
					'type' => SCFType::DATE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return UserV2::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		UserV2::$_TSPEC = $_TSPEC;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function setUid($uid)
	{
		$this->uid = $uid;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getMobile()
	{
		return $this->mobile;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function getVerifiedEmail()
	{
		return $this->verifiedEmail;
	}

	public function setVerifiedEmail($verifiedEmail)
	{
		$this->verifiedEmail = $verifiedEmail;
	}

	public function getVerifiedMobile()
	{
		return $this->verifiedMobile;
	}

	public function setVerifiedMobile($verifiedMobile)
	{
		$this->verifiedMobile = $verifiedMobile;
	}

	public function getVerifiedRealName()
	{
		return $this->verifiedRealName;
	}

	public function setVerifiedRealName($verifiedRealName)
	{
		$this->verifiedRealName = $verifiedRealName;
	}

	public function getVerifiedBusiness()
	{
		return $this->verifiedBusiness;
	}

	public function setVerifiedBusiness($verifiedBusiness)
	{
		$this->verifiedBusiness = $verifiedBusiness;
	}

	public function getRegCityId()
	{
		return $this->regCityId;
	}

	public function setRegCityId($regCityId)
	{
		$this->regCityId = $regCityId;
	}

	public function getRegIp()
	{
		return $this->regIp;
	}

	public function setRegIp($regIp)
	{
		$this->regIp = $regIp;
	}

	public function getRegSource()
	{
		return $this->regSource;
	}

	public function setRegSource($regSource)
	{
		$this->regSource = $regSource;
	}

	public function getRegTime()
	{
		return $this->regTime;
	}

	public function setRegTime($regTime)
	{
		$this->regTime = $regTime;
	}

	public function getLocked()
	{
		return $this->locked;
	}

	public function setLocked($locked)
	{
		$this->locked = $locked;
	}

	public function getRealName()
	{
		return $this->realName;
	}

	public function setRealName($realName)
	{
		$this->realName = $realName;
	}

	public function getNickName()
	{
		return $this->nickName;
	}

	public function setNickName($nickName)
	{
		$this->nickName = $nickName;
	}

	public function getSex()
	{
		return $this->sex;
	}

	public function setSex($sex)
	{
		$this->sex = $sex;
	}

	public function getBirthday()
	{
		return $this->birthday;
	}

	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

	public function getQq()
	{
		return $this->qq;
	}

	public function setQq($qq)
	{
		$this->qq = $qq;
	}

	public function getMsn()
	{
		return $this->msn;
	}

	public function setMsn($msn)
	{
		$this->msn = $msn;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	public function getPostZip()
	{
		return $this->postZip;
	}

	public function setPostZip($postZip)
	{
		$this->postZip = $postZip;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function getAboutMe()
	{
		return $this->aboutMe;
	}

	public function setAboutMe($aboutMe)
	{
		$this->aboutMe = $aboutMe;
	}

	public function getFace()
	{
		return $this->face;
	}

	public function setFace($face)
	{
		$this->face = $face;
	}

	public function getVerifiedFace()
	{
		return $this->verifiedFace;
	}

	public function setVerifiedFace($verifiedFace)
	{
		$this->verifiedFace = $verifiedFace;
	}

	public function getWorkLocationId()
	{
		return $this->workLocationId;
	}

	public function setWorkLocationId($workLocationId)
	{
		$this->workLocationId = $workLocationId;
	}

	public function getWorkPlace()
	{
		return $this->workPlace;
	}

	public function setWorkPlace($workPlace)
	{
		$this->workPlace = $workPlace;
	}

	public function getLivingLocationId()
	{
		return $this->livingLocationId;
	}

	public function setLivingLocationId($livingLocationId)
	{
		$this->livingLocationId = $livingLocationId;
	}

	public function getLivingPlace()
	{
		return $this->livingPlace;
	}

	public function setLivingPlace($livingPlace)
	{
		$this->livingPlace = $livingPlace;
	}

	public function getHometownId()
	{
		return $this->hometownId;
	}

	public function setHometownId($hometownId)
	{
		$this->hometownId = $hometownId;
	}

	public function getAgents()
	{
		return $this->agents;
	}

	public function setAgents($agents)
	{
		$this->agents = $agents;
	}

	public function getExtend()
	{
		return $this->extend;
	}

	public function setExtend($extend)
	{
		$this->extend = $extend;
	}

	public function getLastUpdateTime()
	{
		return $this->lastUpdateTime;
	}

	public function setLastUpdateTime($lastUpdateTime)
	{
		$this->lastUpdateTime = $lastUpdateTime;
	}

	public function getCredit()
	{
		return $this->credit;
	}

	public function setCredit($credit)
	{
		$this->credit = $credit;
	}

	public function getLoginIp()
	{
		return $this->loginIp;
	}

	public function setLoginIp($loginIp)
	{
		$this->loginIp = $loginIp;
	}

	public function getLoginCity()
	{
		return $this->loginCity;
	}

	public function setLoginCity($loginCity)
	{
		$this->loginCity = $loginCity;
	}

	public function getLoginSource()
	{
		return $this->loginSource;
	}

	public function setLoginSource($loginSource)
	{
		$this->loginSource = $loginSource;
	}

	public function getLoginTime()
	{
		return $this->loginTime;
	}

	public function setLoginTime($loginTime)
	{
		$this->loginTime = $loginTime;
	}


}