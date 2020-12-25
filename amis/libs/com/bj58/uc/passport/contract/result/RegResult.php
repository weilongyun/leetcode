<?php
namespace com\bj58\uc\passport\contract\result;

use com\bj58\spat\scf\serialize\component\SCFType;

class RegResult{
	 static $_TSPEC;
	 static $_SCFNAME = 'RegResult';

	private $code;
	private $message;
	private $userId;
	private $data;

	 public function __construct($code = 0, $message = '', $userId = 0, $data = null ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'code',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'message',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'userId',
					'sortId' => 3,
					'type' => SCFType::I64,
				),

				4=>array(
					'var' => 'data',
					'sortId' => 4,
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
		
		$this->code = $code;
		$this->message = $message;
		$this->userId = $userId;
		$this->data = $data;
	}

	 public static function getTSPEC()
	{
		 return RegResult::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RegResult::$_TSPEC = $_TSPEC;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}


}