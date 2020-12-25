<?php
namespace com\bj58\xxzl\captcha\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;

class CaptchaResponseV2{
	static $_TSPEC;
	static $_SCFNAME = 'CaptchaResponseV2';

	public $tip;
	public $responseId;
	public $retLevel;
	public $len;
	public $data;
	public $isImg;
	public $errorCode;
	public $retTime;
	public $param;

	public function __construct($tip = '', $responseId = '', $retLevel = '', $len = '', $data = '', $isImg = '', $errorCode = '', $retTime = '', $param = '' ) {
		if (!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				1=>array(
					'var' => 'tip',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'responseId',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'retLevel',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'len',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'data',
					'sortId' => 5,
					'type' => SCFType::ARAY,
					'elem' => array(
						'type' => SCFType::STRING,
					)
				),

				6=>array(
					'var' => 'isImg',
					'sortId' => 6,
					'type' => SCFType::BOOL,
				),

				7=>array(
					'var' => 'errorCode',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'retTime',
					'sortId' => 8,
					'type' => SCFType::I64,
				),

				9=>array(
					'var' => 'param',
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
	}

	public static function getTSPEC()
	{
		return CaptchaResponseV2::$_TSPEC;
	}
	public static function setTSPEC($_TSPEC)
	{
		CaptchaResponseV2::$_TSPEC = $_TSPEC;
	}

	public function getTip()
	{
		return $this->tip;
	}

	public function setTip($tip)
	{
		$this->tip = $tip;
	}

	public function getResponseId()
	{
		return $this->responseId;
	}

	public function setResponseId($responseId)
	{
		$this->responseId = $responseId;
	}

	public function getRetLevel()
	{
		return $this->retLevel;
	}

	public function setRetLevel($retLevel)
	{
		$this->retLevel = $retLevel;
	}

	public function getLen()
	{
		return $this->len;
	}

	public function setLen($len)
	{
		$this->len = $len;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getIsImg()
	{
		return $this->isImg;
	}

	public function setIsImg($isImg)
	{
		$this->isImg = $isImg;
	}

	public function getErrorCode()
	{
		return $this->errorCode;
	}

	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;
	}

	public function getRetTime()
	{
		return $this->retTime;
	}

	public function setRetTime($retTime)
	{
		$this->retTime = $retTime;
	}

	public function getParam()
	{
		return $this->param;
	}

	public function setParam($param)
	{
		$this->param = $param;
	}

}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */