<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\client\CasArgs;

class KeyValue{
	const CtrlErrCode  = 0x1;  // Response Error Code
	const CtrlCas      = 0x2;  // Compare And Switch
	const CtrlColSpace = 0x4;
	const CtrlValue    = 0x8;
	const CtrlScore    = 0x10;
	const CtrlTTL	   = 0x20;
	const ColSpaceDefault = 0;  // Default column space
	const ColSpaceScore1  = 1;  // rowKey+score+colKey => value
	const ColSpaceScore2  = 2;  // rowKey+colKey => value+score
	// (Z)Scan flags
	const FlagZop = 0x1; // if set, it is a "Z" op
	const FlagTTL = 0x2; // for version compatibility, if set, all read-op(get,mGet,scan,dump) will return ttl while having ttl; 
	const FlagScanAsc      = 0x4;  // if set, Scan in ASC order, else DESC order
	const FlagScanKeyStart = 0x8;  // if set, Scan start from MIN/MAX key
	const FlagScanEnd      = 0x10; // if set, Scan finished, stop now

	// Dump flags
	const FlagDumpTable     = 0x4;  // if set, Dump only one table, else Dump current DB(dbId)
	const FlagDumpUnitStart = 0x8;  // if set, Dump start from new UnitId, else from pivot record
	const FlagDumpEnd       = 0x10; // if set, Dump finished, stop now
	
	public  $ctrlFlag;
	public  $errCode;   // default: 0 if missing
	public  $colSpace;  // default: 0 if missing
	public  $tableId;
	public  $rowKey;
	public  $colKey;
	public  $value;     // default: empty if missing
	public  $score;     // default: 0 if missing
	public  $cas;       // default: 0 if missing
	public	$ttl;
	
