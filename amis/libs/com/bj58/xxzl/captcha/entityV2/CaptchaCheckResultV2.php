<?php
namespace com\bj58\xxzl\captcha\entityV2;

use com\bj58\spat\scf\serialize\component\SCFType;

class CaptchaCheckResultV2{
	 static $_TSPEC;
	 static $_SCFNAME = 'CaptchaCheckResultV2';

	private $result;
	private $currentCount;
	private $FECheckedFailedCount;
	private $BECheckedFailedCount;

	 public function __construct($result = '', $currentCount = '', $FECheckedFailedCount = '', $BECheckedFailedCount = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'result',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'currentCount',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'FECheckedFailedCount',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'BECheckedFailedCount',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CaptchaCheckResultV2::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CaptchaCheckResultV2::$_TSPEC = $_TSPEC;
	}

	public function getResult()
	{
		return $this->result;
	}

	public function setResult($result)
	{
		$this->result = $result;
	}

	public function getCurrentCount()
	{
		return $this->currentCount;
	}

	public function setCurrentCount($currentCount)
	{
		$this->currentCount = $currentCount;
	}

	public function getFECheckedFailedCount()
	{
		return $this->FECheckedFailedCount;
	}

	public function setFECheckedFailedCount($FECheckedFailedCount)
	{
		$this->FECheckedFailedCount = $FECheckedFailedCount;
	}

	public function getBECheckedFailedCount()
	{
		return $this->BECheckedFailedCount;
	}

	public function setBECheckedFailedCount($BECheckedFailedCount)
	{
		$this->BECheckedFailedCount = $BECheckedFailedCount;
	}
	
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */