<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\entitys;

use com\bj58\spat\scf\serialize\component\SCFType;

class BusSESinfo{
	 static $_TSPEC;
	 static $_SCFNAME = 'BusSESinfo';

	private $id;
	private $infoid;
	private $addtime;
	private $isexec;
	private $type;

	 public function __construct($id = '', $infoid = '', $addtime = '', $isexec = '', $type = '' ) {
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
					'type' => SCFType::I64,
				),

				3=>array(
					'var' => 'addtime',
					'sortId' => 3,
					'type' => SCFType::DATE,
				),

				4=>array(
					'var' => 'isexec',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

				5=>array(
					'var' => 'type',
					'sortId' => 5,
					'type' => SCFType::I16,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return BusSESinfo::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		BusSESinfo::$_TSPEC = $_TSPEC;
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

	public function getAddtime()
	{
		return $this->addtime;
	}

	public function setAddtime($addtime)
	{
		$this->addtime = $addtime;
	}

	public function getIsexec()
	{
		return $this->isexec;
	}

	public function setIsexec($isexec)
	{
		$this->isexec = $isexec;
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