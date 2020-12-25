<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfft\cmc\entity\Local;
use com\bj58\sfft\cmc\entity\DispLocal;

class Top100County{
	 static $_TSPEC;
	 static $_SCFNAME = 'Top100County';

	private $id;
	private $localID;
	private $dispLocalID;
	private $newDispLocalID;
	private $extend;
	private $local;
	private $dispLocal;
	private $newDispLocal;

	 public function __construct($id = '', $localID = '', $dispLocalID = '', $newDispLocalID = '', $extend = '', $local = '', $dispLocal = '', $newDispLocal = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'id',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'localID',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'dispLocalID',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'newDispLocalID',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

				5=>array(
					'var' => 'extend',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'local',
					'sortId' => 6,
					'type' => SCFType::OBJECT,
					'class' => new Local(),
				),

				7=>array(
					'var' => 'dispLocal',
					'sortId' => 7,
					'type' => SCFType::OBJECT,
					'class' => new DispLocal(),
				),

				8=>array(
					'var' => 'newDispLocal',
					'sortId' => 8,
					'type' => SCFType::OBJECT,
					'class' => new DispLocal(),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Top100County::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Top100County::$_TSPEC = $_TSPEC;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getLocalID()
	{
		return $this->localID;
	}

	public function setLocalID($localID)
	{
		$this->localID = $localID;
	}

	public function getDispLocalID()
	{
		return $this->dispLocalID;
	}

	public function setDispLocalID($dispLocalID)
	{
		$this->dispLocalID = $dispLocalID;
	}

	public function getNewDispLocalID()
	{
		return $this->newDispLocalID;
	}

	public function setNewDispLocalID($newDispLocalID)
	{
		$this->newDispLocalID = $newDispLocalID;
	}

	public function getExtend()
	{
		return $this->extend;
	}

	public function setExtend($extend)
	{
		$this->extend = $extend;
	}

	public function getLocal()
	{
		return $this->local;
	}

	public function setLocal($local)
	{
		$this->local = $local;
	}

	public function getDispLocal()
	{
		return $this->dispLocal;
	}

	public function setDispLocal($dispLocal)
	{
		$this->dispLocal = $dispLocal;
	}

	public function getNewDispLocal()
	{
		return $this->newDispLocal;
	}

	public function setNewDispLocal($newDispLocal)
	{
		$this->newDispLocal = $newDispLocal;
	}


}