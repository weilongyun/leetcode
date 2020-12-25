<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficRelation{
	 static $_TSPEC;
	 static $_SCFNAME = 'TrafficRelation';

	private $id;
	private $lineid;
	private $stationid;
	private $adddate;
	private $sortid;

	 public function __construct($id = '', $lineid = '', $stationid = '', $adddate = '', $sortid = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'lineid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'stationid',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'adddate',
					'sortId' => 4,
					'type' => SCFType::DATE,
				),

				5=>array(
					'var' => 'sortid',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return TrafficRelation::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		TrafficRelation::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getLineid()
	{
		return $this->lineid;
	}

	public function setLineid($lineid)
	{
		$this->lineid = $lineid;
	}

	public function getStationid()
	{
		return $this->stationid;
	}

	public function setStationid($stationid)
	{
		$this->stationid = $stationid;
	}

	public function getAdddate()
	{
		return $this->adddate;
	}

	public function setAdddate($adddate)
	{
		$this->adddate = $adddate;
	}

	public function getSortid()
	{
		return $this->sortid;
	}

	public function setSortid($sortid)
	{
		$this->sortid = $sortid;
	}


}