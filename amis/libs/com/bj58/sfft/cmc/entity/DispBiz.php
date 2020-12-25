<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class DispBiz{
	 static $_TSPEC;
	 static $_SCFNAME = 'DispBiz';

	private $DispCategoryID;
	private $BizName;

	 public function __construct($DispCategoryID = '', $BizName = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'DispCategoryID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'BizName',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return DispBiz::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		DispBiz::$_TSPEC = $_TSPEC;
	}

	public function getDispCategoryID()
	{
		return $this->DispCategoryID;
	}

	public function setDispCategoryID($DispCategoryID)
	{
		$this->DispCategoryID = $DispCategoryID;
	}

	public function getBizName()
	{
		return $this->BizName;
	}

	public function setBizName($BizName)
	{
		$this->BizName = $BizName;
	}


}