<?php
namespace com\bj58\sfb\queryrecClient\entity;

use com\bj58\spat\scf\serialize\component\SCFType;

class QueryRecRequest{
	 static $_TSPEC;
	 static $_SCFNAME = 'QueryRecRequest';

	private $business;
	private $querySource;
	private $queryParams;
	private $cookie;
	private $uid;
	private $size;
	private $page;
	private $parameters;

	 public function __construct($business = '', $querySource = '', $queryParams = '', $cookie = '', $uid = '', $size = '', $page = '', $parameters = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'business',
					'sortId' => 1,
					'type' => SCFType::STRING,
				),

				2=>array(
					'var' => 'querySource',
					'sortId' => 2,
					'type' => SCFType::STRING,
				),

				3=>array(
					'var' => 'queryParams',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'cookie',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'uid',
					'sortId' => 5,
					'type' => SCFType::I64,
				),

				6=>array(
					'var' => 'size',
					'sortId' => 6,
					'type' => SCFType::I32,
				),

				7=>array(
					'var' => 'page',
					'sortId' => 7,
					'type' => SCFType::I32,
				),

				8=>array(
					'var' => 'parameters',
					'sortId' => 8,
					'type' => SCFType::MAP,
					'key' => array(
						'type' => SCFType::STRING,
					),
					'value' => array(
						'type' => SCFType::STRING,
					),
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return QueryRecRequest::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		QueryRecRequest::$_TSPEC = $_TSPEC;
	}

	public function getBusiness()
	{
		return $this->business;
	}

	public function setBusiness($business)
	{
		$this->business = $business;
	}

	public function getQuerySource()
	{
		return $this->querySource;
	}

	public function setQuerySource($querySource)
	{
		$this->querySource = $querySource;
	}

	public function getQueryParams()
	{
		return $this->queryParams;
	}

	public function setQueryParams($queryParams)
	{
		$this->queryParams = $queryParams;
	}

	public function getCookie()
	{
		return $this->cookie;
	}

	public function setCookie($cookie)
	{
		$this->cookie = $cookie;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function setUid($uid)
	{
		$this->uid = $uid;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function setPage($page)
	{
		$this->page = $page;
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
