<?php
namespace com\bj58\sfft\cmc\contract;

use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;
use com\bj58\sfft\cmc\entity\Templet;

class IExtendService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '') {
		$ps = new ProxyStandard($serviceName, $lookup);
		$this->ps = $ps;
	}

	public function Read($str = '') {
		$value = array(
			'1@String' => $str,
		);
		$res = $this->ps->invoke('Read', $value);
		return $res;
	}

	public function Write($str = '') {
		$value = array(
			'1@String' => $str,
		);
		$res = $this->ps->invoke('Write', $value);
		return $res;
	}

}