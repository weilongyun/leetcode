<?php
namespace com\bj58\fang\zhuzhan\infodetail\entity\data;

use com\bj58\spat\scf\serialize\component\SCFType;


class DetailResult{
	 static $_TSPEC;
	 static $_SCFNAME = 'com.bj58.fang.zhuzhan.infodetail.entity.data.DetailResult';

	private $houseInfoModel;
	private $group;

	 public function __construct($houseInfoModel = '', $group = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'houseInfoModel',
					'sortId' => 1,
					'type' => SCFType::OBJECT,
					'elem' => array( 
						'class' => new HouseInfoModel(),
					),
				),

				2=>array(
					'var' => 'group',
					'sortId' => 2,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::LST,
						'elem' => array( 
							'type' => SCFType::MAP,
							'key' => array(
								'type' => SCFType::STRING,
							),
							'value' => array(
								'type' => SCFType::STRING,
							),
						),
					),
				),

			);
		}
		 $this->houseInfoModel=$houseInfoModel;
		 $this->group=$group;
	}

	 public static function getTSPEC()
	{
		 return DetailResult::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		DetailResult::$_TSPEC = $_TSPEC;
	}

	public function getHouseInfoModel()
	{
		return $this->houseInfoModel;
	}

	public function setHouseInfoModel($houseInfoModel)
	{
		$this->houseInfoModel = $houseInfoModel;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function setGroup($group)
	{
		$this->group = $group;
	}


}