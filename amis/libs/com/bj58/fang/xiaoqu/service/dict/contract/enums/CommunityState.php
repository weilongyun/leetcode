<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\enums;

class CommunityState
{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityStateEnum';

	 const Audit = 'Audit';
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