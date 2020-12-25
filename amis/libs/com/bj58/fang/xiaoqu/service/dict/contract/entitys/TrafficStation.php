<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficStation{
	 static $_TSPEC;
	 static $_SCFNAME = 'TrafficStation';

	private $stationid;
	private $stationname;
	private $cityid;
	private $lon;
	private $lat;
	private $intro;
	private $sortid;
	private $state;
	private $adddate;
	private $postdate;
	private $type;
	private $dirname;
	private $letter;

	 public function __construct($stationid = '', $stationname = '', $cityid = '', $lon = '', $lat = '', $intro = '', $sortid = '', $state = '', $adddate = '', $postdate = '', $type = '', $dirname = '', $letter = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'stationid',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'stationname',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'cityid',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'lon',
					'sortId' => 4,
					'type' => SCFType::DOUBLE,
				),

				5=>array(
					'var' => 'lat',
					'sortId' => 5,
					'type' => SCFType::DOUBLE,
				),

				6=>array(
					'var' => 'intro',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'sortid',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'state',
					'sortId' => 8,
					'type' => SCFType::I16,
				),

				9=>array(
					'var' => 'adddate',
					'sortId' => 9,
					'type' => SCFType::DATE,
				),

				10=>array(
					'var' => 'postdate',
					'sortId' => 10,
					'type' => SCFType::DATE,
				),

				11=>array(
					'var' => 'type',
					'sortId' => 11,
					'type' => SCFType::I16,
				),

				12=>array(
					'var' => 'dirname',
					'sortId' => 12,
					'type' => SCFType::STRING,
				),

				13=>array(
					'var' => 'letter',
					'sortId' => 13,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return TrafficStation::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		TrafficStation::$_TSPEC = $_TSPEC;
	}

	public function getStationid()
	{
		return $this->stationid;
	}

	public function setStationid($stationid)
	{
		$this->stationid = $stationid;
	}

	public function getStationname()
	{
		return $this->stationname;
	}

	public function setStationname($stationname)
	{
		$this->stationname = $stationname;
	}

	public function getCityid()
	{
		return $this->cityid;
	}

	public function setCityid($cityid)
	{
		$this->cityid = $cityid;
	}

	public function getLon()
	{
		return $this->lon;
	}

	public function setLon($lon)
	{
		$this->lon = $lon;
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function setLat($lat)
	{
		$this->lat = $lat;
	}

	public function getIntro()
	{
		return $this->intro;
	}

	public function setIntro($intro)
	{
		$this->intro = $intro;
	}

	public function getSortid()
	{
		return $this->sortid;
	}

	public function setSortid($sortid)
	{
		$this->sortid = $sortid;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getAdddate()
	{
		return $this->adddate;
	}

	public function setAdddate($adddate)
	{
		$this->adddate = $adddate;
	}

	public function getPostdate()
	{
		return $this->postdate;
	}

	public function setPostdate($postdate)
	{
		$this->postdate = $postdate;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getDirname()
	{
		return $this->dirname;
	}

	public function setDirname($dirname)
	{
		$this->dirname = $dirname;
	}

	public function getLetter()
	{
		return $this->letter;
	}

	public function setLetter($letter)
	{
		$this->letter = $letter;
	}


}