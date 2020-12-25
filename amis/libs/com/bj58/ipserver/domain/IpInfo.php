<?php
namespace com\bj58\ipserver\domain;

use com\bj58\spat\scf\serialize\component\SCFType;

class IpInfo{
	 static $_TSPEC;
	 static $_SCFNAME = 'IpInfo';

	private $begin;
	private $end;
	private $listName;
	private $localName;
	private $countryName;
	private $provinceName;
	private $front_isp;
	private $region;

	 public function __construct($begin = '', $end = '', $listName = '', $localName = '', $countryName = '', $provinceName = '', $front_isp = '', $region = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'begin',
					'sortId' => 1,
					'type' => SCFType::I64,
				),

				2=>array(
					'var' => 'end',
					'sortId' => 2,
					'type' => SCFType::I64,
				),

				3=>array(
					'var' => 'listName',
					'sortId' => 3,
					'type' => SCFType::STRING,
				),

				4=>array(
					'var' => 'localName',
					'sortId' => 4,
					'type' => SCFType::STRING,
				),

				5=>array(
					'var' => 'countryName',
					'sortId' => 5,
					'type' => SCFType::STRING,
				),

				6=>array(
					'var' => 'provinceName',
					'sortId' => 6,
					'type' => SCFType::STRING,
				),

				7=>array(
					'var' => 'front_isp',
					'sortId' => 7,
					'type' => SCFType::STRING,
				),

				8=>array(
					'var' => 'region',
					'sortId' => 8,
					'type' => SCFType::STRING,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return IpInfo::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		IpInfo::$_TSPEC = $_TSPEC;
	}

	public function getBegin()
	{
		return $this->begin;
	}

	public function setBegin($begin)
	{
		$this->begin = $begin;
	}

	public function getEnd()
	{
		return $this->end;
	}

	public function setEnd($end)
	{
		$this->end = $end;
	}

	public function getListName()
	{
		return $this->listName;
	}

	public function setListName($listName)
	{
		$this->listName = $listName;
	}

	public function getLocalName()
	{
		return $this->localName;
	}

	public function setLocalName($localName)
	{
		$this->localName = $localName;
	}

	public function getCountryName()
	{
		return $this->countryName;
	}

	public function setCountryName($countryName)
	{
		$this->countryName = $countryName;
	}

	public function getProvinceName()
	{
		return $this->provinceName;
	}

	public function setProvinceName($provinceName)
	{
		$this->provinceName = $provinceName;
	}

	public function getFront_isp()
	{
		return $this->front_isp;
	}

	public function setFront_isp($front_isp)
	{
		$this->front_isp = $front_isp;
	}

	public function getRegion()
	{
		return $this->region;
	}

	public function setRegion($region)
	{
		$this->region = $region;
	}


}