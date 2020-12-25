<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class TempletDispCate{
	 static $_TSPEC;
	 static $_SCFNAME = 'TempletDispCate';

	private $TempleID;
	private $DispCategoryID;

	 public function __construct($TempleID = '', $DispCategoryID = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'TempleID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'DispCategoryID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return TempletDispCate::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		TempletDispCate::$_TSPEC = $_TSPEC;
	}

	public function getTempleID()
	{
		return $this->TempleID;
	}

	public function setTempleID($TempleID)
	{
		$this->TempleID = $TempleID;
	}

	public function getDispCategoryID()
	{
		return $this->DispCategoryID;
	}

	public function setDispCategoryID($DispCategoryID)
	{
		$this->DispCategoryID = $DispCategoryID;
	}


}