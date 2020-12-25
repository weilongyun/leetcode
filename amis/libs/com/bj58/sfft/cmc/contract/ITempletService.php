<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Templet;

class ITempletService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetTempletByID($templeID = '') {
		ObjectSerializer::GetTypeInfo(new Templet());
		$value = array(
			'1@int' => $templeID,
		);
		$res = $this->ps->invoke('GetTempletByID', $value);
		return $res;
	}

	public function GetTempletAll() {
		ObjectSerializer::GetTypeInfo(new Templet());
		$value = array(
		);
		$res = $this->ps->invoke('GetTempletAll', $value);
		return $res;
	}

	public function GetTemplet($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Templet());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetTemplet', $value);
		return $res;
	}

	public function AddTemplet($entity = '') {
		$value = array(
			'1@Out<Templet>' => $entity,
		);
		$res = $this->ps->invoke('AddTemplet', $value);
		return $res;
	}

	public function DeleteTempletByID($templeID = '') {
		$value = array(
			'1@int' => $templeID,
		);
		$res = $this->ps->invoke('DeleteTempletByID', $value);
		return $res;
	}

	public function DeleteTemplet($entity = '') {
		$value = array(
			'1@Templet' => $entity,
		);
		$res = $this->ps->invoke('DeleteTemplet', $value);
		return $res;
	}

	public function DeleteTemplet_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteTemplet_PHP_2', $value);
		return $res;
	}

	public function UpdateTemplet($entity = '') {
		$value = array(
			'1@Templet' => $entity,
		);
		$res = $this->ps->invoke('UpdateTemplet', $value);
		return $res;
	}

	public function SetRelationDispCate($templetid = '', $dispcateids = '') {
		$value = array(
			'1@int' => $templetid,
			'2@Integer[]' => $dispcateids,
		);
		$res = $this->ps->invoke('SetRelationDispCate', $value);
		return $res;
	}

	public function GetTempletByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Templet());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetTempletByPage', $value);
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