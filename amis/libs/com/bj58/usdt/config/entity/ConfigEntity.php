<?php
namespace com\bj58\usdt\config\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class ConfigEntity{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.usdt.config.entity.ConfigEntity';

	private $id;
	private $displocalid;
	private $dispcateid;
	private $systemid;
	private $typeid;
	private $configkey;
	private $configvalue;
	private $testconfigvalue;

	 public function __construct($id = '', $displocalid = '', $dispcateid = '', $systemid = '', $typeid = '', $configkey = '', $configvalue = '', $testconfigvalue = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'displocalid',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'dispcateid',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'systemid',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'typeid',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'configkey',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'configvalue',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'testconfigvalue',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return ConfigEntity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ConfigEntity::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getDisplocalid()
	{
		return $this->displocalid;
	}

	public function setDisplocalid($displocalid)
	{
		$this->displocalid = $displocalid;
	}

	public function getDispcateid()
	{
		return $this->dispcateid;
	}

	public function setDispcateid($dispcateid)
	{
		$this->dispcateid = $dispcateid;
	}

	public function getSystemid()
	{
		return $this->systemid;
	}

	public function setSystemid($systemid)
	{
		$this->systemid = $systemid;
	}

	public function getTypeid()
	{
		return $this->typeid;
	}

	public function setTypeid($typeid)
	{
		$this->typeid = $typeid;
	}

	public function getConfigkey()
	{
		return $this->configkey;
	}

	public function setConfigkey($configkey)
	{
		$this->configkey = $configkey;
	}

	public function getConfigvalue()
	{
		return $this->configvalue;
	}

	public function setConfigvalue($configvalue)
	{
		$this->configvalue = $configvalue;
	}

	public function getTestconfigvalue()
	{
		return $this->testconfigvalue;
	}

	public function setTestconfigvalue($testconfigvalue)
	{
		$this->testconfigvalue = $testconfigvalue;
	}


}