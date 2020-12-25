<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\TagRela;
use com\bj58\sfft\cmc\entity\Tag;

class ITagRelaService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetTagRela($tagRelaID = '') {
		ObjectSerializer::GetTypeInfo(new TagRela());
		$value = array(
			'1@int' => $tagRelaID,
		);
		$res = $this->ps->invoke('GetTagRela', $value);
		return $res;
	}

	public function GetTagAll() {
		ObjectSerializer::GetTypeInfo(new TagRela());
		$value = array(
		);
		$res = $this->ps->invoke('GetTagAll', $value);
		return $res;
	}

	public function GetTagRela_PHP_2($whereclause = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new TagRela());
		$value = array(
			'1@String' => $whereclause,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetTagRela_PHP_2', $value);
		return $res;
	}

	public function AddTagRela($entity = '') {
		$value = array(
			'1@Out<TagRela>' => $entity,
		);
		$res = $this->ps->invoke('AddTagRela', $value);
		return $res;
	}

	public function DeleteTagRelaByID($tagRelaID = '') {
		$value = array(
			'1@int' => $tagRelaID,
		);
		$res = $this->ps->invoke('DeleteTagRelaByID', $value);
		return $res;
	}

	public function DeleteTagRela($entity = '') {
		$value = array(
			'1@TagRela' => $entity,
		);
		$res = $this->ps->invoke('DeleteTagRela', $value);
		return $res;
	}

	public function DeleteTagRela_PHP_2($whereclause = '') {
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('DeleteTagRela_PHP_2', $value);
		return $res;
	}

	public function UpdateTagRela($entity = '') {
		$value = array(
			'1@TagRela' => $entity,
		);
		$res = $this->ps->invoke('UpdateTagRela', $value);
		return $res;
	}

	public function GetTagRelaByPage($currentpage = '', $pagesize = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new TagRela());
		$value = array(
			'1@int' => $currentpage,
			'2@int' => $pagesize,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('GetTagRelaByPage', $value);
		return $res;
	}

	public function Count($where = '') {
		$value = array(
			'1@String' => $where,
		);
		$res = $this->ps->invoke('Count', $value);
		return $res;
	}

	public function GetTag($displocalid = '', $dispcategoryid = '') {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
			'1@int' => $displocalid,
			'2@int' => $dispcategoryid,
		);
		$res = $this->ps->invoke('GetTag', $value);
		return $res;
	}

	public function GetTag_PHP_2($displocalid = '', $dispcategoryid = '', $ObjectTypeValue = '') {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
			'1@int' => $displocalid,
			'2@int' => $dispcategoryid,
			'3@String' => $ObjectTypeValue,
		);
		$res = $this->ps->invoke('GetTag_PHP_2', $value);
		return $res;
	}

	public function ReCacheTagRela() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheTagRela', $value);
		return $res;
	}

}