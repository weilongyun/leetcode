<?php
namespace com\bj58\sfb\queryrecClient\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class MapEntry{
	 static $_TSPEC;
	 static $_SCFNAME = 'MapEntry';

	private $key;
	private $value;

	 public function __construct($key = '', $value = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'key',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'value',
					'sortId' => 2,
					'type' => SCFType::DOUBLE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return MapEntry::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		MapEntry::$_TSPEC = $_TSPEC;
	}

	public function getKey()
	{
		return $this->key;
	}

	public function setKey($key)
	{
		$this->key = $key;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}


}
