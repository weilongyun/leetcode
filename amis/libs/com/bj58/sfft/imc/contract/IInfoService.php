<?php
namespace com\bj58\sfft\imc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\imc\entity\Info;

class IInfoService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function add($info = '') {
		$value = array(
			'1@Info' => $info,
		);
		$res = $this->ps->invoke('add', $value);
		return $res;
	}

	public function delete($isTrueDelete = '', $infoIDs = '') {
		$value = array(
			'1@boolean' => $isTrueDelete,
			'2@Long[]' => $infoIDs,
		);
		$res = $this->ps->invoke('delete', $value);
		return $res;
	}

	public function update($info = '') {
		$value = array(
			'1@Info' => $info,
		);
		$res = $this->ps->invoke('update', $value);
		return $res;
	}

	public function updateBiz($isBiz = '', $infoIDs = '') {
		$value = array(
			'1@boolean' => $isBiz,
			'2@Long[]' => $infoIDs,
		);
		$res = $this->ps->invoke('updateBiz', $value);
		return $res;
	}

	public function rePost($infoID = '') {
		$value = array(
			'1@long' => $infoID,
		);
		$res = $this->ps->invoke('rePost', $value);
		return $res;
	}

	public function updateState($infoState = '', $infoIDs = '') {
		$value = array(
			'1@int' => $infoState,
			'2@Long[]' => $infoIDs,
		);
		$res = $this->ps->invoke('updateState', $value);
		return $res;
	}

	public function update_PHP_KV($kv = '', $infoIDs = '') {
		$value = array(
			'1@String' => $kv,
			'2@Long[]' => $infoIDs,
		);
		$res = $this->ps->invoke('update_PHP_2', $value);
		return $res;
	}
	
	public function GetInfo($infoID = '', $columns = '') {
	    ObjectSerializer::GetTypeInfo(new Info());
	    $value = array(
	        '1@long' => $infoID,
	        '2@String' => $columns,
	    );
	    $res = $this->ps->invoke('GetInfo', $value);
	    return $res;
	}
	public function GetInfo_PHP_2($arrInfoID = '', $columns = '') {
	    ObjectSerializer::GetTypeInfo(new Info());
	    $value = array(
	        '1@Long[]' => $arrInfoID,
	        '2@String' => $columns,
	        '3@String' => '',
	        '4@String' => '',
	    );
	    $res = $this->ps->invoke('GetInfo_PHP_2', $value);
	    return $res;
	}
}