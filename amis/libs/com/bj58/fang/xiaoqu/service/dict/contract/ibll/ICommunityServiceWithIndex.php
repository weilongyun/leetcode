<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\ibll;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\TrafficLine;
use com\bj58\fang\xiaoqu\service\dict\contract\dto\TrafficStationDTO;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\TrafficStation;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\Community;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\CommunityDetail;

class ICommunityServiceWithIndex {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getNearCommunity($cityid = '', $latlons = '', $count = '', $distance = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $cityid,
			'2@List<String>' => $latlons,
			'3@int' => $count,
			'4@double' => $distance,
		);
		$res = $this->ps->invoke('getNearCommunity', $value);
		return $res;
	}

	public function fetchSquareCommunity($cityid = '', $beginLat = '', $beginLon = '', $endLat = '', $endLon = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $beginLat,
			'3@double' => $beginLon,
			'4@double' => $endLat,
			'5@double' => $endLon,
			'6@int' => $count,
		);
		$res = $this->ps->invoke('fetchSquareCommunity', $value);
		return $res;
	}

	public function fetchSqByDistance($cityid = '', $lat = '', $lon = '', $distance = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@double' => $distance,
		);
		$res = $this->ps->invoke('fetchSqByDistance', $value);
		return $res;
	}

	public function fetchAreaByDistance($cityid = '', $lat = '', $lon = '', $distance = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@double' => $distance,
		);
		$res = $this->ps->invoke('fetchAreaByDistance', $value);
		return $res;
	}

	public function fetchSqByDrive($cityid = '', $lat = '', $lon = '', $second = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@int' => $second,
		);
		$res = $this->ps->invoke('fetchSqByDrive', $value);
		return $res;
	}

	public function fetchSqByWalk($cityid = '', $lat = '', $lon = '', $second = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@int' => $second,
		);
		$res = $this->ps->invoke('fetchSqByWalk', $value);
		return $res;
	}

	public function fetchCommunityByBusSubway($cityid = '', $lat = '', $lon = '', $second = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@int' => $second,
		);
		$res = $this->ps->invoke('fetchCommunityByBusSubway', $value);
		return $res;
	}

	public function insertCommunity($entity = '') {
		$value = array(
			'1@Community' => $entity,
		);
		$res = $this->ps->invoke('insertCommunity', $value);
		return $res;
	}

	public function insertDetail($detail = '') {
		$value = array(
			'1@CommunityDetail' => $detail,
		);
		$res = $this->ps->invoke('insertDetail', $value);
		return $res;
	}

	public function insert($entity = '', $detail = '') {
		$value = array(
			'1@Community' => $entity,
			'2@CommunityDetail' => $detail,
		);
		$res = $this->ps->invoke('insert', $value);
		return $res;
	}

	public function get($infoid = '') {
		$dataInfo = ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $infoid,
		);
		$res = $this->ps->invoke('get', $value);
		return $res;
	}

	public function getCommunityDetailById($infoid = '') {
		ObjectSerializer::GetTypeInfo(new CommunityDetail());
		$value = array(
			'1@int' => $infoid,
		);
		$res = $this->ps->invoke('getCommunityDetailById', $value);
		return $res;
	}

	public function update($t = '') {
		$value = array(
			'1@Community' => $t,
		);
		$res = $this->ps->invoke('update', $value);
		return $res;
	}

	public function updateDetail($t = '') {
		$value = array(
			'1@CommunityDetail' => $t,
		);
		$res = $this->ps->invoke('updateDetail', $value);
		return $res;
	}

	public function updateAll($t = '', $detail = '') {
		$value = array(
			'1@Community' => $t,
			'2@CommunityDetail' => $detail,
		);
		$res = $this->ps->invoke('updateAll', $value);
		return $res;
	}

	public function delete($infoid = '') {
		$value = array(
			'1@int' => $infoid,
		);
		$res = $this->ps->invoke('delete', $value);
		return $res;
	}

	public function countAll($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('countAll', $value);
		return $res;
	}

	public function load($where = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('load', $value);
		return $res;
	}

	public function load_PHP_2($where = '', $topn = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $where,
			'2@int' => $topn,
		);
		$res = $this->ps->invoke('load_PHP_2', $value);
		return $res;
	}

	public function load_PHP_3($where = '', $topn = '', $sortField = '', $sortType = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $where,
			'2@int' => $topn,
			'3@String' => $sortField,
			'4@String' => $sortType,
		);
		$res = $this->ps->invoke('load_PHP_3', $value);
		return $res;
	}

	public function pageByRowNumber($where = '', $currentpage = '', $pagesize = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $where,
			'2@int' => $currentpage,
			'3@int' => $pagesize,
		);
		$res = $this->ps->invoke('pageByRowNumber', $value);
		return $res;
	}

	public function pageByRowNumber_PHP_2($where = '', $currentpage = '', $pagesize = '', $sortField = '', $sortType = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $where,
			'2@int' => $currentpage,
			'3@int' => $pagesize,
			'4@String' => $sortField,
			'5@String' => $sortType,
		);
		$res = $this->ps->invoke('pageByRowNumber_PHP_2', $value);
		return $res;
	}

	public function select($idList = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@List<Integer>' => $idList,
		);
		$res = $this->ps->invoke('select', $value);
		return $res;
	}

	public function selectDetail($idList = '') {
		ObjectSerializer::GetTypeInfo(new CommunityDetail());
		$value = array(
			'1@List<Integer>' => $idList,
		);
		$res = $this->ps->invoke('selectDetail', $value);
		return $res;
	}

	public function fetchNearCommunity($infoid = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $infoid,
			'2@double' => $distance,
			'3@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearCommunity', $value);
		return $res;
	}

	public function fetchNearBuss($infoid = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@int' => $infoid,
			'2@double' => $distance,
			'3@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearBuss', $value);
		return $res;
	}

	public function fetchNearSub($infoid = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new TrafficStation());
		$value = array(
			'1@int' => $infoid,
			'2@double' => $distance,
			'3@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearSub', $value);
		return $res;
	}

	public function fetchNearCommunity_PHP_2($cityid = '', $lat = '', $lon = '', $distance = '', $count = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $cityid,
			'2@double' => $lat,
			'3@double' => $lon,
			'4@double' => $distance,
			'5@int' => $count,
		);
		$res = $this->ps->invoke('fetchNearCommunity_PHP_2', $value);
		return $res;
	}

	public function isExistListName($ListName = '', $cityid = '') {
		$value = array(
			'1@String' => $ListName,
			'2@int' => $cityid,
		);
		$res = $this->ps->invoke('isExistListName', $value);
		return $res;
	}

	public function getCommunityByListName($listname = '', $cityid = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $listname,
			'2@int' => $cityid,
		);
		$res = $this->ps->invoke('getCommunityByListName', $value);
		return $res;
	}

	public function getCommunityListByName($name = '', $cityid = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $name,
			'2@int' => $cityid,
		);
		$res = $this->ps->invoke('getCommunityListByName', $value);
		return $res;
	}

	public function getCommunityListByAliasName($aliasname = '', $cityid = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@String' => $aliasname,
			'2@int' => $cityid,
		);
		$res = $this->ps->invoke('getCommunityListByAliasName', $value);
		return $res;
	}

	public function getCommunityListByCityAndName($cityid = '', $name = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@int' => $cityid,
			'2@String' => $name,
		);
		$res = $this->ps->invoke('getCommunityListByCityAndName', $value);
		return $res;
	}

	public function addCommunityLog($optype = '', $infoid = '', $content = '', $cateid = '', $operator = '') {
		$value = array(
			'1@short' => $optype,
			'2@int' => $infoid,
			'3@String' => $content,
			'4@int' => $cateid,
			'5@String' => $operator,
		);
		$res = $this->ps->invoke('addCommunityLog', $value);
		return $res;
	}

	public function recommendByDictAndPrice($infoidList = '', $price = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@List<Integer>' => $infoidList,
			'2@double' => $price,
		);
		$res = $this->ps->invoke('recommendByDictAndPrice', $value);
		return $res;
	}

	public function recommendByLocalAndPrice($dsareaid = '', $dssqid = '', $dscityid = '', $infoidList = '', $price = '') {
		ObjectSerializer::GetTypeInfo(new Community());
		$value = array(
			'1@List<Integer>' => $dsareaid,
			'2@List<Integer>' => $dssqid,
			'3@int' => $dscityid,
			'4@List<Integer>' => $infoidList,
			'5@double' => $price,
		);
		$res = $this->ps->invoke('recommendByLocalAndPrice', $value);
		return $res;
	}

}