<?php
namespace com\bj58\fang\xiaoqu\service\dict\contract\ibll;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\fang\xiaoqu\service\dict\contract\entitys\CommunityManager;

class ICommunityManagerService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function get($id = '') {
		ObjectSerializer::GetTypeInfo(new CommunityManager());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('get', $value);
		return $res;
	}

	public function getManagerByInfoid($infoid = '') {
		ObjectSerializer::GetTypeInfo(new CommunityManager());
		$value = array(
			'1@int' => $infoid,
		);
		$res = $this->ps->invoke('getManagerByInfoid', $value);
		return $res;
	}

	public function insert($CommunityManager = '') {
		$value = array(
			'1@CommunityManager' => $CommunityManager,
		);
		$res = $this->ps->invoke('insert', $value);
		return $res;
	}

	public function update($CommunityManager = '') {
		$value = array(
			'1@CommunityManager' => $CommunityManager,
		);
		$res = $this->ps->invoke('update', $value);
		return $res;
	}

	public function delete($id = '') {
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('delete', $value);
		return $res;
	}

	public function select($where = '', $currentpage = '', $pagesize = '') {
		ObjectSerializer::GetTypeInfo(new CommunityManager());
		$value = array(
			'1@String' => $where,
			'2@int' => $currentpage,
			'3@int' => $pagesize,
		);
		$res = $this->ps->invoke('select', $value);
		return $res;
	}

	public function count($condition = '') {
		$value = array(
			'1@String' => $condition,
		);
		$res = $this->ps->invoke('count', $value);
		return $res;
	}

}