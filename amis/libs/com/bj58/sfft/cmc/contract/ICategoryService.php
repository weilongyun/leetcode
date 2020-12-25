<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Category;

class ICategoryService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetCategoryByID($id = '') {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('GetCategoryByID', $value);
		return $res;
	}

	public function GetCategoryAll() {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
		);
		$res = $this->ps->invoke('GetCategoryAll', $value);
		return $res;
	}

	public function GetCategoryByParentID($parentid = '') {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
			'1@int' => $parentid,
		);
		$res = $this->ps->invoke('GetCategoryByParentID', $value);
		return $res;
	}

	public function GetCategory($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetCategory', $value);
		return $res;
	}

	public function AddCategory($entity = '') {
		$value = array(
			'1@Out<Category>' => $entity,
		);
		$res = $this->ps->invoke('AddCategory', $value);
		return $res;
	}

	public function DeleteCategoryByID($id = '') {
		$value = array(
			'1@int' => $id,
		);
		$res = $this->ps->invoke('DeleteCategoryByID', $value);
		return $res;
	}

	public function DeleteCategory($entity = '') {
		$value = array(
			'1@Category' => $entity,
		);
		$res = $this->ps->invoke('DeleteCategory', $value);
		return $res;
	}

	public function DeleteCategory_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteCategory_PHP_2', $value);
		return $res;
	}

	public function UpdateCategory($entity = '') {
		$value = array(
			'1@Category' => $entity,
		);
		$res = $this->ps->invoke('UpdateCategory', $value);
		return $res;
	}

	public function UpdateCategory_PHP_2($entitys = '') {
		$value = array(
			'1@List<Category>' => $entitys,
		);
		$res = $this->ps->invoke('UpdateCategory_PHP_2', $value);
		return $res;
	}

	public function GetCategoryByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetCategoryByPage', $value);
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

	public function GetTopCategoryID() {
		$value = array(
		);
		$res = $this->ps->invoke('GetTopCategoryID', $value);
		return $res;
	}

	public function GetParentCateIDByCateID($cateid = '') {
		$value = array(
			'1@int' => $cateid,
		);
		$res = $this->ps->invoke('GetParentCateIDByCateID', $value);
		return $res;
	}

	public function GetRootNameByCateID($cateid = '') {
		$value = array(
			'1@int' => $cateid,
		);
		$res = $this->ps->invoke('GetRootNameByCateID', $value);
		return $res;
	}

	public function ReCacheCategory() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheCategory', $value);
		return $res;
	}

	public function GetSpecCategoryByParentID($parentid = '', $bussinessType = '') {
		ObjectSerializer::GetTypeInfo(new Category());
		$value = array(
			'1@int' => $parentid,
			'2@int' => $bussinessType,
		);
		$res = $this->ps->invoke('GetSpecCategoryByParentID', $value);
		return $res;
	}

	public function GetAllNewOldCatIdMap() {
		$value = array(
		);
		$res = $this->ps->invoke('GetAllNewOldCatIdMap', $value);
		return $res;
	}

}