	public function __Construct($args){
		$this->ctrlFlag = isset($args['ctrlFlag']) ? $args['ctrlFlag'] : 0;
		$this->errCode = isset($args['errCode']) ? $args['errCode'] : 0;
		$this->colSpace = isset($args['colSpace']) ? $args['colSpace'] : KeyValue::ColSpaceDefault;
		$this->tableId = isset($args['tableId']) ? $args['tableId'] : 0;
		$this->rowKey = isset($args['rowKey']) ? $args['rowKey'] : "";
		$this->colKey = isset($args['colKey']) ? $args['colKey'] : "";
		$this->value = isset($args['value']) ? $args['value'] : "";
		$this->score = isset($args['score']) ? $args['score'] : 0;
		$this->cas = isset($args['cas']) ? $args['cas'] : CasArgs::CAS_DEFAULT;
		$this->ttl = isset($args['ttl']) ? $args['ttl'] : 0;
	}
	public function length(){
		// KeyValue=cCtrlFlag+cTableId+[cErrCode]+[cColSpace]
		//         +cRowKeyLen+sRowKey+wColKeyLen+sColKey
		//         +[dwValueLen+sValue]+[ddwScore]+[dwCas]+[dwTTL]
		$n = 2;
		if(($this->ctrlFlag&self::CtrlErrCode) !== 0) {
			$n += 1;
		}
		if(($this->ctrlFlag&self::CtrlColSpace) !== 0) {
			$n += 1;
		}
		$n += 1 + strlen($this->rowKey) + 2 + strlen($this->colKey);
		if(($this->ctrlFlag&self::CtrlValue) !== 0) {
			$n += 4 + strlen($this->value);
		}
		if(($this->ctrlFlag&self::CtrlScore) !== 0) {
			$n += 8;
		}
		if(($this->ctrlFlag&self::CtrlCas) !== 0) {
			$n += 4;
		}
		if(($this->ctrlFlag&self::CtrlTTL) !== 0) {
			$n += 4;
		}
		return $n;
	}
	public function decode($pkg, $pkgLen){
		$n=0;
		if($n + 2 > $pkgLen)
		{
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->ctrlFlag = Byte::unpackUint8($pkg,$n);
		$n += 1;
		$this->tableId = Byte::unpackUint8($pkg,$n);
		$n += 1;
		//errCode
		if(($this->ctrlFlag&self::CtrlErrCode) !== 0) {
			if($n + 1 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->errCode = Byte::unpackInt8($pkg,$n);
			$n += 1;
		} else {
			$this->errCode = 0;
		}
		//colSpace
		if(($this->ctrlFlag&self::CtrlColSpace) !== 0) {
			if($n + 1 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->colSpace = Byte::unpackUint8($pkg,$n);
			$n += 1;
		} else {
			$this->colSpace = 0;
		}
		//rowkeyLen
		if($n + 1 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$rowKeyLen = Byte::unpackUint8($pkg,$n);
		$n += 1;
		//rowKey
		if($n + $rowKeyLen + 2 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->rowKey = Byte::unpackChars($pkg, $n, $rowKeyLen);
		$n += $rowKeyLen;
		//colKeyLen
		$colKeyLen = Byte::unpackUint16($pkg, $n);
		$n += 2;
		//colKey
		if($n + $colKeyLen > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->colKey = Byte::unpackChars($pkg, $n, $colKeyLen);
		$n += $colKeyLen;
		//value
		if(($this->ctrlFlag&self::CtrlValue) !== 0) {
			if($n + 4 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$valueLen = Byte::unpackUint32($pkg, $n);
			$n += 4;
			if($n + $valueLen > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->value = Byte::unpackChars($pkg, $n, $valueLen);
			$n += $valueLen;
		} else {
			$this->value='';
		}
		//score
		if(($this->ctrlFlag&self::CtrlScore) !== 0) {
			if($n + 8 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->score = Byte::unpackInt64($pkg, $n);
			$n += 8;
		} else {
			$this->score = 0;
		}
		//cas
		if(($this->ctrlFlag&self::CtrlCas) !== 0) {
			if($n + 4 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->cas = Byte::unpackUint32($pkg, $n);
			$n += 4;
		} else {
			$this->cas = 0;
		}
		//ttl 
		if(($this->ctrlFlag&self::CtrlTTL) !== 0) {
			if($n + 4 > $pkgLen) {
				throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
			}
			$this->ttl = Byte::unpackUint32($pkg, $n);
			$n += 4;
		} else {
			$this->ttl = 0;
		}
		return $n;
	}
	public function encode(){
		$result = array();
		if(strlen($this->rowKey) > Protocal::MaxUint8) {
			WTableError::getException(WTableError::EcInvRowKey);
		}
		if(strlen($this->colKey) > Protocal::MaxUint16) {
			WTableError::getException(WTableError::EcInvColKey);
		}
		if($this->tableId > 100) {
			WTableError::getException(WTableError::EcInvTableId);
		}
	
		$n = 0;
		//ctrlFlag
		$data = Byte::packUint8($this->ctrlFlag);
		$n += 1;
		//tableId
		$data .= Byte::packUint8($this->tableId);
		$n += 1;
		//errCode
		if(($this->ctrlFlag&self::CtrlErrCode) !== 0) {
			$data .= Byte::packInt8($this->errCode);
			$n += 1;
		}
		//colSpace
		if(($this->ctrlFlag&self::CtrlColSpace) !== 0) {
			$data .= Byte::packUint8($this->colSpace);
			$n += 1;
		}
		//rowKeyLen
		$data .= Byte::packUint8(strlen($this->rowKey));
		$n += 1;
		//rowKey
		$data .= Byte::packChars($this->rowKey);
		$n += strlen($this->rowKey);
		//colKeyLen
		$data .= Byte::packUint16(strlen($this->colKey));
		$n += 2;
		//colKey
		$data .= Byte::packChars($this->colKey);
		$n += strlen($this->colKey);
		//value
		if(($this->ctrlFlag&self::CtrlValue) !== 0) {
			$data .= Byte::packUint32(strlen($this->value));
			$n += 4;
			$data .= Byte::packChars($this->value);
			$n += strlen($this->value);
		}
		//score
		if(($this->ctrlFlag&self::CtrlScore) !== 0) {
			$data .= Byte::packInt64($this->score);
			$n += 8;
		}
		//cas
		if(($this->ctrlFlag&self::CtrlCas) !== 0) {
			$data .= Byte::packUint32($this->cas);
			$n += 4;
		}
		//ttl
		if(($this->ctrlFlag&self::CtrlTTL) !== 0) {
			$data .= Byte::packUint32($this->ttl);
			$n += 4;
		}
		$result['data'] = $data;
		$result['n'] = $n;
		return $result;
	}
	public function setErrCode($errCode){
		$this->errCode = $errCode;
		if($errCode !== 0) {
			$this->ctrlFlag |= self::CtrlErrCode;
		} else {
			$this->ctrlFlag &= (~self::CtrlErrCode);
		}
	}
	public function setColSpace($colSpace){
		$this->colSpace = $colSpace;
		if($colSpace !== 0) {
			$this->ctrlFlag |= self::CtrlColSpace;
		} else {
			$this->ctrlFlag &= (~self::CtrlColSpace);
		}
	}
	public function setCas($cas){
		$this->cas = $cas;
		if($cas !== 0) {
			$this->ctrlFlag |= self::CtrlCas;
		} else {
			$this->ctrlFlag &= (~self::CtrlCas);
		}
	}
	public function setValue($value){
		$this->value = $value;
		if(strlen($value) !== 0) {
			$this->ctrlFlag |= self::CtrlValue;
		} else {
			$this->ctrlFlag &= (~self::CtrlValue);
		}
	}
	public function setScore($score){
		$this->score = $score;
		if($score !== 0) {
			$this->ctrlFlag |= self::CtrlScore;
		} else {
			$this->ctrlFlag &= (~self::CtrlScore);
		}
	}
	public function setTTL($ttl) {
		if($ttl < 0) {
			WTableError::getException(WTableError::EcInvTTL);
		}
		$this->ttl = $ttl;
		if($ttl !== 0) {
			$this->ctrlFlag |= self::CtrlTTL;
		} else {
			$this->ctrlFlag &= (~self::CtrlTTL);
		}
	}

	public static function copyFromArgs(&$kv, $arg){
		if(gettype($arg) !== "object") {
			throw new WTableException("copyFromArgs input error(".gettype($arg).")", -1);
		}
		$tmp = explode("\\",get_class($arg));
		$whichClass = end($tmp);
		switch($whichClass){
		case "SetExArgs":
			$kv->setTTL($arg->ttl);
		case "SetArgs":
			$kv->tableId = $arg->tableId;
			$kv->rowKey = $arg->rowKey;
			$kv->colKey = $arg->colKey;
			$kv->setCas($arg->cas);
			$kv->setScore($arg->score);
			$kv->setValue($arg->value);
			break;
		case "GetArgs":
			$kv->tableId = $arg->tableId;
			$kv->rowKey = $arg->rowKey;
			$kv->colKey = $arg->colKey;
			$kv->setCas($arg->cas);
			break;
		case "DelArgs":
			$kv->tableId = $arg->tableId;
			$kv->rowKey = $arg->rowKey;
			$kv->colKey = $arg->colKey;
			$kv->setCas($arg->cas);
			break;
		case "IncrArgs":
			$kv->tableId = $arg->tableId;
			$kv->rowKey = $arg->rowKey;
			$kv->colKey = $arg->colKey;
			$kv->setCas($arg->cas);
			$kv->setScore($arg->score);
			break;
		default:
			throw new WTableException("copyFromArgs unknow class(".get_class($arg).")", -2);
		}
	}
	public function isExpired() {
		return $this->errCode === WTableError::EcNotExist;
	}
}
