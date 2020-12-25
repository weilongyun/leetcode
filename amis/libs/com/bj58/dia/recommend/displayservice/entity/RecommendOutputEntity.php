<?php
namespace com\bj58\dia\recommend\displayservice\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\dia\recommend\displayservice\entity\RecommendItemEntity;

class RecommendOutputEntity{
	 static $_TSPEC;
	 static $_SCFNAME = 'RecommendOutputEntity';

	private $items;

	 public function __construct($items = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'items',
					'sortId' => 1,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new RecommendItemEntity(),
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return RecommendOutputEntity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RecommendOutputEntity::$_TSPEC = $_TSPEC;
	}

	public function getItems()
	{
		return $this->items;
	}

	public function setItems($items)
	{
		$this->items = $items;
	}


}