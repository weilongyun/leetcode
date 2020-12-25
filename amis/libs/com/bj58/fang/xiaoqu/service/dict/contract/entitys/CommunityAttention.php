<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class CommunityAttention{
	 static $_TSPEC;
	 static $_SCFNAME = 'CommunityAttention';

	private $id;
	private $imei;
	private $userid;
	private $type;
	private $adddate;
	private $infoid;

	 public function __construct($id = '', $imei = '', $userid = '', $type = '', $adddate = '', $infoid = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'imei',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'userid',
					'sortId' => 3,
					'type' => SCFType::I64,
				),

				4=>array(
					'var' => 'type',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

				5=>array(
					'var' => 'adddate',
					'sortId' => 5,
					'type' => SCFType::DATE,
				),

				6=>array(
					'var' => 'infoid',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return CommunityAttention::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		CommunityAttention::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getImei()
	{
		return $this->imei;
	}

	public function setImei($imei)
	{
		$this->imei = $imei;
	}

	public function getUserid()
	{
		return $this->userid;
	}

	public function setUserid($userid)
	{
		$this->userid = $userid;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getAdddate()
	{
		return $this->adddate;
	}

	public function setAdddate($adddate)
	{
		$this->adddate = $adddate;
	}

	public function getInfoid()
	{
		return $this->infoid;
	}

	public function setInfoid($infoid)
	{
		$this->infoid = $infoid;
	}


}