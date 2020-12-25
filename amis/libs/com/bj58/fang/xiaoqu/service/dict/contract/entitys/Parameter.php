<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class Parameter{
	 static $_TSPEC;
	 static $_SCFNAME = 'Parameter';

	private $id;
	private $parametername;
	private $cityid;
	private $cateid;
	private $createindex;
	private $fieldtype;
	private $adddate;
	private $postdate;
	private $explain;
	private $state;
	private $showtext;
	private $type;

	 public function __construct($id = '', $parametername = '', $cityid = '', $cateid = '', $createindex = '', $fieldtype = '', $adddate = '', $postdate = '', $explain = '', $state = '', $showtext = '', $type = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'parametername',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'cityid',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'cateid',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'createindex',
					'sortId' => 5,
					'type' => SCFType::BYTE,
				),

				6=>array(
					'var' => 'fieldtype',
					'sortId' => 6,
					'type' => SCFType::BYTE,
				),

				7=>array(
					'var' => 'adddate',
					'sortId' => 7,
					'type' => SCFType::DATE,
				),

				8=>array(
					'var' => 'postdate',
					'sortId' => 8,
					'type' => SCFType::DATE,
				),

				9=>array(
					'var' => 'explain',
					'sortId' => 9,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'state',
					'sortId' => 10,
					'type' => SCFType::BYTE,
				),

				11=>array(
					'var' => 'showtext',
					'sortId' => 11,
					'type' => SCFType::STRING,
				),

				12=>array(
					'var' => 'type',
					'sortId' => 12,
					'type' => SCFType::BYTE,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Parameter::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Parameter::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getParametername()
	{
		return $this->parametername;
	}

	public function setParametername($parametername)
	{
		$this->parametername = $parametername;
	}

	public function getCityid()
	{
		return $this->cityid;
	}

	public function setCityid($cityid)
	{
		$this->cityid = $cityid;
	}

	public function getCateid()
	{
		return $this->cateid;
	}

	public function setCateid($cateid)
	{
		$this->cateid = $cateid;
	}

	public function getCreateindex()
	{
		return $this->createindex;
	}

	public function setCreateindex($createindex)
	{
		$this->createindex = $createindex;
	}

	public function getFieldtype()
	{
		return $this->fieldtype;
	}

	public function setFieldtype($fieldtype)
	{
		$this->fieldtype = $fieldtype;
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

	public function getExplain()
	{
		return $this->explain;
	}

	public function setExplain($explain)
	{
		$this->explain = $explain;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getShowtext()
	{
		return $this->showtext;
	}

	public function setShowtext($showtext)
	{
		$this->showtext = $showtext;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}


}