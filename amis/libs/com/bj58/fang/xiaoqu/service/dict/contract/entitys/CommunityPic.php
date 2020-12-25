<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class CommunityPic{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityPic';

	private $picid;
	private $infoid;
	private $picdesc;
	private $picurl;
	private $pictype;
	private $state;
	private $adddate;
	private $ting;
	private $shi;
	private $wei;
	private $area;
	private $iscover;
	private $toward;

	 public function __construct($picid = '', $infoid = '', $picdesc = '', $picurl = '', $pictype = '', $state = '', $adddate = '', $ting = '', $shi = '', $wei = '', $area = '', $iscover = '', $toward = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'picid',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'infoid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'picdesc',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'picurl',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'pictype',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'state',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'adddate',
					'sortId' => 7,
					'type' => SCFType::DATE,
				),

				8=>array(
					'var' => 'ting',
					'sortId' => 8,
					'type' => SCFType::I32,
				),

				9=>array(
					'var' => 'shi',
					'sortId' => 9,
					'type' => SCFType::I32,
				),

				10=>array(
					'var' => 'wei',
					'sortId' => 10,
					'type' => SCFType::I32,
				),

				11=>array(
					'var' => 'area',
					'sortId' => 11,
					'type' => SCFType::DOUBLE,
				),

				12=>array(
					'var' => 'iscover',
					'sortId' => 12,
					'type' => SCFType::I32,
				),

				13=>array(
					'var' => 'toward',
					'sortId' => 13,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CommunityPic::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CommunityPic::$_TSPEC = $_TSPEC;
	}

	public function getPicid()
	{
		return $this->picid;
	}

	public function setPicid($picid)
	{
		$this->picid = $picid;
	}

	public function getInfoid()
	{
		return $this->infoid;
	}

	public function setInfoid($infoid)
	{
		$this->infoid = $infoid;
	}

	public function getPicdesc()
	{
		return $this->picdesc;
	}

	public function setPicdesc($picdesc)
	{
		$this->picdesc = $picdesc;
	}

	public function getPicurl()
	{
		return $this->picurl;
	}

	public function setPicurl($picurl)
	{
		$this->picurl = $picurl;
	}

	public function getPictype()
	{
		return $this->pictype;
	}

	public function setPictype($pictype)
	{
		$this->pictype = $pictype;
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

	public function getTing()
	{
		return $this->ting;
	}

	public function setTing($ting)
	{
		$this->ting = $ting;
	}

	public function getShi()
	{
		return $this->shi;
	}

	public function setShi($shi)
	{
		$this->shi = $shi;
	}

	public function getWei()
	{
		return $this->wei;
	}

	public function setWei($wei)
	{
		$this->wei = $wei;
	}

	public function getArea()
	{
		return $this->area;
	}

	public function setArea($area)
	{
		$this->area = $area;
	}

	public function getIscover()
	{
		return $this->iscover;
	}

	public function setIscover($iscover)
	{
		$this->iscover = $iscover;
	}

	public function getToward()
	{
		return $this->toward;
	}

	public function setToward($toward)
	{
		$this->toward = $toward;
	}


}