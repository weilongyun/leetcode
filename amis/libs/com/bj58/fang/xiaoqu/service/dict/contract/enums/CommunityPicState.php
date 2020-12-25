<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\enums;

class CommunityPicState
{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityPicStateEnum';

	 const None = 'None';
	 const Nomarl = 'Nomarl';
	 const Delete = 'Delete';

	 public function __construct() {
		 if(!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				 1=>'Enum'
			);
		}
	}
}