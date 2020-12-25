<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\DispCategoryExt;
use com\bj58\sfft\cmc\entity\DispCategory;

class IDispCategoryService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetDispCategoryByID($dispCategoryID = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $dispCategoryID,
		);
		$res = $this->ps->invoke('GetDispCategoryByID', $value);
		return $res;
	}

	public function GetDispCategoryAll() {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
		);
		$res = $this->ps->invoke('GetDispCategoryAll', $value);
		return $res;
	}

	public function GetDispCategoryAll_PHP_2($isvisible = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@boolean' => $isvisible,
		);
		$res = $this->ps->invoke('GetDispCategoryAll_PHP_2', $value);
		return $res;
	}

	public function GetDispCategoryByParentID($parentid = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $parentid,
		);
		$res = $this->ps->invoke('GetDispCategoryByParentID', $value);
		return $res;
	}

	public function GetDispCategoryByParentID_PHP_2($parentid = '', $displocalid = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $parentid,
			'2@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetDispCategoryByParentID_PHP_2', $value);
		return $res;
	}

	public function GetDispCategory($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetDispCategory', $value);
		return $res;
	}

	public function AddDispCategory($entity = '') {
		$value = array(
			'1@Out<DispCategory>' => $entity,
		);
		$res = $this->ps->invoke('AddDispCategory', $value);
		return $res;
	}

	public function DeleteDispCategoryByID($dispCategoryID = '') {
		$value = array(
			'1@int' => $dispCategoryID,
		);
		$res = $this->ps->invoke('DeleteDispCategoryByID', $value);
		return $res;
	}

	public function DeleteDispCategory($entity = '') {
		$value = array(
			'1@DispCategory' => $entity,
		);
		$res = $this->ps->invoke('DeleteDispCategory', $value);
		return $res;
	}

	public function DeleteDispCategory_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteDispCategory_PHP_2', $value);
		return $res;
	}

	public function DeleteDispCategoryDiz($DispCategoryID = '') {
		$value = array(
			'1@int' => $DispCategoryID,
		);
		$res = $this->ps->invoke('DeleteDispCategoryDiz', $value);
		return $res;
	}

	public function UpdateDispCategory($entity = '') {
		$value = array(
			'1@DispCategory' => $entity,
		);
		$res = $this->ps->invoke('UpdateDispCategory', $value);
		return $res;
	}

	public function UpdateDispCategory_PHP_2($entitys = '') {
		$value = array(
			'1@List<DispCategory>' => $entitys,
		);
		$res = $this->ps->invoke('UpdateDispCategory_PHP_2', $value);
		return $res;
	}

	public function GetDispCategoryByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetDispCategoryByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetRootDispCategoryByDisplocalID($displocalid = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetRootDispCategoryByDisplocalID', $value);
		return $res;
	}

	public function GetDispCategoryByConstraint($displocalid = '', $oldList = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $displocalid,
			'2@List<DispCategory>' => $oldList,
		);
		$res = $this->ps->invoke('GetDispCategoryByConstraint', $value);
		return $res;
	}

	public function GetCategoryNameFullPathByListName($listname = '') {
		$value = array(
			'1@String' => $listname,
		);
		$res = $this->ps->invoke('GetCategoryNameFullPathByListName', $value);
		return $res;
	}

	public function GetDispCategory_PHP_2($localid = '', $listname = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $localid,
			'2@String' => $listname,
		);
		$res = $this->ps->invoke('GetDispCategory_PHP_2', $value);
		return $res;
	}

	public function GetTagByDispCategoryID($DispCategoryID = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $DispCategoryID,
		);
		$res = $this->ps->invoke('GetTagByDispCategoryID', $value);
		return $res;
	}

	public function GetTagByDispCategoryID_PHP_2($DispCategoryID = '', $displocalid = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@int' => $DispCategoryID,
			'2@int' => $displocalid,
		);
		$res = $this->ps->invoke('GetTagByDispCategoryID_PHP_2', $value);
		return $res;
	}

	public function ReCacheDispCategory() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheDispCategory', $value);
		return $res;
	}

	public function GetListNameBydisplocalid2dispcateid3tagid($displocalid = '', $dispcateid = '', $tagid = '') {
		$value = array(
			'1@int' => $displocalid,
			'2@int' => $dispcateid,
			'3@int' => $tagid,
		);
		$res = $this->ps->invoke('GetListNameBydisplocalid2dispcateid3tagid', $value);
		return $res;
	}

	public function GetDispCategory_PHP_3($listname = '', $cateid = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@String' => $listname,
			'2@int' => $cateid,
		);
		$res = $this->ps->invoke('GetDispCategory_PHP_3', $value);
		return $res;
	}

	public function GetDispCategory_PHP_4($listname = '') {
		ObjectSerializer::GetTypeInfo(new DispCategory());
		$value = array(
			'1@String' => $listname,
		);
		$res = $this->ps->invoke('GetDispCategory_PHP_4', $value);
		return $res;
	}

	public function GetCategoryIDByID($dispcategoryID = '') {
		$value = array(
			'1@int' => $dispcategoryID,
		);
		$res = $this->ps->invoke('GetCategoryIDByID', $value);
		return $res;
	}

	public function GetDefaultDispCateByID($categoryID = '') {
		ObjectSerializer::GetTypeInfo(new DispCategoryExt());
		$value = array(
			'1@int' => $categoryID,
		);
		$res = $this->ps->invoke('GetDefaultDispCateByID', $value);
		return $res;
	}

	public function GetSpecDispCategoryByParentID($parentid = '', $businessType = '') {
		ObjectSerializer::GetTypeInfo(new DispCategoryExt());
		$value = array(
			'1@int' => $parentid,
			'2@int' => $businessType,
		);
		$res = $this->ps->invoke('GetSpecDispCategoryByParentID', $value);
		return $res;
	}

	public function GetNewDispCategoryByID($dispCategoryID = '') {
		ObjectSerializer::GetTypeInfo(new DispCategoryExt());
		$value = array(
			'1@int' => $dispCategoryID,
		);
		$res = $this->ps->invoke('GetNewDispCategoryByID', $value);
		return $res;
	}

	public function GetNewDispCategory($listname = '') {
		ObjectSerializer::GetTypeInfo(new DispCategoryExt());
		$value = array(
			'1@String' => $listname,
		);
		$res = $this->ps->invoke('GetNewDispCategory', $value);
		return $res;
	}

	public function GetCategoryIDByIDandFilter($categoryID = '', $filter = '') {
		$value = array(
			'1@int' => $categoryID,
			'2@String' => $filter,
		);
		$res = $this->ps->invoke('GetCategoryIDByIDandFilter', $value);
		return $res;
	}

}