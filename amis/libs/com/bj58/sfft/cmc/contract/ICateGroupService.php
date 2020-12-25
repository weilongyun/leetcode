<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\LocalCateGroup;

class ICateGroupService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetCateGroupByID($dispGroupID = '') {
		ObjectSerializer::GetTypeInfo(new CateGroup());
		$value = array(
			'1@int' => $dispGroupID,
		);
		$res = $this->ps->invoke('GetCateGroupByID', $value);
		return $res;
	}

	public function GetCateGroupAll() {
		ObjectSerializer::GetTypeInfo(new CateGroup());
		$value = array(
		);
		$res = $this->ps->invoke('GetCateGroupAll', $value);
		return $res;
	}

	public function GetCateGroup($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new CateGroup());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetCateGroup', $value);
		return $res;
	}

	public function AddCateGroup($entity = '') {
		$value = array(
			'1@Out<CateGroup>' => $entity,
		);
		$res = $this->ps->invoke('AddCateGroup', $value);
		return $res;
	}

	public function DeleteCateGroupByID($dispGroupID = '') {
		$value = array(
			'1@int' => $dispGroupID,
		);
		$res = $this->ps->invoke('DeleteCateGroupByID', $value);
		return $res;
	}

	public function DeleteCateGroup($entity = '') {
		$value = array(
			'1@CateGroup' => $entity,
		);
		$res = $this->ps->invoke('DeleteCateGroup', $value);
		return $res;
	}

	public function DeleteCateGroup_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteCateGroup_PHP_2', $value);
		return $res;
	}

	public function UpdateCategory($entity = '') {
		$value = array(
			'1@CateGroup' => $entity,
		);
		$res = $this->ps->invoke('UpdateCategory', $value);
		return $res;
	}

	public function CopyDispCategory($olddispgroupid = '', $newdispgroupid = '') {
		$value = array(
			'1@int' => $olddispgroupid,
			'2@int' => $newdispgroupid,
		);
		$res = $this->ps->invoke('CopyDispCategory', $value);
		return $res;
	}

	public function GetCateGroupByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new CateGroup());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetCateGroupByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetLocalCateGroupByCateGroupID($categroupid = '') {
		ObjectSerializer::GetTypeInfo(new LocalCateGroup());
		$value = array(
			'1@int' => $categroupid,
		);
		$res = $this->ps->invoke('GetLocalCateGroupByCateGroupID', $value);
		return $res;
	}

	public function DeleteLocalCateGroupByCateGroupID($DispGroupID = '') {
		$value = array(
			'1@int' => $DispGroupID,
		);
		$res = $this->ps->invoke('DeleteLocalCateGroupByCateGroupID', $value);
		return $res;
	}

	public function GetCateGroupByDispLocalID($displocalid = '') {
		ObjectSerializer::GetTypeInfo(new CateGroup());
		$value = array(
			'1@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetCateGroupByDispLocalID', $value);
		return $res;
	}

	public function ReCacheCateGroup() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheCateGroup', $value);
		return $res;
	}

}