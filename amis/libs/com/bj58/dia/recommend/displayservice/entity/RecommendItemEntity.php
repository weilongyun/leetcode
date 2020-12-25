<?php
namespace com\bj58\dia\recommend\displayservice\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class RecommendItemEntity{
	 static $_TSPEC;
	 static $_SCFNAME = 'RecommendItemEntity';

	private $businessEntityType;
	private $entityId;
	private $dispalyNumber;
	private $groupReason;
	private $itemReason;
	private $itemDisplayControlParams;
	private $tag;
	private $groupTagDetail;
	private $itemTagDetail;
	private $dispalyUniqueId;

	 public function __construct($businessEntityType = '', $entityId = '', $dispalyNumber = '', $groupReason = '', $itemReason = '', $itemDisplayControlParams = '', $tag = '', $groupTagDetail = '', $itemTagDetail = '', $dispalyUniqueId = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'businessEntityType',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'entityId',
					'sortId' => 2,
					'type' => SCFType::I64,
				),

				3=>array(
					'var' => 'dispalyNumber',
					'sortId' => 21,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'groupReason',
					'sortId' => 22,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'itemReason',
					'sortId' => 23,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'itemDisplayControlParams',
					'sortId' => 24,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'tag',
					'sortId' => 41,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'groupTagDetail',
					'sortId' => 42,
					'type' => SCFType::STRING,
				),

				9=>array(
					'var' => 'itemTagDetail',
					'sortId' => 43,
					'type' => SCFType::STRING,
				),

				10=>array(
					'var' => 'dispalyUniqueId',
					'sortId' => 44,
					'type' => SCFType::I64,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return RecommendItemEntity::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		RecommendItemEntity::$_TSPEC = $_TSPEC;
	}

	public function getBusinessEntityType()
	{
		return $this->businessEntityType;
	}

	public function setBusinessEntityType($businessEntityType)
	{
		$this->businessEntityType = $businessEntityType;
	}

	public function getEntityId()
	{
		return $this->entityId;
	}

	public function setEntityId($entityId)
	{
		$this->entityId = $entityId;
	}

	public function getDispalyNumber()
	{
		return $this->dispalyNumber;
	}

	public function setDispalyNumber($dispalyNumber)
	{
		$this->dispalyNumber = $dispalyNumber;
	}

	public function getGroupReason()
	{
		return $this->groupReason;
	}

	public function setGroupReason($groupReason)
	{
		$this->groupReason = $groupReason;
	}

	public function getItemReason()
	{
		return $this->itemReason;
	}

	public function setItemReason($itemReason)
	{
		$this->itemReason = $itemReason;
	}

	public function getItemDisplayControlParams()
	{
		return $this->itemDisplayControlParams;
	}

	public function setItemDisplayControlParams($itemDisplayControlParams)
	{
		$this->itemDisplayControlParams = $itemDisplayControlParams;
	}

	public function getTag()
	{
		return $this->tag;
	}

	public function setTag($tag)
	{
		$this->tag = $tag;
	}

	public function getGroupTagDetail()
	{
		return $this->groupTagDetail;
	}

	public function setGroupTagDetail($groupTagDetail)
	{
		$this->groupTagDetail = $groupTagDetail;
	}

	public function getItemTagDetail()
	{
		return $this->itemTagDetail;
	}

	public function setItemTagDetail($itemTagDetail)
	{
		$this->itemTagDetail = $itemTagDetail;
	}

	public function getDispalyUniqueId()
	{
		return $this->dispalyUniqueId;
	}

	public function setDispalyUniqueId($dispalyUniqueId)
	{
		$this->dispalyUniqueId = $dispalyUniqueId;
	}


}