<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfft\cmc\entity\DispCategory;
use com\bj58\sfft\cmc\entity\DispLocal;
use com\bj58\sfft\cmc\entity\DispLocal2;

use com\bj58\sfft\imc\entity\Info;

class BasicModel extends Info{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.fang.zhuzhan.infodetail.entity.data.BasicModel';

	private $cityDispId;
	private $dispCity;
	private $currentDispLocal;
	private $basicCateId=0;
	private $dispCategory;
	private $basicUrl;
	private $infoUrl;
	private $fengmianPics;
	private $descPics;
	private $dispLocalFullList;

	 public function __construct($cityDispId = '', $dispCity = '', $currentDispLocal = '', $basicCateId = 0, $dispCategory = '', $basicUrl = '', $infoUrl = '', $fengmianPics = '', $descPics = '', $dispLocalFullList = '' ) {
		 parent::__construct();
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'cityDispId',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'dispCity',
					'sortId' => 2,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new DispLocal(),
					),
				),

				3=>array(
					'var' => 'currentDispLocal',
					'sortId' => 3,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new DispLocal(),
					),
				),

				4=>array(
					'var' =>'basicCateId',
					'sortId' => 4,
					'type' => SCFType::I32,

				),

				5=>array(
					'var' => 'dispCategory',
					'sortId' => 5,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new DispCategory(),
					),
				),

				6=>array(
					'var' => 'basicUrl',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'infoUrl',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'fengmianPics',
					'sortId' => 8,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'elem' => array( 
							'class' => new HrefModel(),
						),
					),
				),

				9=>array(
					'var' => 'descPics',
					'sortId' => 9,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'elem' => array( 
							'class' => new HrefModel(),
						),
					),
				),

				10=>array(
					'var' => 'dispLocalFullList',
					'sortId' => 10,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'elem' => array( 
							'class' => new DispLocal(),
						),
					),
				),
			);

		}
		 $this->cityDispId=$cityDispId;
		 $this->dispCity=$dispCity;
		 $this->currentDispLocal=$currentDispLocal;
		 $this->basicCateId=$basicCateId;
		 $this->dispCategory=$dispCategory;
		 $this->basicUrl=$basicUrl;
		 $this->infoUrl=$infoUrl;
		 $this->fengmianPics=$fengmianPics;
		 $this->descPics=$descPics;
		 $this->dispLocalFullList=$dispLocalFullList;

	}

	 public static function getTSPEC()
	{
		 return BasicModel::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		BasicModel::$_TSPEC = $_TSPEC;
	}

	public function getCityDispId()
	{
		return $this->cityDispId;
	}

	public function setCityDispId($cityDispId)
	{
		$this->cityDispId = $cityDispId;
	}

	public function getDispCity()
	{
		return $this->dispCity;
	}

	public function setDispCity($dispCity)
	{
		$this->dispCity = $dispCity;
	}

	public function getCurrentDispLocal()
	{
		return $this->currentDispLocal;
	}

	public function setCurrentDispLocal($currentDispLocal)
	{
		$this->currentDispLocal = $currentDispLocal;
	}

	public function getBasicCateId()
	{
		return $this->basicCateId;
	}

	public function setBasicCateId($basicCateId)
	{
		$this->CateId = $basicCateId;
	}

	public function getDispCategory()
	{
		return $this->dispCategory;
	}

	public function setDispCategory($dispCategory)
	{
		$this->dispCategory = $dispCategory;
	}

	public function getBasicUrl()
	{
		return $this->basicUrl;
	}

	public function setBasicUrl($basicUrl)
	{
		$this->basicUrl = $basicUrl;
	}

	public function getInfoUrl()
	{
		return $this->infoUrl;
	}

	public function setInfoUrl($infoUrl)
	{
		$this->infoUrl = $infoUrl;
	}

	public function getFengmianPics()
	{
		return $this->fengmianPics;
	}

	public function setFengmianPics($fengmianPics)
	{
		$this->fengmianPics = $fengmianPics;
	}

	public function getDescPics()
	{
		return $this->descPics;
	}

	public function setDescPics($descPics)
	{
		$this->descPics = $descPics;
	}

	public function getDispLocalFullList()
	{
		return $this->dispLocalFullList;
	}

	public function setDispLocalFullList($dispLocalFullList)
	{
		$this->dispLocalFullList = $dispLocalFullList;
	}


}
