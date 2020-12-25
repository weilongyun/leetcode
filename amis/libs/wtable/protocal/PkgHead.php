<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;

class PkgHead{
	public $crc;
	public $cmd;
	public $cid;
	public $dbid;
	public $seq;
	public $pkgLen;

	public function length(){
		return Protocal::HeadSize;
	}

	public function __Construct($params){
	   $this->crc = isset($params['crc']) ? $params['crc']:0;
	   $this->cmd = isset($params['cmd']) ? $params['cmd']:0;
	   $this->cid = isset($params['cid']) ? $params['cid']:0;
	   $this->dbid = isset($params['dbid']) ? $params['dbid']:0;
	   $this->seq = isset($params['seq']) ? $params['seq']:0;
	   $this->pkgLen = isset($params['pkgLen']) ? $params['pkgLen']:0;
	}

	public function decode($bytes,$len){
		if($len < Protocal::HeadSize){
			throw new WTableException("Invalid head size ".$len, WTableError::EcInvPkgLen);
		}
		$this->crc = Byte::unpackUint8($bytes,0);
		if($this->crc !== self::calHeadCrc($bytes)){
			throw new WTableException("Crc error (".$this->crc.":".self::calHeadCrc($bytes).")", WTableError::EcInvHeadCrc);
		}
		$this->cmd = Byte::unpackUint8($bytes,1);
		$this->dbid = Byte::unpackUint8($bytes,2);
		$this->seq = Byte::unpackUint64($bytes,3);
		$this->cid = Byte::unpackUint16($bytes,11);
		$this->pkgLen = Byte::unpackUint32($bytes,16);
		return Protocal::HeadSize;
	}
	public function encode(){
		$result = array();
		$n = 0;
		$bytes = Byte::packUint8(0);
		$n += 1;
		$bytes .= Byte::packUint8($this->cmd);
		$n += 1;
		$bytes .= Byte::packUint8($this->dbid);
		$n += 1;
		$bytes .= Byte::packUint64($this->seq);
		$n += 8;
		$bytes .= Byte::packUint16($this->cid);
		$n += 2;
		for($i = 0; $i < 3; $i++) {
			$bytes .= Byte::packUint8(0);
		}
		$n += 3;
		$bytes .= Byte::packUint32($this->pkgLen);
		$n += 4;
		$bytes[0] = Byte::packUint8(self::calHeadCrc($bytes));
		$result['data'] = $bytes;
		$result['n'] = Protocal::HeadSize;
		return $result;

	}
	public static function rewrite($bytes,$value,$start,$len, $signed=false){
		$tmp = '';
		switch($len){
			case 1:
				$tmp = $signed ? Byte::packInt8($value) : Byte::packUint8($value);
				break;
			case 2:
				$tmp = $signed ? Byte::packInt16($value) : Byte::packUint16($value);
				break;
			case 4:
				$tmp = $signed ? Byte::packInt32($value) : Byte::packUint32($value);
				break;
			case 8:
				$tmp = $signed ? Byte::packInt64($value) : Byte::packUint64($value);
				break;
			default:
				break;
		}
		for($i = 0; $i < $len; $i++){
			$bytes[$start + $i] = $tmp[$i];
		}
		$bytes[0] = Byte::packUint8(self::calHeadCrc($bytes));
		return $bytes;
	}
	public static function overWriteLen($bytes,$len){
		return self::rewrite($bytes,$len,16,4);
	}
	public static function calHeadCrc($bytes){
		$re = 10;
		for($i = 1; $i < Protocal::HeadSize; $i++){
			$re += Byte::unpackInt8($bytes, $i);
		}
		while($re >= 256)
			$re -= 256;
		while($re < 0)
			$re += 256;
		return $re;
	}
}
