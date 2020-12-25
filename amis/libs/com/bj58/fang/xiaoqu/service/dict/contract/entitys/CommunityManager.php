<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class CommunityManager{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityManager';

	private $id;
	private $infoid;
	private $userid;
	private $cityid;
	private $areaid;
	private $shangquanid;
	private $adddate;
	private $state;
	private $endtime;
	private $level;

	 public function __construct($id = '', $infoid = '', $userid = '', $cityid = '', $areaid = '', $shangquanid = '', $adddate = '', $state = '', $endtime = '', $level = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'infoid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'userid',
					'sortId' => 3,
					'type' => SCFType::I64,
				),

				4=>array(
					'var' => 'cityid',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'areaid',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'shangquanid',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'adddate',
					'sortId' => 7,
					'type' => SCFType::DATE,
				),

				8=>array(
					'var' => 'state',
					'sortId' => 8,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'endtime',
					'sortId' => 9,
					'type' => SCFType::DATE,
				),

				10=>array(
					'var' => 'level',
					'sortId' => 10,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CommunityManager::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CommunityManager::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getInfoid()
	{
		return $this->infoid;
	}

	public function setInfoid($infoid)
	{
		$this->infoid = $infoid;
	}

	public function getUserid()
	{
		return $this->userid;
	}

	public function setUserid($userid)
	{
		$this->userid = $userid;
	}

	public function getCityid()
	{
		return $this->cityid;
	}

	public function setCityid($cityid)
	{
		$this->cityid = $cityid;
	}

	public function getAreaid()
	{
		return $this->areaid;
	}

	public function setAreaid($areaid)
	{
		$this->areaid = $areaid;
	}

	public function getShangquanid()
	{
		return $this->shangquanid;
	}

	public function setShangquanid($shangquanid)
	{
		$this->shangquanid = $shangquanid;
	}

	public function getAdddate()
	{
		return $this->adddate;
	}

	public function setAdddate($adddate)
	{
		$this->adddate = $adddate;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getEndtime()
	{
		return $this->endtime;
	}

	public function setEndtime($endtime)
	{
		$this->endtime = $endtime;
	}

	public function getLevel()
	{
		return $this->level;
	}

	public function setLevel($level)
	{
		$this->level = $level;
	}


}