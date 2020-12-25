<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\dto;

use com\bj58\spat\scf\serialize\component\SCFType;

class TrafficStationPointDTO{
	 static $_TSPEC;
	 static $_SCFNAME = 'TrafficStationPointDTO';

	private $lon;
	private $lat;
	private $radius;

	 public function __construct($lon = '', $lat = '', $radius = '' ) {
		 if (!isset(self::$_TSPEC)) {
			 self::$_TSPEC = array(
				1=>array(
					'var' => 'lon',
					'sortId' => 1,
					'type' => SCFType::DOUBLE,
				),

				2=>array(
					'var' => 'lat',
					'sortId' => 2,
					'type' => SCFType::DOUBLE,
				),

				3=>array(
					'var' => 'radius',
					'sortId' => 3,
					'type' => SCFType::I32,
				),

			);
		}
	}

	 public static function getTSPEC()
	{
		 return TrafficStationPointDTO::$_TSPEC;
	}
	 public static function setTSPEC($_TSPEC)
	{
		TrafficStationPointDTO::$_TSPEC = $_TSPEC;
	}

	public function getLon()
	{
		return $this->lon;
	}

	public function setLon($lon)
	{
		$this->lon = $lon;
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function setLat($lat)
	{
		$this->lat = $lat;
	}

	public function getRadius()
	{
		return $this->radius;
	}

	public function setRadius($radius)
	{
		$this->radius = $radius;
	}


}