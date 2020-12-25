<?php
namespace com\bj58\fang\zhuzhan\common\extend;


use com\bj58\spat\scf\serialize\component\SCFType;
class GetEnum
{
	 static $_TSPEC;
	 static $_SCFNAME = 'GetEnum';

	 const Basic=1;
	 const Business=2;
	 const HouseTese=3;
	 const HousePics=4;
	 const User=5;
	 const Enterprise=6;
	 const DICT=7;
	 const HouseRenzhen=8;
	 const PhoneOtherInfo=9;
	 const HouseSeo=10;
	 const PostOther=90;
	 const Extenstion=99;

	public function __construct() {
		if(!isset(self::$_TSPEC)) {
			self::$_TSPEC = array(
				1=>'Enum'
			);
		}
	}


	 public static function getTSPEC()
	 {
		 return GetEnum::$_TSPEC;
	 }
	 public static function setTSPEC($_TSPEC)
	 {
		 GetEnum::$_TSPEC = $_TSPEC;
	 }

}