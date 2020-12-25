<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Local{
	 static $_TSPEC;
	 static $_SCFNAME = 'Local';

	private $LocalID;
	private $Pid;
	private $LocalName;
	private $FullPath;
	private $DirName;
	private $Logo;
	private $Depth;
	private $LocalCateGroup;

	 public function __construct($LocalID = '', $Pid = '', $LocalName = '', $FullPath = '', $DirName = '', $Logo = '', $Depth = '', $LocalCateGroup = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'LocalID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'Pid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'LocalName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'FullPath',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'DirName',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'Logo',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'Depth',
					'sortId' => 7,
					'type' => SCFType::I16,
				),

				8=>array(
					'var' => 'LocalCateGroup',
					'sortId' => 8,
					'type' => SCFType::OBJECT,
					'class' => new LocalCateGroup(),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Local::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Local::$_TSPEC = $_TSPEC;
	}

	public function getLocalID()
	{
		return $this->LocalID;
	}

	public function setLocalID($LocalID)
	{
		$this->LocalID = $LocalID;
	}

	public function getPid()
	{
		return $this->Pid;
	}

	public function setPid($Pid)
	{
		$this->Pid = $Pid;
	}

	public function getLocalName()
	{
		return $this->LocalName;
	}

	public function setLocalName($LocalName)
	{
		$this->LocalName = $LocalName;
	}

	public function getFullPath()
	{
		return $this->FullPath;
	}

	public function setFullPath($FullPath)
	{
		$this->FullPath = $FullPath;
	}

	public function getDirName()
	{
		return $this->DirName;
	}

	public function setDirName($DirName)
	{
		$this->DirName = $DirName;
	}

	public function getLogo()
	{
		return $this->Logo;
	}

	public function setLogo($Logo)
	{
		$this->Logo = $Logo;
	}

	public function getDepth()
	{
		return $this->Depth;
	}

	public function setDepth($Depth)
	{
		$this->Depth = $Depth;
	}

	public function getLocalCateGroup()
	{
		return $this->LocalCateGroup;
	}

	public function setLocalCateGroup($LocalCateGroup)
	{
		$this->LocalCateGroup = $LocalCateGroup;
	}


}