<?php
namespace com\bj58\sfb\queryrecClient\entity;

use com\bj58\spat\scf\serialize\component\SCFType;
use com\bj58\sfb\queryrecClient\entity\QueryRecCandidate;

class QueryRecResponse{
	 static $_TSPEC;
	 static $_SCFNAME = 'QueryRecResponse';

	private $recommends;
	private $sortMethod;
	private $timeOut;
	private $description;
	private $parameters;

	 public function __construct($recommends = '', $sortMethod = '', $timeOut = '', $description = '', $parameters = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'recommends',
					'sortId' => 1,
					'type' => SCFType::LST,
					'elem' => array( 
						'type' => SCFType::OBJECT,
						'class' => new QueryRecCandidate(),
					),
				),

				2=>array(
					'var' => 'sortMethod',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'timeOut',
					'sortId' => 3,
					'type' => SCFType::BOOL,
				),

				4=>array(
					'var' => 'description',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'parameters',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return QueryRecResponse::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		QueryRecResponse::$_TSPEC = $_TSPEC;
	}

	public function getRecommends()
	{
		return $this->recommends;
	}

	public function setRecommends($recommends)
	{
		$this->recommends = $recommends;
	}

	public function getSortMethod()
	{
		return $this->sortMethod;
	}

	public function setSortMethod($sortMethod)
	{
		$this->sortMethod = $sortMethod;
	}

	public function getTimeOut()
	{
		return $this->timeOut;
	}

	public function setTimeOut($timeOut)
	{
		$this->timeOut = $timeOut;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getParameters()
	{
		return $this->parameters;
	}

	public function setParameters($parameters)
	{
		$this->parameters = $parameters;
	}


}