<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class Surround{
	 static $_TSPEC;
	 static $_SCFNAME = 'Surround';

	private $sid;
	private $cateid;
	private $name;
	private $comment;
	private $cityid;
	private $lon;
	private $lat;
	private $baidu_uid;
	private $address;
	private $telephone;
	private $adddate;
	private $postdate;
	private $state;
	private $expanse;
	private $dict_ids;
	private $level_index;
	private $id_ajk;

	 public function __construct($sid = '', $cateid = '', $name = '', $comment = '', $cityid = '', $lon = '', $lat = '', $baidu_uid = '', $address = '', $telephone = '', $adddate = '', $postdate = '', $state = '', $expanse = '', $dict_ids = '', $level_index = '', $id_ajk = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'sid',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'cateid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'name',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'comment',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'cityid',
					'sortId' => 5,
					'type' => SCFType::I32,
				),

				6=>array(
					'var' => 'lon',
					'sortId' => 6,
					'type' => SCFType::DOUBLE,
				),

				7=>array(
					'var' => 'lat',
					'sortId' => 7,
					'type' => SCFType::DOUBLE,
				),

				8=>array(
					'var' => 'baidu_uid',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'address',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'telephone',
					'sortId' => 10,
					'type' => SCFType::STRING,
				),

				11=>array(
					'var' => 'adddate',
					'sortId' => 11,
					'type' => SCFType::DATE,
				),

				12=>array(
					'var' => 'postdate',
					'sortId' => 12,
					'type' => SCFType::DATE,
				),

				13=>array(
					'var' => 'state',
					'sortId' => 13,
					'type' => SCFType::BYTE,
				),

				14=>array(
					'var' => 'expanse',
					'sortId' => 14,
					'type' => SCFType::STRING,
				),

				15=>array(
					'var' => 'dict_ids',
					'sortId' => 15,
					'type' => SCFType::STRING,
				),

				16=>array(
					'var' => 'level_index',
					'sortId' => 16,
					'type' => SCFType::STRING,
				),

				17=>array(
					'var' => 'id_ajk',
					'sortId' => 17,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Surround::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Surround::$_TSPEC = $_TSPEC;
	}

	public function getSid()
	{
		return $this->sid;
	}

	public function setSid($sid)
	{
		$this->sid = $sid;
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

	public function getBaidu_uid()
	{
		return $this->baidu_uid;
	}

	public function setBaidu_uid($baidu_uid)
	{
		$this->baidu_uid = $baidu_uid;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function getTelephone()
	{
		return $this->telephone;
	}

	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
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

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getExpanse()
	{
		return $this->expanse;
	}

	public function setExpanse($expanse)
	{
		$this->expanse = $expanse;
	}

	public function getDict_ids()
	{
		return $this->dict_ids;
	}

	public function setDict_ids($dict_ids)
	{
		$this->dict_ids = $dict_ids;
	}

	public function getLevel_index()
	{
		return $this->level_index;
	}

	public function setLevel_index($level_index)
	{
		$this->level_index = $level_index;
	}

	public function getId_ajk()
	{
		return $this->id_ajk;
	}

	public function setId_ajk($id_ajk)
	{
		$this->id_ajk = $id_ajk;
	}


}