<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class CateGroup{
	 static $_TSPEC;
	 static $_SCFNAME = 'CateGroup';

	private $DispGroupID;
	private $GroupName;

	 public function __construct($DispGroupID = '', $GroupName = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'DispGroupID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'GroupName',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CateGroup::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CateGroup::$_TSPEC = $_TSPEC;
	}

	public function getDispGroupID()
	{
		return $this->DispGroupID;
	}

	public function setDispGroupID($DispGroupID)
	{
		$this->DispGroupID = $DispGroupID;
	}

	public function getGroupName()
	{
		return $this->GroupName;
	}

	public function setGroupName($GroupName)
	{
		$this->GroupName = $GroupName;
	}


}