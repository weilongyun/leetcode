<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Local2;
use com\bj58\sfft\cmc\entity\LocalCateGroup;

class ILocalService2 {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetLocalByID($localID = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@int' => $localID,
		);
		$res = $this->ps->invoke('GetLocalByID', $value);
		return $res;
	}

	public function GetLocalAll() {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
		);
		$res = $this->ps->invoke('GetLocalAll', $value);
		return $res;
	}

	public function GetLocalByParentID($parentid = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@int' => $parentid,
		);
		$res = $this->ps->invoke('GetLocalByParentID', $value);
		return $res;
	}

	public function GetLocal($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetLocal', $value);
		return $res;
	}

	public function AddLocal($entity = '') {
		$value = array(
			'1@Out<Local2>' => $entity,
		);
		$res = $this->ps->invoke('AddLocal', $value);
		return $res;
	}

	public function DeleteLocalByID($localID = '') {
		$value = array(
			'1@int' => $localID,
		);
		$res = $this->ps->invoke('DeleteLocalByID', $value);
		return $res;
	}

	public function DeleteLocal($entity = '') {
		$value = array(
			'1@Local2' => $entity,
		);
		$res = $this->ps->invoke('DeleteLocal', $value);
		return $res;
	}

	public function DeleteLocal_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteLocal_PHP_2', $value);
		return $res;
	}

	public function UpdateLocal($entity = '') {
		$value = array(
			'1@Local2' => $entity,
		);
		$res = $this->ps->invoke('UpdateLocal', $value);
		return $res;
	}

	public function SetCateGroupByID($localid = '', $categroupid = '') {
		$value = array(
			'1@int' => $localid,
			'2@int' => $categroupid,
		);
		$res = $this->ps->invoke('SetCateGroupByID', $value);
		return $res;
	}

	public function GetLocalyByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetLocalyByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetFullPath() {
		$value = array(
		);
		$res = $this->ps->invoke('GetFullPath', $value);
		return $res;
	}

	public function DeleteLocalCateGroupByID($localid = '') {
		$value = array(
			'1@int' => $localid,
		);
		$res = $this->ps->invoke('DeleteLocalCateGroupByID', $value);
		return $res;
	}

	public function GetLocalCateGroupByLocalID($localid = '') {
		ObjectSerializer::GetTypeInfo(new LocalCateGroup());
		$value = array(
			'1@int' => $localid,
		);
		$res = $this->ps->invoke('GetLocalCateGroupByLocalID', $value);
		return $res;
	}

	public function GetListParentPathByID($localid = '') {
		$value = array(
			'1@int' => $localid,
		);
		$res = $this->ps->invoke('GetListParentPathByID', $value);
		return $res;
	}

	public function GetLocalNameListParentPathByID($localid = '') {
		$value = array(
			'1@int' => $localid,
		);
		$res = $this->ps->invoke('GetLocalNameListParentPathByID', $value);
		return $res;
	}

	public function GetLocalByDispLocalID($displocalid = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetLocalByDispLocalID', $value);
		return $res;
	}

	public function ReCacheLocal2() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheLocal2', $value);
		return $res;
	}

	public function GetPageRowNumberByByDispGroupID($pagesize = '', $currentpage = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@int' => $pagesize,
			'2@int' => $currentpage,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetPageRowNumberByByDispGroupID', $value);
		return $res;
	}

	public function GetLocalByDirName($dirname = '') {
		ObjectSerializer::GetTypeInfo(new Local2());
		$value = array(
			'1@String' => $dirname,
		);
		$res = $this->ps->invoke('GetLocalByDirName', $value);
		return $res;
	}

}