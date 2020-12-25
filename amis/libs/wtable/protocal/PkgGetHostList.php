<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;

class PkgGetHostList {
	public $pkgHead;
	public $errCode;
	public $push;
	public $cid;
	public $md5;
	public $hosts;

	public function __Construct($bid,$push){
		$this->errCode = 0;
		$this->md5 = 0;
		$dbId = $bid&0xff;
		$this->cid = $bid>>16;
		$seq = 0;
		$this->pkgHead = new PkgHead(array('dbid'=>$dbId,'cmd'=>Protocal::CmdGetPrx,'cid'=>$this->cid,'seq'=>$seq,'pkgLen'=>$this->length()));
		$this->push = $push;
	}
	public function length(){
		// PKG=Head+cErrCode+cPush+wCid+wHostNum+HostInfo[wHostNum]+MD5[16]
		$n = Protocal::HeadSize + 6 + 16;
		for ($i = 0; $i < count($this->hosts); $i++) {
			$n += $this->hosts[$i]->length();
		}
		return $n;
	}
	public function decode($pkg,$pkgLen)
	{
		$n = $this->pkgHead->decode($pkg, $pkgLen);
	
		if ($n + 6 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->errCode = Byte::unpackInt8($pkg, $n);
		$n += 1;
		$this->push = Byte::unpackUint8($pkg, $n);
		$n += 1;
		$this->cid = Byte::unpackUint16($pkg, $n);
		$n += 2;
		$num = Byte::unpackUint16($pkg, $n);
		$n += 2;
		$host = array();
		$hostSize = $num;
		for ($i = 0; $i < $num; $i++) {
			$info = new HostInfo();
			$m = $info->decode(substr($pkg, $n), $pkgLen - $n);
			$this->hosts[] = $info;
			$n += $m;
		}
	
		$this->md5 = Byte::unpackChars($pkg, $n ,16);     
		$n += 16;
   
		return $n;
	}
	public function encode(){
		$headRe = $this->pkgHead->encode();
		$n = $headRe['n'];
		$data = $headRe['data'];
		$result=array();
		
		$data .= Byte::packInt8($this->errCode);
		$n += 1;
		$data .= Byte::packUint8($this->push);
		$n += 1;
		$data .= Byte::packUint16($this->cid);
		$n += 2;
		$data .= Byte::packUint16(0);
		$n += 2;
		for ($i = 0; $i < 16; $i++) {
			$data .= Byte::packUint8(0);
		}
		$n += 16;

		$data = PkgHead::overWriteLen($data, $n);
		
		$result['data'] = $data;
		$result['n'] = $n;

		return $result;
	
	}
}
