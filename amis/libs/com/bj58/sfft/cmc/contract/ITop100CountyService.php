<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Top100County;

class ITop100CountyService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function getTop100CountyByLocalID($localID = '', $isNeedEntity = '') {
		ObjectSerializer::GetTypeInfo(new Top100County());
		$value = array(
			'1@int' => $localID,
			'2@boolean' => $isNeedEntity,
		);
		$res = $this->ps->invoke('getTop100CountyByLocalID', $value);
		return $res;
	}

	public function getTop100CountyByDispLocalID($dispLocalID = '', $isNeedEntity = '') {
		ObjectSerializer::GetTypeInfo(new Top100County());
		$value = array(
			'1@int' => $dispLocalID,
			'2@boolean' => $isNeedEntity,
		);
		$res = $this->ps->invoke('getTop100CountyByDispLocalID', $value);
		return $res;
	}

}