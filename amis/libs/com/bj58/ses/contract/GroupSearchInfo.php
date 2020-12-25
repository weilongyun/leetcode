<?php
namespace com\bj58\ses\contract;

use com\bj58\spat\scf\serialize\component\SCFType;

class GroupSearchInfo{
	 static $_TSPEC;
	 static $_SCFNAME = 'GroupSearchInfo';

	private $groupId;
	private $totalCount;
	private $score;
	private $count;

	 public function __construct($groupId = '', $totalCount = '', $score = '', $count = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'groupId',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'totalCount',
					'sortId' => 2,
					'type' => SCFType::I32,
				),

				3=>array(
					'var' => 'score',
					'sortId' => 3,
					'type' => SCFType::DOUBLE,
				),

				4=>array(
					'var' => 'count',
					'sortId' => 4,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return GroupSearchInfo::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		GroupSearchInfo::$_TSPEC = $_TSPEC;
	}

	public function getGroupId()
	{
		return $this->groupId;
	}

	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	public function getTotalCount()
	{
		return $this->totalCount;
	}

	public function setTotalCount($totalCount)
	{
		$this->totalCount = $totalCount;
	}

	public function getScore()
	{
		return $this->score;
	}

	public function setScore($score)
	{
		$this->score = $score;
	}

	public function getCount()
	{
		return $this->count;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}


}