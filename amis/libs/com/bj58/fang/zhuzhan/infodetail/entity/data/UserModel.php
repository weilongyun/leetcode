<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;

class UserModel{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.fang.zhuzhan.infodetail.entity.data.UserModel';

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
		 return UserModel::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		UserModel::$_TSPEC = $_TSPEC;
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