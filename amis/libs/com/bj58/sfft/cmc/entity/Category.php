<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Category{
	 static $_TSPEC;
	 static $_SCFNAME = 'Category';

	private $CateID;
	private $PID;
	private $CateName;
	private $DirName;
	private $FullPath;
	private $Depth;

	 public function __construct($CateID = '', $PID = '', $CateName = '', $DirName = '', $FullPath = '', $Depth = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'CateID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'PID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'CateName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'DirName',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'FullPath',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'Depth',
					'sortId' => 6,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Category::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Category::$_TSPEC = $_TSPEC;
	}

	public function getCateID()
	{
		return $this->CateID;
	}

	public function setCateID($CateID)
	{
		$this->CateID = $CateID;
	}

	public function getPID()
	{
		return $this->PID;
	}

	public function setPID($PID)
	{
		$this->PID = $PID;
	}

	public function getCateName()
	{
		return $this->CateName;
	}

	public function setCateName($CateName)
	{
		$this->CateName = $CateName;
	}

	public function getDirName()
	{
		return $this->DirName;
	}

	public function setDirName($DirName)
	{
		$this->DirName = $DirName;
	}

	public function getFullPath()
	{
		return $this->FullPath;
	}

	public function setFullPath($FullPath)
	{
		$this->FullPath = $FullPath;
	}

	public function getDepth()
	{
		return $this->Depth;
	}

	public function setDepth($Depth)
	{
		$this->Depth = $Depth;
	}


}