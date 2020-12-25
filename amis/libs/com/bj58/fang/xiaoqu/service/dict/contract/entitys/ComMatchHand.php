<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class ComMatchHand{
	 static $_TSPEC;
	 static $_SCFNAME = 'ComMatchHand';

	private $id;
	private $infoid;
	private $matchid;
	private $state;
	private $adddate;
	private $groupid;

	 public function __construct($id = '', $infoid = '', $matchid = '', $state = '', $adddate = '', $groupid = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'infoid',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'matchid',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'state',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

				5=>array(
					'var' => 'adddate',
					'sortId' => 5,
					'type' => SCFType::DATE,
				),

				6=>array(
					'var' => 'groupid',
					'sortId' => 6,
					'type' => SCFType::I64,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return ComMatchHand::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		ComMatchHand::$_TSPEC = $_TSPEC;
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

	public function getMatchid()
	{
		return $this->matchid;
	}

	public function setMatchid($matchid)
	{
		$this->matchid = $matchid;
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

	public function getGroupid()
	{
		return $this->groupid;
	}

	public function setGroupid($groupid)
	{
		$this->groupid = $groupid;
	}


}