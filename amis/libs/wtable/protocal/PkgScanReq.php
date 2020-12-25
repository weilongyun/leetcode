<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;

class PkgScanReq {
	public $pkgOneOp;
	public $num;

	public function __Construct(){
		$this->pkgOneOp = new PkgOneOp();
		$this->num = 0;
	}
	public function length(){
		return $this->pkgOneOp->length()+2;
	}
	public function decode($pkg,$pkgLen){
		$n = $this->pkgOneOp->decode($pkg,$pkgLen);
	
		if($n + 2 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->num = Byte::unpackUint16($pkg, $n);
		$n += 2;

		return $n;
	}
	public function encode(){
   		$result = array();
   		
		$oneRe = $this->pkgOneOp->encode();
		$n = $oneRe['n'];
		$data = $oneRe['data'];
	
		if($this->num > 30000 || $this->num < 1) {
			WTableError::getException(WTableError::EcInvScanNum);
		}
		$data .= Byte::packUint16($this->num);
		$n += 2;
		$data = PkgHead::overWriteLen($data, $n);
		
		$result['data'] = $data;
		$result['n'] = $n;
		return $result;
	}
}
