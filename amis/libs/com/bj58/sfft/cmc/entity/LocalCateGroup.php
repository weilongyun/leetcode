<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class LocalCateGroup{
	 static $_TSPEC;
	 static $_SCFNAME = 'LocalCateGroup';

	private $LocalID;
	private $DispGroupID;

	 public function __construct($LocalID = '', $DispGroupID = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'LocalID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'DispGroupID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return LocalCateGroup::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		LocalCateGroup::$_TSPEC = $_TSPEC;
	}

	public function getLocalID()
	{
		return $this->LocalID;
	}

	public function setLocalID($LocalID)
	{
		$this->LocalID = $LocalID;
	}

	public function getDispGroupID()
	{
		return $this->DispGroupID;
	}

	public function setDispGroupID($DispGroupID)
	{
		$this->DispGroupID = $DispGroupID;
	}


}