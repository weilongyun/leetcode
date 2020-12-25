<?php
namespace WTable\protocal;

use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;

class HostInfo{
	public $host;
	public $weight;
	public $resv;

	public function length(){
		return 9 + strlen($host);
	}
	public function decode($pkg,$pkgLen){
		$n = 0;
		if ($n + 9 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->resv = Byte::unpackUint32($pkg,$n);
		$n += 4;
		$this->weight = Byte::unpackUint32($pkg,$n);
		$n += 4;
		
		$cHostLen = Byte::unpackUint8($pkg,$n);
		$n += 1;
		if ($n + $cHostLen > $pkgLen) {
		   throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->host = Byte::unpackChars($pkg, $n, $cHostLen);
		$n += $cHostLen;

		return $n;
	}
	public function encode(){
		$result=array();
	
		$n = 0;
		$data = Byte::packUint32($this->resv);
		$n += 4;
		$data .= Byte::packUint32($this->weight);
		$n += 4;
		$data .= Byte::packUint8(strlen($this->host));
		$n += 1;
		$data .= Byte::packChars($this->host);
		$n += strlen($this->host);
		
		$result['data'] = $data;
		$result['n'] = $n;
	
		return $result;
	}

}
