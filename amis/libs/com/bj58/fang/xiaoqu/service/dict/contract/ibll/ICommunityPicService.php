<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\ibll;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\CommunityPic;

class ICommunityPicService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function insert($communityPic = '') {
		$value = array(
			'1@CommunityPic' => $communityPic,
		);
		$res = $this->ps->invoke('insert', $value);
		return $res;
	}

	public function getByPicId($id_pic = '') {
		ObjectSerializer::GetTypeInfo(new CommunityPic());
		$value = array(
			'1@long' => $id_pic,
		);
		$res = $this->ps->invoke('getByPicId', $value);
		return $res;
	}

	public function getPicsByComId($id_community = '') {
		ObjectSerializer::GetTypeInfo(new CommunityPic());
		$value = array(
			'1@int' => $id_community,
		);
		$res = $this->ps->invoke('getPicsByComId', $value);
		return $res;
	}

	public function getPicsByComId_PHP_2($id_community = '') {
		ObjectSerializer::GetTypeInfo(new CommunityPic());
		$value = array(
			'1@int' => $id_community,
		);
		$res = $this->ps->invoke('getPicsByComId_PHP_2', $value);
		return $res;
	}

	public function getPicMapByComId($id_community = '', $count = '', $typeStr = '') {
		ObjectSerializer::GetTypeInfo(new CommunityPic());
		$value = array(
			'1@int' => $id_community,
			'2@int' => $count,
			'3@String' => $typeStr,
		);
		$res = $this->ps->invoke('getPicMapByComId', $value);
		return $res;
	}

	public function update($communityPic = '') {
		$value = array(
			'1@CommunityPic' => $communityPic,
		);
		$res = $this->ps->invoke('update', $value);
		return $res;
	}

	public function select($condition = '', $pageSize = '', $page = '', $sortField = '', $sortType = '', $totalCount = '') {
		ObjectSerializer::GetTypeInfo(new CommunityPic());
		$value = array(
			'1@String' => $condition,
			'2@int' => $pageSize,
			'3@int' => $page,
			'4@String' => $sortField,
			'5@String' => $sortType,
			'6@Out<Integer>' => $totalCount,
		);
		$res = $this->ps->invoke('select', $value);
		return $res;
	}

	public function selectCount($condition = '') {
		$value = array(
			'1@String' => $condition,
		);
		$res = $this->ps->invoke('selectCount', $value);
		return $res;
	}

	public function delete($id_pic = '', $flag = '', $password = '') {
		$value = array(
			'1@long' => $id_pic,
			'2@boolean' => $flag,
			'3@String' => $password,
		);
		$res = $this->ps->invoke('delete', $value);
		return $res;
	}

}