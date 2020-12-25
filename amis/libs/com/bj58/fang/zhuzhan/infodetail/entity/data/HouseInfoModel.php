<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\fang\zhuzhan\infodetail\entity\data\ZufangBusinessModel;

class HouseInfoModel{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.fang.zhuzhan.infodetail.entity.data.HouseInfoModel';

	private $basicModel;
	private $bussinessModel;
	private $dictModel;
	private $userModel;
	private $enterpriseModel;
	private $extendModel;
	private $phoneOtherInfo;
	private $zufangBusinessModel;

	 public function __construct($basicModel = '', $bussinessModel = '', $dictModel = '', $userModel = '', $enterpriseModel = '', $extendModel = '', $phoneOtherInfo = '' ,$zufangBusinessModel='') {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'basicModel',
					'sortId' => 1,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new BasicModel(),
					),
				),

				2=>array(
					'var' => 'bussinessModel',
					'sortId' => 2,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new BussinessModel(),
					),
				),

				3=>array(
					'var' => 'dictModel',
					'sortId' => 3,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new DictModel(),
					),
				),

				4=>array(
					'var' => 'userModel',
					'sortId' => 4,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new UserModel(),
					),
				),

				5=>array(
					'var' => 'enterpriseModel',
					'sortId' => 5,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new EnterpriseModel(),
					),
				),

				6=>array(
					'var' => 'extendModel',
					'sortId' => 6,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new ExtendModel(),
					),
				),

				7=>array(
					'var' => 'phoneOtherInfo',
					'sortId' => 7,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new PhoneOtherInfo(),
					),
				),
			 8=>array(
					 'var' => 'ZufangBusinessModel',
					 'sortId' => 8,
					 'type' => SCFType::OBJECT,
					 'elem' => array(
						 'class' => new ZufangBusinessModel(),
					 ),
				 ),

			);
		}

		 $this->basicModel=$basicModel;
		 $this->bussinessModel=$bussinessModel;
		 $this->dictModel=$dictModel;
		 $this->userModel=$userModel;
		 $this->enterpriseModel=$enterpriseModel;
		 $this->extendModel=$extendModel;
		 $this->phoneOtherInfo=$phoneOtherInfo;
		 $this->zufangBusinessModel=$zufangBusinessModel;
	}

	 public static function getTSPEC()
	{
		 return HouseInfoModel::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		HouseInfoModel::$_TSPEC = $_TSPEC;
	}

	public function getBasicModel()
	{
		return $this->basicModel;
	}

	public function setBasicModel($basicModel)
	{
		$this->basicModel = $basicModel;
	}

	public function getBussinessModel()
	{
		return $this->bussinessModel;
	}

	public function setBussinessModel($bussinessModel)
	{
		$this->bussinessModel = $bussinessModel;
	}

	public function getDictModel()
	{
		return $this->dictModel;
	}

	public function setDictModel($dictModel)
	{
		$this->dictModel = $dictModel;
	}

	public function getUserModel()
	{
		return $this->userModel;
	}

	public function setUserModel($userModel)
	{
		$this->userModel = $userModel;
	}

	public function getEnterpriseModel()
	{
		return $this->enterpriseModel;
	}

	public function setEnterpriseModel($enterpriseModel)
	{
		$this->enterpriseModel = $enterpriseModel;
	}

	public function getExtendModel()
	{
		return $this->extendModel;
	}

	public function setExtendModel($extendModel)
	{
		$this->extendModel = $extendModel;
	}

	public function getPhoneOtherInfo()
	{
		return $this->phoneOtherInfo;
	}

	public function setPhoneOtherInfo($phoneOtherInfo)
	{
		$this->phoneOtherInfo = $phoneOtherInfo;
	}

	public function getZufangBusinessModel()
	{
		return $this->zufangBusinessModel;
	}

	public function setZufangBusinessModel($zufangBusinessModel)
	{
		$this->zufangBusinessModel = $zufangBusinessModel;
	}

}