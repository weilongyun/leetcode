<?php
namespace com\bj58\uc\passport\entry\reg;

use com\bj58\spat\scf\serialize\component\SCFType;

class RegUser{
	 static $_TSPEC;
	 static $_SCFNAME = 'RegUser';

	private $username;
	private $password;
	private $email;
	private $needSendEmail;
	private $cityId;
	private $source;
	private $emailTemplate;
	private $ext;

	 public function __construct($username = '', $password = '', $email = '', $needSendEmail = '', $cityId = '', $source = '', $emailTemplate = '', $ext = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'username',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'password',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'email',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'needSendEmail',
					'sortId' => 4,
					'type' => SCFType::BOOL,
				),

				5=>array(
					'var' => 'cityId',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'source',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'emailTemplate',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'ext',
					'sortId' => 8,
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
	}

	 public static function getTSPEC()
	{
		 return RegUser::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RegUser::$_TSPEC = $_TSPEC;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
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

	public function getNeedSendEmail()
	{
		return $this->needSendEmail;
	}

	public function setNeedSendEmail($needSendEmail)
	{
		$this->needSendEmail = $needSendEmail;
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

	public function getEmailTemplate()
	{
		return $this->emailTemplate;
	}

	public function setEmailTemplate($emailTemplate)
	{
		$this->emailTemplate = $emailTemplate;
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