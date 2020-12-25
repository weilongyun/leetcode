<?php
//namespace WTable;
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;

class PkgDumpReq {
	public $pkgOneOp;
	protected $startUnitId;
	protected $endUnitId;
	public function __construct($startUnitId,$endUnitId){
		$this->pkgOneOp = new PkgOneOp();
		$this->startUnitId=$startUnitId;
		$this->endUnitId=$endUnitId;
	}
	public function length()
	{
		return $this->pkgOneOp->length() + 4 + 512;
	}
	
	public function encode(){
		$result = array();
		$oneOpRe = $this->pkgOneOp->encode();
		$n = $oneOpRe['n'];
		$data = $oneOpRe['data'];

		$data .= Byte::packUint16($this->startUnitId);
		$n += 2;
		$data .= Byte::packUint16($this->endUnitId);
		$n += 2;

		//sResv[512]
		for($i = 0; $i < 512; $i += 1) {
			$data .= Byte::packUint8(0);
		}
		$n += 512;
		$data = PkgHead::overWriteLen($data, $n);
		
		$result['n'] = $n;
		$result['data'] = $data;
		return $result;
	}
}

