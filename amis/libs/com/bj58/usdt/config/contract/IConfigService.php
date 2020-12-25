<?php
namespace com\bj58\usdt\config\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\usdt\config\entity\ConfigEntity;

class IConfigService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function getConfig($displocalid = '', $dispcateid = '', $systemid = '', $typeid = '') {
		$value = array(
			'1@String' => $displocalid,
			'2@String' => $dispcateid,
			'3@int' => $systemid,
			'4@int' => $typeid,
		);
		$res = $this->ps->invoke('getConfig', $value);
		return $res;
	}

	public function getConfig_PHP_2($systemid = '', $key = '') {
		$value = array(
			'1@int' => $systemid,
			'2@String' => $key,
		);
		$res = $this->ps->invoke('getConfig_PHP_2', $value);
		return $res;
	}

	public function getConfig_PHP_3($displocalids = '', $dispcateids = '', $systemid = '', $typeid = '') {
		$value = array(
			'1@String[]' => $displocalids,
			'2@String[]' => $dispcateids,
			'3@int' => $systemid,
			'4@int' => $typeid,
		);
		$res = $this->ps->invoke('getConfig_PHP_3', $value);
		return $res;
	}

	public function insert($entity = '') {
		ObjectSerializer::GetTypeInfo(new ConfigEntity());
		$value = array(
			'1@ConfigEntity' => $entity,
		);
		$res = $this->ps->invoke('insert', $value);
		return $res;
	}

	public function getUpdateCacheWithTimeStamp($lastUpdateTime = '') {
		ObjectSerializer::GetTypeInfo(new ConfigEntity());
		$value = array(
			'1@long' => $lastUpdateTime,
		);
		$res = $this->ps->invoke('getUpdateCacheWithTimeStamp', $value);
		return $res;
	}

	public function postAccessCount($map = '', $version = '', $ip = '') {
		$value = array(
			'1@Map<key = String, value = Integer>' => $map,
			'2@String' => $version,
			'3@String' => $ip,
		);
		$res = $this->ps->invoke('postAccessCount', $value);
		return $res;
	}

}