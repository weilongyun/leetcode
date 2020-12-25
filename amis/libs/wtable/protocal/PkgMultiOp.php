<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\client\GetReply;
use WTable\client\SetReply;
use WTable\client\DelReply;
use WTable\client\IncrReply;
use WTable\client\ScanReply;
use WTable\client\ScanContext;
use WTable\client\ScanKV;

class PkgMultiOp {
	public $head;
	public $pkgFlag;
	public $errCode;
	public $kvs;

	public function __Construct() {
		$this->head = new PkgHead(array());
		$this->pkgFlag = 0;
		$this->errCode = 0;
		$this->kvs = array();
	}
	public function setArgs($args){
		for($i = 0; $i < count($args); $i++){
			$k = new KeyValue(array());
			KeyValue::copyFromArgs($k, $args[$i]);
			$this->kvs[] = $k;
		}
	}
	public function length(){
	// PKG = HEAD+cPkgFlag+cErrCode+wNum+KeyValue[wNum]
		$n = Protocal::HeadSize + 4;
		for($i = 0; $i < count($this->kvs); $i++) {
			$n += $this->kvs[$i]->length();
		}
		return $n;
	}
	public function decode($pkg, $pkgLen){
		$n = $this->head->decode($pkg, $pkgLen);
		
		if($n + 4 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		//pkgFlag
		$this->pkgFlag = Byte::unpackUint8($pkg, $n);
		$n += 1;
		//errCode
		$this->errCode = Byte::unpackInt8($pkg, $n);
		$n += 1;
		//kvs Num
		$numKvs = Byte::unpackUint16($pkg, $n);
		$n += 2;
	
		$kvs = array();
		for($i = 0; $i < $numKvs; $i++) {
			$k = new KeyValue(array());
			$m = $k->decode(substr($pkg, $n), $pkgLen-$n);
			$this->kvs[] = $k;
			$n += $m;
		}
		return $n;
	}
	public function encode(){
		$result = array();
		$numKvs = count($this->kvs);
		if($numKvs > Protocal::MaxUint16) {
			WTableError::getException(WTableError::EcInvKvNum);
		}
		$hRe = $this->head->encode();
		$n = $hRe['n'];
		$data = $hRe['data'];
		
		$data .= Byte::packUint8($this->pkgFlag);
		$n += 1;
		$data .= Byte::packInt8($this->errCode);
		$n += 1;

		$data .= Byte::packUint16($numKvs);
		$n += 2;
	
		for($v = 0; $v < $numKvs; $v++) {
			$kvItem = $this->kvs[$v]->encode();
			$m = $kvItem['n'];
			$data .= $kvItem['data'];
			$n += $m;
		}
	
		$data = PkgHead::overWriteLen($data, $n);
		$result['n'] = $n;
		$result['data'] = $data;
		return $result;
	}
	
	public static function formatRespMultiOp($op) {
		$tmp = explode("\\",get_class($op));
		if(end($tmp) !== "PkgMultiOp") {
			throw new WTableException("formatRespMultiOp input is not PkgMultiOp", -1);
		}
		//to throw WTableException
		WTableError::getException($op->errCode);
	
		$reply = array();
		$kvs = $op->kvs;
		$kvsNum = count($kvs);
		$needThrowException = true;
		switch($op->head->cmd){
			case Protocal::CmdMGet :
				for($i = 0; $i < $kvsNum; $i++){
					$item = new GetReply($kvs[$i]->errCode, $kvs[$i]->tableId, $kvs[$i]->rowKey, $kvs[$i]->colKey, $kvs[$i]->value, $kvs[$i]->score, $kvs[$i]->ttl, $kvs[$i]->cas);
					if($kvs[$i]->errCode >= 0) {
					    $needThrowException = false;
					}
					$reply[] = $item;
				}
				break;
			case Protocal::CmdMSet :
				for($i = 0; $i < $kvsNum; $i++){
					$item = new SetReply($kvs[$i]->errCode, $kvs[$i]->tableId, $kvs[$i]->rowKey, $kvs[$i]->colKey);
					if($kvs[$i]->errCode >= 0) {
					    $needThrowException = false;
					}
					$reply[] = $item;
				}
				break;
			case Protocal::CmdMDel :
				for($i = 0; $i < $kvsNum; $i++){
					$item = new DelReply($kvs[$i]->errCode, $kvs[$i]->tableId, $kvs[$i]->rowKey, $kvs[$i]->colKey);
					if($kvs[$i]->errCode >= 0) {
					    $needThrowException = false;
					}
					$reply[] = $item;
				}
				break;
			case Protocal::CmdMIncr :
				for($i = 0; $i < $kvsNum; $i++){
					$item = new IncrReply($kvs[$i]->errCode, $kvs[$i]->tableId, $kvs[$i]->rowKey, $kvs[$i]->colKey, $kvs[$i]->value, $kvs[$i]->score);
					if($kvs[$i]->errCode >= 0) {
					    $needThrowException = false;
					}
					$reply[] = $item;
				}
				break;
			default :
				throw new WTableException("formatRespMultiOp unknow cmd(".$op->head->cmd.")", -2);
		}
		if($needThrowException && $reply !== Null) {
			WTableError::getException($reply[0]->errCode);
		}
		return $reply;
	}
	
	public static function formatRespScan($op, $tableId, $rowKey, $num, $zop, $asc, $orderByScore) {
		WTableError::getException($op->errCode);
		$scanReply = new ScanReply($tableId, $rowKey);
		$scanKvs = array();
		$lastKv = Null;
		if($op !== Null && $op->kvs !== Null) {
			$scanReply->end = (($op->pkgFlag&KeyValue::FlagScanEnd) !== 0);
			$kvs = $op->kvs;
			$kvsCnt = count($kvs);
			if(0 !== $kvsCnt) {
				$kv = $kvs[$kvsCnt-1];
				$lastKv = new ScanKV($kv->colKey,$kv->value,$kv->score,$kv->ttl);
				if(1 === $kvsCnt && $kv->isExpired()) {
					$kvsCnt = 0;
				}
			}else{
				$scanReply->end = true;
			}
			for($i = 0; $i < $kvsCnt; $i++) {
				$kv = new ScanKV($kvs[$i]->colKey, $kvs[$i]->value, $kvs[$i]->score,$kvs[$i]->ttl);
				$scanKvs[] = $kv;
			}
		}
		$scanReply->kvs = $scanKvs;
	
		$ctx = new ScanContext();
		$ctx->zop = $zop;
		$ctx->num = $num;
		$ctx->asc = $asc;
		$ctx->orderByScore = $orderByScore;
		$ctx->lastKv = $lastKv;
		$scanReply->setCtx($ctx);
	
		return $scanReply;
	}
}



