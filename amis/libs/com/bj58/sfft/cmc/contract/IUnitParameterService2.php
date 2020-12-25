<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\UnitParameterRegex;
use com\bj58\sfft\cmc\entity\UnitParameter2;

class IUnitParameterService2 {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetUnitParameterByID($parameterID = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@int' => $parameterID,
		);
		$res = $this->ps->invoke('GetUnitParameterByID', $value);
		return $res;
	}

	public function GetUnitParameterAll() {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
		);
		$res = $this->ps->invoke('GetUnitParameterAll', $value);
		return $res;
	}

	public function GetUnitParameter($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetUnitParameter', $value);
		return $res;
	}

	public function AddUnitParameter($entity = '') {
		$value = array(
			'1@Out<UnitParameter2>' => $entity,
		);
		$res = $this->ps->invoke('AddUnitParameter', $value);
		return $res;
	}

	public function DeleteUnitParameterByID($parameterID = '') {
		$value = array(
			'1@int' => $parameterID,
		);
		$res = $this->ps->invoke('DeleteUnitParameterByID', $value);
		return $res;
	}

	public function DeleteUnitParameter($entity = '') {
		$value = array(
			'1@UnitParameter2' => $entity,
		);
		$res = $this->ps->invoke('DeleteUnitParameter', $value);
		return $res;
	}

	public function DeleteUnitParameter_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteUnitParameter_PHP_2', $value);
		return $res;
	}

	public function UpdateUnitParameter($entity = '') {
		$value = array(
			'1@UnitParameter2' => $entity,
		);
		$res = $this->ps->invoke('UpdateUnitParameter', $value);
		return $res;
	}

	public function DeleteUnitParameterReg($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('DeleteUnitParameterReg', $value);
		return $res;
	}

	public function GetUnitParameterByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetUnitParameterByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetUnitParametersByDispCateID($dispcateid = '', $state = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@int' => $dispcateid,
			'2@byte' => $state,
		);
		$res = $this->ps->invoke('GetUnitParametersByDispCateID', $value);
		return $res;
	}

	public function GetUnitParametersByCategoryID($categoryid = '', $state = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@int' => $categoryid,
			'2@byte' => $state,
		);
		$res = $this->ps->invoke('GetUnitParametersByCategoryID', $value);
		return $res;
	}

	public function GetUnitParametersByCateIDPID($cateid = '', $pid = '', $state = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter2());
		$value = array(
			'1@int' => $cateid,
			'2@int' => $pid,
			'3@byte' => $state,
		);
		$res = $this->ps->invoke('GetUnitParametersByCateIDPID', $value);
		return $res;
	}

	public function GetUnitParameterByIsCreateIndex() {
		$value = array(
		);
		$res = $this->ps->invoke('GetUnitParameterByIsCreateIndex', $value);
		return $res;
	}

	public function GetTypeCodeByParemeterID($id = '') {
		ObjectSerializer::GetTypeInfo(new com.bj58.sfft.cmc.enumeration.TypeCode());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('GetTypeCodeByParemeterID', $value);
		return $res;
	}

	public function GetUnitParameterRegexByParameterID($id = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameterRegex());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('GetUnitParameterRegexByParameterID', $value);
		return $res;
	}

	public function AddUnitParameterRegex($entity = '') {
		$value = array(
			'1@UnitParameterRegex' => $entity,
		);
		$res = $this->ps->invoke('AddUnitParameterRegex', $value);
		return $res;
	}

	public function UpdateUnitParameterRegex($entity = '') {
		$value = array(
			'1@UnitParameterRegex' => $entity,
		);
		$res = $this->ps->invoke('UpdateUnitParameterRegex', $value);
		return $res;
	}

	public function ReCacheUnitParameter2() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheUnitParameter2', $value);
		return $res;
	}

}