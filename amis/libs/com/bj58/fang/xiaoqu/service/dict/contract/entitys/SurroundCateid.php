<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class SurroundCateid{
	 static $_TSPEC;
	 static $_SCFNAME = 'SurroundCateid';

	private $cateid;
	private $name;
	private $comment;
	private $cityid;
	private $typeid;
	private $level;
	private $adddate;

	 public function __construct($cateid = '', $name = '', $comment = '', $cityid = '', $typeid = '', $level = '', $adddate = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'cateid',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'name',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'comment',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'cityid',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'typeid',
					'sortId' => 5,
					'type' => SCFType::BYTE,
				),

				6=>array(
					'var' => 'level',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'adddate',
					'sortId' => 7,
					'type' => SCFType::DATE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return SurroundCateid::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		SurroundCateid::$_TSPEC = $_TSPEC;
	}

	public function getCateid()
	{
		return $this->cateid;
	}

	public function setCateid($cateid)
	{
		$this->cateid = $cateid;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	public function getCityid()
	{
		return $this->cityid;
	}

	public function setCityid($cityid)
	{
		$this->cityid = $cityid;
	}

	public function getTypeid()
	{
		return $this->typeid;
	}

	public function setTypeid($typeid)
	{
		$this->typeid = $typeid;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function setLevel($level)
	{
		$this->level = $level;
	}

	public function getAdddate()
	{
		return $this->adddate;
	}

	public function setAdddate($adddate)
	{
		$this->adddate = $adddate;
	}


}