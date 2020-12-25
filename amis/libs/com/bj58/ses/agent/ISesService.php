<?php
namespace com\bj58\ses\agent;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializerV2\ObjectSerializer;
use com\bj58\ses\contract\SearchResult;
use com\bj58\ses\contract\GroupSearchResult;
use com\bj58\ses\contract\CISearchResult;

class ISesService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getSearchResult($query = '') {
		ObjectSerializer::GetTypeInfo(new SearchResult());
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getSearchResult', $value);
		return $res;
	}

	public function getCISearchResult($query = '') {
		ObjectSerializer::GetTypeInfo(new CISearchResult());
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getCISearchResult', $value);
		return $res;
	}

	public function getSearchCount($query = '') {
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getSearchCount', $value);
		return $res;
	}

	public function getReverseSearch($query = '') {
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getReverseSearch', $value);
		return $res;
	}

	public function getGroupSearch($query = '') {
		ObjectSerializer::GetTypeInfo(new GroupSearchResult());
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getGroupSearch', $value);
		return $res;
	}

	public function getEsearchQuery($query = '') {
		$value = array(
			'1@String' => $query,
		);
		$res = $this->ps->invoke('getEsearchQuery', $value);
		return $res;
	}

}