<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\DispLocal2;

class IDispLocalService2 {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetDispLocalByID($dispLocalID = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $dispLocalID,
		);
		$res = $this->ps->invoke('GetDispLocalByID', $value);
		return $res;
	}

	public function GetDispLocalAll() {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
		);
		$res = $this->ps->invoke('GetDispLocalAll', $value);
		return $res;
	}

	public function GetDispLocalAll_PHP_2($isvisible = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@boolean' => $isvisible,
		);
		$res = $this->ps->invoke('GetDispLocalAll_PHP_2', $value);
		return $res;
	}

	public function GetDispLocalByParentID($parentid = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $parentid,
		);
		$res = $this->ps->invoke('GetDispLocalByParentID', $value);
		return $res;
	}

	public function GetHomeDispLocalByParentId($parentid = '', $flag = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $parentid,
			'2@boolean' => $flag,
		);
		$res = $this->ps->invoke('GetHomeDispLocalByParentId', $value);
		return $res;
	}

	public function GetDispLocalByParentID_PHP_2($parentid = '', $dispcategoryID = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $parentid,
			'2@int' => $dispcategoryID,
		);
		$res = $this->ps->invoke('GetDispLocalByParentID_PHP_2', $value);
		return $res;
	}

	public function GetDispLocalLevel() {
		$value = array(
		);
		$res = $this->ps->invoke('GetDispLocalLevel', $value);
		return $res;
	}

	public function GetDispLocal($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetDispLocal', $value);
		return $res;
	}

	public function AddDispLocal($entity = '') {
		$value = array(
			'1@Out<DispLocal2>' => $entity,
		);
		$res = $this->ps->invoke('AddDispLocal', $value);
		return $res;
	}

	public function DeleteDispLocalByID($dispLocalID = '') {
		$value = array(
			'1@int' => $dispLocalID,
		);
		$res = $this->ps->invoke('DeleteDispLocalByID', $value);
		return $res;
	}

	public function DeleteDispLocal($entity = '') {
		$value = array(
			'1@DispLocal2' => $entity,
		);
		$res = $this->ps->invoke('DeleteDispLocal', $value);
		return $res;
	}

	public function DeleteDispLocal_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteDispLocal_PHP_2', $value);
		return $res;
	}

	public function UpdateDispLocal($entity = '') {
		$value = array(
			'1@DispLocal2' => $entity,
		);
		$res = $this->ps->invoke('UpdateDispLocal', $value);
		return $res;
	}

	public function GetDispLocalByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetDispLocalByPage', $value);
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

	public function GetDispLocalByConstraint($dispcategoryID = '', $oldList = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $dispcategoryID,
			'2@List<DispLocal2>' => $oldList,
		);
		$res = $this->ps->invoke('GetDispLocalByConstraint', $value);
		return $res;
	}

	public function GetDispLocalByLocalID($categroupid = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $categroupid,
		);
		$res = $this->ps->invoke('GetDispLocalByLocalID', $value);
		return $res;
	}

	public function ReCacheDispLocal2() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheDispLocal2', $value);
		return $res;
	}

	public function GetDispLocal_PHP_2($LocalID = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@int' => $LocalID,
		);
		$res = $this->ps->invoke('GetDispLocal_PHP_2', $value);
		return $res;
	}

	public function GetDispLocal_PHP_3($listname = '') {
		ObjectSerializer::GetTypeInfo(new DispLocal2());
		$value = array(
			'1@String' => $listname,
		);
		$res = $this->ps->invoke('GetDispLocal_PHP_3', $value);
		return $res;
	}

}