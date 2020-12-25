<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\UnitParameterRegex;
use com\bj58\sfft\cmc\entity\UnitParameter;
use com\bj58\sfft\cmc\entity\ParaControlValues;

class IUnitParameterService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetUnitParameterByID($parameterID = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter());
		$value = array(
			'1@int' => $parameterID,
		);
		$res = $this->ps->invoke('GetUnitParameterByID', $value);
		return $res;
	}

	public function GetUnitParameterAll() {
		ObjectSerializer::GetTypeInfo(new UnitParameter());
		$value = array(
		);
		$res = $this->ps->invoke('GetUnitParameterAll', $value);
		return $res;
	}

	public function GetUnitParameter($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetUnitParameter', $value);
		return $res;
	}

	public function AddUnitParameter($entity = '') {
		$value = array(
			'1@Out<UnitParameter>' => $entity,
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
			'1@UnitParameter' => $entity,
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
			'1@UnitParameter' => $entity,
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
		ObjectSerializer::GetTypeInfo(new UnitParameter());
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

	public function GetUnitParametersByDispCateID($dispcateid = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter());
		$value = array(
			'1@int' => $dispcateid,
		);
		$res = $this->ps->invoke('GetUnitParametersByDispCateID', $value);
		return $res;
	}

	public function GetParaControlValuesByParameterID2DispLocalID($parameterid = '', $displocalid = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues());
		$value = array(
			'1@int' => $parameterid,
			'2@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetParaControlValuesByParameterID2DispLocalID', $value);
		return $res;
	}

	public function GetParaControlValuesByParameterID2LocalID($parameterid = '', $localid = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues());
		$value = array(
			'1@int' => $parameterid,
			'2@int' => $localid,
		);
		$res = $this->ps->invoke('GetParaControlValuesByParameterID2LocalID', $value);
		return $res;
	}

	public function GetUnitParametersByCategoryID($categoryid = '') {
		ObjectSerializer::GetTypeInfo(new UnitParameter());
		ObjectSerializer::GetTypeInfo(new ParaControlValues());                
		$value = array(
			'1@int' => $categoryid,
		);
		$res = $this->ps->invoke('GetUnitParametersByCategoryID', $value);
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

	public function GetParaControlValuesByID($id = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('GetParaControlValuesByID', $value);
		return $res;
	}

	public function AddParaControlValues($entity = '') {
		$value = array(
			'1@Out<ParaControlValues>' => $entity,
		);
		$res = $this->ps->invoke('AddParaControlValues', $value);
		return $res;
	}

	public function UpdateParaControlValues($entity = '') {
		$value = array(
			'1@ParaControlValues' => $entity,
		);
		$res = $this->ps->invoke('UpdateParaControlValues', $value);
		return $res;
	}

	public function DeleteParaControlValuesByID($id = '') {
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('DeleteParaControlValuesByID', $value);
		return $res;
	}

	public function GetParaControlValues($where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues());
		$value = array(
			'1@String' => $where,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetParaControlValues', $value);
		return $res;
	}

	public function ReCacheUnitParameter() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheUnitParameter', $value);
		return $res;
	}

	public function GetUnitParameterAll_PHP_2($columns = '') {
		$value = array(
			'1@String' => $columns,
		);
		$res = $this->ps->invoke('GetUnitParameterAll_PHP_2', $value);
		return $res;
	}

}