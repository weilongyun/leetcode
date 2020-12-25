<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\client\DumpKv;
use WTable\client\DumpReply;
use WTable\client\DumpContext;

class PkgDumpResp {
	public $pkgMultiOp;
	public $startUnitId;
	public $endUnitId;
	public $lastUnitId; // Last Unit ID tried to dump

	public function __construct(){
		$this->pkgMultiOp = new PkgMultiOp();
		$this->startUnitId = 0;
		$this->endUnitId = 0;
		$this->lastUnitId = 0;
	}

	public function length(){
		return $this->pkgMultiOp->length() + 6;
	}
	public function decode($pkg, $len){
		$n = $this->pkgMultiOp->decode($pkg, $len);
		if($n + 6 > $len) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->startUnitId = Byte::unpackUint16($pkg, $n);
		$n += 2;
		$this->endUnitId = Byte::unpackUint16($pkg, $n);
		$n += 2;
		$this->lastUnitId = Byte::unpackUint16($pkg, $n);
		$n += 2;
		return $n;
	}
	
	public static function formatRspDump($dumpResp, $oneTable, $tableId) {
		WTableError::getException($dumpResp->pkgMultiOp->errCode);
		$dumpReply = new DumpReply();
		$dumpKvs = array();
		$lastKv = new DumpKv();
		if($dumpResp !== Null && $dumpResp->pkgMultiOp->kvs !== Null) {
			$dumpReply->end = (($dumpResp->pkgMultiOp->pkgFlag&KeyValue::FlagDumpEnd) !== 0);
			$kvs = $dumpResp->pkgMultiOp->kvs;
			$kvsCnt = count($kvs);
			if($kvsCnt !== 0) {
				$kv = $kvs[$kvsCnt-1];
				$lastKv->tableId = $kv->tableId;
				$lastKv->colSpace = $kv->colSpace;
				$lastKv->rowKey = $kv->rowKey;
				$lastKv->colKey = $kv->colKey;
				$lastKv->value = $kv->value;
				$lastKv->score = $kv->score;
				$lastKv->ttl = $kv->ttl;
				if(1 === $kvsCnt && $kv->isExpired()) {
					$kvsCnt = 0;
				}
			}
			for($i = 0; $i < $kvsCnt; $i+=1) {
				$kv = new DumpKv();
				$kv->tableId = $kvs[$i]->tableId;
				$kv->colSpace = $kvs[$i]->colSpace;
				$kv->rowKey = $kvs[$i]->rowKey;
				$kv->colKey = $kvs[$i]->colKey;
				$kv->value = $kvs[$i]->value;
				$kv->score = $kvs[$i]->score;
				$kv->ttl = $kvs[$i]->ttl;
				$dumpKvs[] = $kv;
			}
		}
		$dumpReply->kvs = $dumpKvs;
		
		$ctx = new DumpContext();
		$ctx->oneTable = $oneTable;
		$ctx->tableId = $tableId;
		$ctx->startSlotId = $dumpResp->startUnitId;
		$ctx->endSlotId = $dumpResp->endUnitId;
		$ctx->lastSlotId = $dumpResp->lastUnitId;
		$ctx->slotStart = (($dumpResp->pkgMultiOp->pkgFlag&KeyValue::FlagDumpUnitStart) !== 0);
		$ctx->lastKv = $lastKv;
		$dumpReply->setCtx($ctx);
		return $dumpReply;
	}
		
}
