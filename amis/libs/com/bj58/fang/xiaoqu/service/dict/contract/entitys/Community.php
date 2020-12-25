<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class Community{
	 static $_TSPEC;
	 static $_SCFNAME = 'Community';//'t_community';

	private $infoid;
	private $name;
	private $alias;
	private $listname;
	private $cityid;
	private $areaid;
	private $shangquanid;
	private $ds_cityid;
	private $ds_areaid;
	private $ds_shangquanid;
	private $state;
	private $sortid;
	private $lon;
	private $lat;
	private $address;
	private $score;
	private $adddate;
	private $postdate;
	private $source;
	private $matchid;
	private $matchlevel;
	private $letter;
	private $type;
	private $schoolroom;
	private $paraMap;
	private $writelog;

	 public function __construct($infoid = '', $name = '', $alias = '', $listname = '', $cityid = '', $areaid = '', $shangquanid = '', $ds_cityid = '', $ds_areaid = '', $ds_shangquanid = '', $state = '', $sortid = '', $lon = '', $lat = '', $address = '', $score = '', $adddate = '', $postdate = '', $source = '', $matchid = '', $matchlevel = '', $letter = '', $type = '', $schoolroom = '', $paraMap = '', $writelog = true ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'infoid',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'name',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'alias',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'listname',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'cityid',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'areaid',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'shangquanid',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'ds_cityid',
					'sortId' => 8,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'ds_areaid',
					'sortId' => 9,
					'type' => SCFType::I32,
				),

				10=>array(
					'var' => 'ds_shangquanid',
					'sortId' => 10,
					'type' => SCFType::I32,
				),

				11=>array(
					'var' => 'state',
					'sortId' => 11,
					'type' => SCFType::I32,
				),

				12=>array(
					'var' => 'sortid',
					'sortId' => 12,
					'type' => SCFType::I32,
				),

				13=>array(
					'var' => 'lon',
					'sortId' => 13,
					'type' => SCFType::DOUBLE,
				),

				14=>array(
					'var' => 'lat',
					'sortId' => 14,
					'type' => SCFType::DOUBLE,
				),

				15=>array(
					'var' => 'address',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'score',
					'sortId' => 16,
					'type' => SCFType::I32,
				),

				17=>array(
					'var' => 'adddate',
					'sortId' => 17,
					'type' => SCFType::DATE,
				),

				18=>array(
					'var' => 'postdate',
					'sortId' => 18,
					'type' => SCFType::DATE,
				),

				19=>array(
					'var' => 'source',
					'sortId' => 19,
					'type' => SCFType::I16,
				),

				20=>array(
					'var' => 'matchid',
					'sortId' => 20,
					'type' => SCFType::I32,
				),

				21=>array(
					'var' => 'matchlevel',
					'sortId' => 21,
					'type' => SCFType::I16,
				),

				22=>array(
					'var' => 'letter',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				23=>array(
					'var' => 'type',
					'sortId' => 23,
					'type' => SCFType::BYTE,
				),

				24=>array(
					'var' => 'schoolroom',
					'sortId' => 24,
					'type' => SCFType::BOOL,
				),

				25=>array(
					'var' => 'paraMap',
					'sortId' => 25,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::STRING,
					),
				),

				26=>array(
					'var' => 'writelog',
					'sortId' => 26,
					'type' => SCFType::BOOL,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Community::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Community::$_TSPEC = $_TSPEC;
	}

	public function getInfoid()
	{
		return $this->infoid;
	}

	public function setInfoid($infoid)
	{
		$this->infoid = $infoid;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getAlias()
	{
		return $this->alias;
	}

	public function setAlias($alias)
	{
		$this->alias = $alias;
	}

	public function getListname()
	{
		return $this->listname;
	}

	public function setListname($listname)
	{
		$this->listname = $listname;
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

	public function getDs_cityid()
	{
		return $this->ds_cityid;
	}

	public function setDs_cityid($ds_cityid)
	{
		$this->ds_cityid = $ds_cityid;
	}

	public function getDs_areaid()
	{
		return $this->ds_areaid;
	}

	public function setDs_areaid($ds_areaid)
	{
		$this->ds_areaid = $ds_areaid;
	}

	public function getDs_shangquanid()
	{
		return $this->ds_shangquanid;
	}

	public function setDs_shangquanid($ds_shangquanid)
	{
		$this->ds_shangquanid = $ds_shangquanid;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getSortid()
	{
		return $this->sortid;
	}

	public function setSortid($sortid)
	{
		$this->sortid = $sortid;
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

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function getScore()
	{
		return $this->score;
	}

	public function setScore($score)
	{
		$this->score = $score;
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

	public function getSource()
	{
		return $this->source;
	}

	public function setSource($source)
	{
		$this->source = $source;
	}

	public function getMatchid()
	{
		return $this->matchid;
	}

	public function setMatchid($matchid)
	{
		$this->matchid = $matchid;
	}

	public function getMatchlevel()
	{
		return $this->matchlevel;
	}

	public function setMatchlevel($matchlevel)
	{
		$this->matchlevel = $matchlevel;
	}

	public function getLetter()
	{
		return $this->letter;
	}

	public function setLetter($letter)
	{
		$this->letter = $letter;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getSchoolroom()
	{
		return $this->schoolroom;
	}

	public function setSchoolroom($schoolroom)
	{
		$this->schoolroom = $schoolroom;
	}

	public function getParaMap()
	{
		return $this->paraMap;
	}

	public function setParaMap($paraMap)
	{
		$this->paraMap = $paraMap;
	}

	public function getWritelog()
	{
		return $this->writelog;
	}

	public function setWritelog($writelog)
	{
		$this->writelog = $writelog;
	}


}