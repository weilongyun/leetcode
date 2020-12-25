<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Local2;
use com\bj58\sfft\cmc\entity\LocalRelation;
use com\bj58\sfft\cmc\entity\LocalCateGroup;

class ILocalRelationService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetLocalRelationByID($iD = '') {
		ObjectSerializer::GetTypeInfo(new LocalRelation());
		$value = array(
			'1@long' => $iD,
		);
		$res = $this->ps->invoke('GetLocalRelationByID', $value);
		return $res;
	}

	public function GetLocalRelation($LocalID = '') {
		ObjectSerializer::GetTypeInfo(new LocalRelation());
		$value = array(
			'1@int' => $LocalID,
		);
		$res = $this->ps->invoke('GetLocalRelation', $value);
		return $res;
	}

	public function GetLocalRelation_PHP_2($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new LocalRelation());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetLocalRelation_PHP_2', $value);
		return $res;
	}

	public function AddLocalRelation($entity = '') {
		$value = array(
			'1@Out<LocalRelation>' => $entity,
		);
		$res = $this->ps->invoke('AddLocalRelation', $value);
		return $res;
	}

	public function DeleteLocalRelationByID($iD = '') {
		$value = array(
			'1@long' => $iD,
		);
		$res = $this->ps->invoke('DeleteLocalRelationByID', $value);
		return $res;
	}

	public function DeleteLocalRelation($localID = '') {
		$value = array(
			'1@int' => $localID,
		);
		$res = $this->ps->invoke('DeleteLocalRelation', $value);
		return $res;
	}

	public function DeleteLocalRelation_PHP_2($entity = '') {
		$value = array(
			'1@LocalRelation' => $entity,
		);
		$res = $this->ps->invoke('DeleteLocalRelation_PHP_2', $value);
		return $res;
	}

	public function DeleteLocalRelation_PHP_3($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteLocalRelation_PHP_3', $value);
		return $res;
	}

	public function UpdateLocalRelation($entity = '') {
		$value = array(
			'1@LocalRelation' => $entity,
		);
		$res = $this->ps->invoke('UpdateLocalRelation', $value);
		return $res;
	}

	public function GetLocalRelationByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new LocalRelation());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetLocalRelationByPage', $value);
		return $res;
	}

	public function ReCacheLocalRelation() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheLocalRelation', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

}