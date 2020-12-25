<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;

class ExtendModel{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.fang.zhuzhan.infodetail.entity.data.ExtendModel';

	private $paras;

	 public function __construct($paras = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'paras',
					'sortId' => 1,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::OBJECT,
						'elem' => array( 
							'class' => new Object(),
						),
					),
				),

			);
		}
		 $this->paras=$paras;
	}

	 public static function getTSPEC()
	{
		 return ExtendModel::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ExtendModel::$_TSPEC = $_TSPEC;
	}

	public function getParas()
	{
		return $this->paras;
	}

	public function setParas($paras)
	{
		$this->paras = $paras;
	}


}