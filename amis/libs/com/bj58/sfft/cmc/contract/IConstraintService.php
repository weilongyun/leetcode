<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

class IConstraintService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetConstraintByID($operationID = '') {
		ObjectSerializer::GetTypeInfo(new Constraint());
		$value = array(
			'1@int' => $operationID,
		);
		$res = $this->ps->invoke('GetConstraintByID', $value);
		return $res;
	}

	public function GetConstraintAll() {
		ObjectSerializer::GetTypeInfo(new Constraint());
		$value = array(
		);
		$res = $this->ps->invoke('GetConstraintAll', $value);
		return $res;
	}

	public function GetConstraint($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Constraint());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetConstraint', $value);
		return $res;
	}

	public function AddConstraint($entity = '') {
		$value = array(
			'1@Out<Constraint>' => $entity,
		);
		$res = $this->ps->invoke('AddConstraint', $value);
		return $res;
	}

	public function DeleteConstraintByID($operationID = '') {
		$value = array(
			'1@int' => $operationID,
		);
		$res = $this->ps->invoke('DeleteConstraintByID', $value);
		return $res;
	}

	public function DeleteConstraint($entity = '') {
		$value = array(
			'1@Constraint' => $entity,
		);
		$res = $this->ps->invoke('DeleteConstraint', $value);
		return $res;
	}

	public function DeleteConstraint_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteConstraint_PHP_2', $value);
		return $res;
	}

	public function UpdateConstraint($entity = '') {
		$value = array(
			'1@Constraint' => $entity,
		);
		$res = $this->ps->invoke('UpdateConstraint', $value);
		return $res;
	}

	public function GetConstraintByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Constraint());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetConstraintByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function ReCacheConstraint() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheConstraint', $value);
		return $res;
	}

}