<?php
namespace com\bj58\sfft\cmc\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class Templet{
	 static $_TSPEC;
	 static $_SCFNAME = 'Templet';

	private $TempleID;
	private $TempletName;
	private $Templet;
	private $Type;
	private $Order;
	private $_TempletDispCate；;

	 public function __construct($TempleID = '', $TempletName = '', $Templet = '', $Type = '', $Order = '', $_TempletDispCate； = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'TempleID',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'TempletName',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'Templet',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'Type',
					'sortId' => 4,
					'type' => SCFType::I16,
				),

				5=>array(
					'var' => 'Order',
					'sortId' => 5,
					'type' => SCFType::I16,
				),

				6=>array(
					'var' => '_TempletDispCate；',
					'sortId' => 6,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new TempletDispCate(),
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return Templet::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		Templet::$_TSPEC = $_TSPEC;
	}

	public function getTempleID()
	{
		return $this->TempleID;
	}

	public function setTempleID($TempleID)
	{
		$this->TempleID = $TempleID;
	}

	public function getTempletName()
	{
		return $this->TempletName;
	}

	public function setTempletName($TempletName)
	{
		$this->TempletName = $TempletName;
	}

	public function getTemplet()
	{
		return $this->Templet;
	}

	public function setTemplet($Templet)
	{
		$this->Templet = $Templet;
	}

	public function getType()
	{
		return $this->Type;
	}

	public function setType($Type)
	{
		$this->Type = $Type;
	}

	public function getOrder()
	{
		return $this->Order;
	}

	public function setOrder($Order)
	{
		$this->Order = $Order;
	}

	public function get_TempletDispCate；()
	{
		return $this->_TempletDispCate；;
	}

	public function set_TempletDispCate；($_TempletDispCate；)
	{
		$this->_TempletDispCate； = $_TempletDispCate；;
	}


}