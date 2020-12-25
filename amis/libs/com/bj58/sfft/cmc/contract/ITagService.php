<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Tag;

class ITagService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetTagByID($tagID = '') {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
			'1@int' => $tagID,
		);
		$res = $this->ps->invoke('GetTagByID', $value);
		return $res;
	}

	public function LoadAll() {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
		);
		$res = $this->ps->invoke('LoadAll', $value);
		return $res;
	}

	public function GetTag($whereclause = '') {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
			'1@String' => $whereclause,
		);
		$res = $this->ps->invoke('GetTag', $value);
		return $res;
	}

	public function AddTag($entity = '') {
		$value = array(
			'1@Out<Tag>' => $entity,
		);
		$res = $this->ps->invoke('AddTag', $value);
		return $res;
	}

	public function DeleteTag($tagID = '') {
		$value = array(
			'1@int' => $tagID,
		);
		$res = $this->ps->invoke('DeleteTag', $value);
		return $res;
	}

	public function DeleteTag_PHP_2($entity = '') {
		$value = array(
			'1@Tag' => $entity,
		);
		$res = $this->ps->invoke('DeleteTag_PHP_2', $value);
		return $res;
	}

	public function UpdateTag($entity = '') {
		$value = array(
			'1@Tag' => $entity,
		);
		$res = $this->ps->invoke('UpdateTag', $value);
		return $res;
	}

	public function UpdateTag_PHP_2($updatestatement = '', $where = '') {
		$value = array(
			'1@String' => $updatestatement,
			'2@String' => $where,
		);
		$res = $this->ps->invoke('UpdateTag_PHP_2', $value);
		return $res;
	}

	public function PageByRowNumber($pagesize = '', $currentpage = '', $where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new Tag());
		$value = array(
			'1@int' => $pagesize,
			'2@int' => $currentpage,
			'3@String' => $where,
			'4@String' => $orderby,
		);
		$res = $this->ps->invoke('PageByRowNumber', $value);
		return $res;
	}

	public function ReCacheTags() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheTags', $value);
		return $res;
	}

}