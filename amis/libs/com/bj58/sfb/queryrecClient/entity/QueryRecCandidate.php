<?php
namespace com\bj58\sfb\queryrecClient\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfb\queryrecClient\entity\MapEntry;

class QueryRecCandidate{
	 static $_TSPEC;
	 static $_SCFNAME = 'QueryRecCandidate';

	protected $queryParams;
	protected $infoIdsScores;
	protected $status;
	protected $recommendBy;
	protected $reason;

	 public function __construct($queryParams = '', $infoIdsScores = '', $status = '', $recommendBy = '', $reason = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'queryParams',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'infoIdsScores',
					'sortId' => 2,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new MapEntry(),
					),
				),

				3=>array(
					'var' => 'status',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

				4=>array(
					'var' => 'recommendBy',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'reason',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return QueryRecCandidate::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		QueryRecCandidate::$_TSPEC = $_TSPEC;
	}

	public function getQueryParams()
	{
		return $this->queryParams;
	}

	public function setQueryParams($queryParams)
	{
		$this->queryParams = $queryParams;
	}

	public function getInfoIdsScores()
	{
		return $this->infoIdsScores;
	}

	public function setInfoIdsScores($infoIdsScores)
	{
		$this->infoIdsScores = $infoIdsScores;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function getRecommendBy()
	{
		return $this->recommendBy;
	}

	public function setRecommendBy($recommendBy)
	{
		$this->recommendBy = $recommendBy;
	}

	public function getReason()
	{
		return $this->reason;
	}

	public function setReason($reason)
	{
		$this->reason = $reason;
	}


}