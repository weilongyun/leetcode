<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\ParaControlValues2;

class IParaControlValuesService2 {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function AddParaControlValues($entity = '') {
		$value = array(
			'1@Out<ParaControlValues2>' => $entity,
		);
		$res = $this->ps->invoke('AddParaControlValues', $value);
		return $res;
	}

	public function DeleteParaControlValuesByID($id = '') {
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('DeleteParaControlValuesByID', $value);
		return $res;
	}

	public function UpdateParaControlValues($entity = '') {
		$value = array(
			'1@ParaControlValues2' => $entity,
		);
		$res = $this->ps->invoke('UpdateParaControlValues', $value);
		return $res;
	}

	public function GetParaControlValuesByID($id = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues2());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('GetParaControlValuesByID', $value);
		return $res;
	}

	public function GetParaControlValues($where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues2());
		$value = array(
			'1@String' => $where,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetParaControlValues', $value);
		return $res;
	}

	public function GetParaControlValuesByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues2());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetParaControlValuesByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetParaControlValuesParameterIDPIDLocalID($parameterid = '', $pid = '', $localid = '', $state = '') {
		ObjectSerializer::GetTypeInfo(new ParaControlValues2());
		$value = array(
			'1@int' => $parameterid,
			'2@int' => $pid,
			'3@int' => $localid,
			'4@byte' => $state,
		);
		$res = $this->ps->invoke('GetParaControlValuesParameterIDPIDLocalID', $value);
		return $res;
	}

	public function ReCacheParaControlValues2() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheParaControlValues2', $value);
		return $res;
	}

}