<?php
namespace com\bj58\ses\contract;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\ses\contract\GroupSearchInfo;

class GroupSearchResult{
	 static $_TSPEC;
	 static $_SCFNAME = 'GroupSearchResult';

	private $groupCount;
	private $totalCount;
	private $groupInfoArr;
	private $infoIdArr;
	private $scoreArr;

	 public function __construct($groupCount = '', $totalCount = '', $groupInfoArr = '', $infoIdArr = '', $scoreArr = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'groupCount',
					'sortId' => 1,
					'type' => SCFType::I32,
				),

				2=>array(
					'var' => 'totalCount',
					'sortId' => 2,
					'type' => SCFType::I64,
				),

				3=>array(
					'var' => 'groupInfoArr',
					'sortId' => 3,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new GroupSearchInfo(),
					),
				),

				4=>array(
					'var' => 'infoIdArr',
					'sortId' => 4,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::I64,
					),
				),

				5=>array(
					'var' => 'scoreArr',
					'sortId' => 5,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::DOUBLE,
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return GroupSearchResult::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		GroupSearchResult::$_TSPEC = $_TSPEC;
	}

	public function getGroupCount()
	{
		return $this->groupCount;
	}

	public function setGroupCount($groupCount)
	{
		$this->groupCount = $groupCount;
	}

	public function getTotalCount()
	{
		return $this->totalCount;
	}

	public function setTotalCount($totalCount)
	{
		$this->totalCount = $totalCount;
	}

	public function getGroupInfoArr()
	{
		return $this->groupInfoArr;
	}

	public function setGroupInfoArr($groupInfoArr)
	{
		$this->groupInfoArr = $groupInfoArr;
	}

	public function getInfoIdArr()
	{
		return $this->infoIdArr;
	}

	public function setInfoIdArr($infoIdArr)
	{
		$this->infoIdArr = $infoIdArr;
	}

	public function getScoreArr()
	{
		return $this->scoreArr;
	}

	public function setScoreArr($scoreArr)
	{
		$this->scoreArr = $scoreArr;
	}


}