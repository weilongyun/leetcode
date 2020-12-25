<?php
namespace com\bj58\fang\zhuzhan\infodetail\contract;

use com\bj58\fang\zhuzhan\infodetail\entity\data\HouseInfoModel;
use com\bj58\sfft\imc\entity\Info;
use com\bj58\spat\scf\client\proxy\ProxyStandard;
use com\bj58\spat\scf\serialize\serializer\ObjectSerializer;

use com\bj58\fang\zhuzhan\common\entity\Params;
use com\bj58\fang\zhuzhan\common\extend\GetEnum;
use com\bj58\fang\zhuzhan\infodetail\entity\data\DetailResult;

class InfoTransferService {
	public $ps;
	public function __construct($serviceName = '', $lookup = '', $initObj = '') {
		$ps = new ProxyStandard($serviceName, $lookup, $initObj);
		$this->ps = $ps;
	}

	public function toHouseInfoModel($info = '', $Param = '', $getEnums = '') {
		ObjectSerializer::GetTypeInfo(new GetEnum());
		ObjectSerializer::GetTypeInfo(new Params());
		ObjectSerializer::GetTypeInfo(new Info());
		ObjectSerializer::GetTypeInfo(new HouseInfoModel());
		$value = array(
			'1@Info' => $info,
			'2@Params' => $Param,
			'3@GetEnum' => $getEnums,
		);
		$res = $this->ps->invoke('toHouseInfoModel', $value);
		return $res;
	}

	public function toDetailResult($info = '', $Param = '', $getEnums = '') {
		ObjectSerializer::GetTypeInfo(new GetEnum());
		ObjectSerializer::GetTypeInfo(new Params());
		ObjectSerializer::GetTypeInfo(new Info());
		ObjectSerializer::GetTypeInfo(new DetailResult());
		$value = array(
			'1@Info' => $info,
			'2@Params' => $Param,
			'3@GetEnum' => $getEnums,
		);
		$res = $this->ps->invoke('toDetailResult', $value);
		return $res;
	}

	public function toFangDetailResult($infoId = '', $Param = '', $getEnums = '') {
		ObjectSerializer::GetTypeInfo(new GetEnum());
		ObjectSerializer::GetTypeInfo(new Params());
		ObjectSerializer::GetTypeInfo(new DetailResult());
		ObjectSerializer::GetTypeInfo(new Info());
		$value = array(
			'1@long' => $infoId,
			'2@Params' => $Param,
			'3@GetEnum[]' => $getEnums,
		);
		$res = $this->ps->invoke('toFangDetailResult', $value);
		return $res;
	}

	public function toFangNewDetailResult($infoId = '', $extendParam = '', $dateTypes = array(0=>"1",1=>"2")) {

		ObjectSerializer::GetTypeInfo(new Params());
		ObjectSerializer::GetTypeInfo(new DetailResult());
		$value = array(
			'1@long' => $infoId,
			'2@Params' => $extendParam,
			'3@List<String>' => $dateTypes,
		);
		$res = $this->ps->invoke('toFangNewDetailResult', $value);
		return $res;
	}

	public function toNewDetailResult($infoId = '') {
		ObjectSerializer::GetTypeInfo(new Info());
		ObjectSerializer::GetTypeInfo(new DetailResult());
		$value = $value = array(
			'1@long' => $infoId,
		);
		$res = $this->ps->invoke('toNewDetailResult', $value);
		return $res;
	}

}