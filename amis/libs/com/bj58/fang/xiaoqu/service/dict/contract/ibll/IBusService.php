<?php
namespace  com\bj58\fang\xiaoqu\service\dict\contract\ibll;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\TrafficStation;

class IBusService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getBusLineByCity($cityid = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@int' => $cityid,
		);
		$res = $this->ps->invoke('getBusLineByCity', $value);
		return $res;
	}

	public function getBusLineByCityNoCache($cityid = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@int' => $cityid,
		);
		$res = $this->ps->invoke('getBusLineByCityNoCache', $value);
		return $res;
	}

	public function getBusStationsByLineid($lineid = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@int' => $lineid,
		);
		$res = $this->ps->invoke('getBusStationsByLineid', $value);
		return $res;
	}

	public function getBusStationsByLineidNoCache($lineid = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@int' => $lineid,
		);
		$res = $this->ps->invoke('getBusStationsByLineidNoCache', $value);
		return $res;
	}

	public function getBusLineByStationid($stationid = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@int' => $stationid,
		);
		$res = $this->ps->invoke('getBusLineByStationid', $value);
		return $res;
	}

	public function getBusLineByStationIds($idList = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@List<Integer>' => $idList,
		);
		$res = $this->ps->invoke('getBusLineByStationIds', $value);
		return $res;
	}

	public function updateBusline($trafficLine = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@TrafficLine' => $trafficLine,
		);
		$res = $this->ps->invoke('updateBusline', $value);
		return $res;
	}

	public function deleteBusLine($buslineid = '') {
		$value = array(
			'1@int' => $buslineid,
		);
		$res = $this->ps->invoke('deleteBusLine', $value);
		return $res;
	}

	public function updateBusstation($busStation = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@TrafficStation' => $busStation,
		);
		$res = $this->ps->invoke('updateBusstation', $value);
		return $res;
	}

	public function deleteBusstation($busstationid = '') {
		$value = array(
			'1@int' => $busstationid,
		);
		$res = $this->ps->invoke('deleteBusstation', $value);
		return $res;
	}

	public function fetchNearBusstation($lat = '', $lon = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@double' => $lat,
			'2@double' => $lon,
			'3@double' => $distance,
			'4@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearBusstation', $value);
		return $res;
	}

	public function fetchNearBusstation_PHP_2($infoid = '', $distance = '', $count = '') {
		$value = array(
			'1@int' => $infoid,
			'2@double' => $distance,
			'3@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearBusstation_PHP_2', $value);
		return $res;
	}

	public function fetchNearBusstationDTO($infoid = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new StationDistanceEnum());
		ObjectSerializer::GetTypeInfo(new TrafficStationDTO());
		ObjectSerializer::GetTypeInfo(new StationCountEnum());
		$value = array(
			'1@int' => $infoid,
			'2@StationDistanceEnum' => $distance,
			'3@StationCountEnum' => $count,
		);
		$res = $this->ps->invoke('fetchNearBusstationDTO', $value);
		return $res;
	}

	public function fetchNearBusstationDTOMap($infoids = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new StationDistanceEnum());
		ObjectSerializer::GetTypeInfo(new TrafficStationDTO());
		ObjectSerializer::GetTypeInfo(new StationCountEnum());
		$value = array(
			'1@List<Integer>' => $infoids,
			'2@StationDistanceEnum' => $distance,
			'3@StationCountEnum' => $count,
		);
		$res = $this->ps->invoke('fetchNearBusstationDTOMap', $value);
		return $res;
	}

	public function selectBusline($ids = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@long[]' => $ids,
		);
		$res = $this->ps->invoke('selectBusline', $value);
		return $res;
	}

	public function selectBusstation($ids = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@long[]' => $ids,
		);
		$res = $this->ps->invoke('selectBusstation', $value);
		return $res;
	}

	public function getLineCountByCondition($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('getLineCountByCondition', $value);
		return $res;
	}

	public function getStationCountByCondition($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('getStationCountByCondition', $value);
		return $res;
	}

	public function getBuslinepageByRowNumber($where = '', $currentpage = '', $pagesize = '', $sortField = '', $sortType = '') {
		ObjectSerializer::GetTypeInfo(new TrafficLine());
		$value = array(
			'1@String' => $where,
			'2@int' => $currentpage,
			'3@int' => $pagesize,
			'4@String' => $sortField,
			'5@String' => $sortType,
		);
		$res = $this->ps->invoke('getBuslinepageByRowNumber', $value);
		return $res;
	}

	public function getBussattionpageByRowNumber($where = '', $currentpage = '', $pagesize = '', $sortField = '', $sortType = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@String' => $where,
			'2@int' => $currentpage,
			'3@int' => $pagesize,
			'4@String' => $sortField,
			'5@String' => $sortType,
		);
		$res = $this->ps->invoke('getBussattionpageByRowNumber', $value);
		return $res;
	}

	public function getBeforeAfterStation($trafficStation = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@TrafficStation' => $trafficStation,
		);
		$res = $this->ps->invoke('getBeforeAfterStation', $value);
		return $res;
	}

}