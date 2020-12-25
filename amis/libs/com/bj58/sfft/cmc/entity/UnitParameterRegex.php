<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class UnitParameterRegex{
	 static $_TSPEC;
	 static $_SCFNAME = 'UnitParameterRegex';

	private $ParameterID;
	private $RegexText;
	private $ErrorText;
	private $Order;

	 public function __construct($ParameterID = '', $RegexText = '', $ErrorText = '', $Order = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'ParameterID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'RegexText',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'ErrorText',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'Order',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return UnitParameterRegex::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		UnitParameterRegex::$_TSPEC = $_TSPEC;
	}

	public function getParameterID()
	{
		return $this->ParameterID;
	}

	public function setParameterID($ParameterID)
	{
		$this->ParameterID = $ParameterID;
	}

	public function getRegexText()
	{
		return $this->RegexText;
	}

	public function setRegexText($RegexText)
	{
		$this->RegexText = $RegexText;
	}

	public function getErrorText()
	{
		return $this->ErrorText;
	}

	public function setErrorText($ErrorText)
	{
		$this->ErrorText = $ErrorText;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}


}