<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\LocalCateGroup;

class ILocalCateGroupService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function GetLocalCateGroup($where = '', $orderby = '') {
		ObjectSerializer::GetTypeInfo(new LocalCateGroup());
		$value = array(
			'1@String' => $where,
			'2@String' => $orderby,
		);
		$res = $this->ps->invoke('GetLocalCateGroup', $value);
		return $res;
	}

	public function ReCacheLocalCateGroup() {
		$value = array(
		);
		$res = $this->ps->invoke('ReCacheLocalCateGroup', $value);
		return $res;
	}

}