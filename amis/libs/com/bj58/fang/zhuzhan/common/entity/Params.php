<?php
namespace com\bj58\fang\zhuzhan\common\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Params{
	 static $_TSPEC;
	 static $_SCFNAME = 'Params';

	protected $map;

	 public function __construct($map = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'map',
					'sortId' => 1,
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

		 $this->map=$map;
	}

	 public static function getTSPEC()
	{
		 return Params::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Params::$_TSPEC = $_TSPEC;
	}

	public function getMap()
	{
		return $this->map;
	}

	public function setMap($map)
	{
		$this->map = $map;
	}


}