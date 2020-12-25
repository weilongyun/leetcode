<?php
namespace WTable\net;
use WTable\protocal\HostInfo;
use WTable\protocal\KeyValue;
use WTable\protocal\PkgGetHostList;
use WTable\protocal\PkgHead;
use WTable\protocal\PkgMultiOp;
use WTable\protocal\PkgOneOp;
use WTable\protocal\PkgScanReq;
use WTable\protocal\PkgDumpReq;
use WTable\protocal\PkgDumpResp;
use WTable\protocal\Protocal;

use WTable\client\CasArgs;
use WTable\client\WTableClient;

use WTable\exception\WTableError;
use WTable\exception\WTableInnerError;


class CliRep{
	private $bid;
	private $cid;
	private $dbid;
	private $password;
	private $dns;
	public $net;
	public $isAuth;

	public function __Construct($bid,$passwd,$dns){
		$this->bid = $bid;
		$this->password = $passwd;
		$this->dns = $dns;
		$this->dbid = ($this->bid & 0xff);
		$this->cid = $this->bid >> 16;
		$this->net = new Net($bid,$passwd,$dns);
	}
	public function __destruct(){
		$this->net->closeSocket();
	}
	public function init(){
		ini_set('memory_limit', '-1');
		$this->net->init();
		$this->isAuth = self::auth($this->net,$this->password);
	}
	public function setTimeout($timeout) {
		$this->net->setTimeout($timeout);
	}
	public function setConnTimeout($timeout) {
		$this->net->setConnTimeout($timeout);
	}
	public function auth($net=self::net,$passwd=self::password){
		$reply = self::doOneOp($net,false,Protocal::CmdAuth,0,$passwd,Null,Null,0,0,CasArgs::CAS_DEFAULT);
		WTableError::getException($reply->keyValue->errCode);
		return $reply->keyValue->errCode == 0 ? true : false;
	}
	public function doOneOp($net,$isZop, $cmd, $tableId, $rowKey, $colKey, $value, $score, $ttl, $cas){
		$result=array();
		$pkgOneOp=new PkgOneOp();
		$pkgOneOp->head->cmd = $cmd;
		$pkgOneOp->head->cid = $this->cid;
		$pkgOneOp->head->dbid = $this->dbid;
		$pkgOneOp->head->seq = 0;
		$pkgOneOp->keyValue->tableId = $tableId;
		$pkgOneOp->keyValue->rowKey = $rowKey;
		$pkgOneOp->keyValue->colKey = $colKey;
		$pkgOneOp->keyValue->setValue($value);
		$pkgOneOp->keyValue->setScore($score);
		$pkgOneOp->keyValue->setCas($cas);
		$pkgOneOp->keyValue->setTTL($ttl);

		// for TTL
		$pkgOneOp->pkgFlag |= KeyValue::FlagTTL;
		// ZGet, ZSet, ZDel, ZIncr
		if($isZop) {
			$pkgOneOp->pkgFlag |=  KeyValue::FlagZop;
		}
	
		$pkgLen = $pkgOneOp->length();
		if($pkgLen > Protocal::MaxPkgLen) {
			WTableError::getException(WTableError::EcInvPkgLen);
		}
		$ecRe = $pkgOneOp->encode($pkgLen);
		$qdata = $net->sendAndRecv($ecRe['data']);
	
		// reply
		$reply = new PkgOneOp();
		$reply->decode($qdata, strlen($qdata));
		
		return $reply;
	}

	public function doMultiOp($net,$isZop,$cmd,$args){
		$result=array();
		$pkgMultiOp = new PkgMultiOp();
		$pkgMultiOp->head->cmd = $cmd;
		$pkgMultiOp->head->cid = $this->cid;
		$pkgMultiOp->head->dbid = $this->dbid;
		$pkgMultiOp->head->seq = 0;
		$pkgMultiOp->setArgs($args);

		//for TTL
		$pkgMultiOp->pkgFlag |= KeyValue::FlagTTL;
		// ZGet, ZSet, ZDel, ZIncr    
		if($isZop) {
			$pkgMultiOp->pkgFlag |=  KeyValue::FlagZop;
		}
	
		$pkgLen = $pkgMultiOp->length();
		if($pkgLen > Protocal::MaxPkgLen) {
			WTableError::getException(WTableError::EcInvPkgLen);
		}
	
		$ecData = $pkgMultiOp->encode();
		$rece = $net->sendAndRecv($ecData['data']);

		//reply
		$reply = new PkgMultiOp();
		$reply->decode($rece, strlen($rece));

		return $reply;
	}
	
	public function doScan($net, $isZop, $tableId, $rowKey, $colKey,$score, $isStart, $asc, $isOrderByScore, $num)
	{
		$result=array();
		$scanReq = new PkgScanReq();
		$scanReq->pkgOneOp->head->cmd = Protocal::CmdScan;
	   	$scanReq->pkgOneOp->head->cid = $this->cid;
	   	$scanReq->pkgOneOp->head->dbid = $this->dbid;
	   	$scanReq->pkgOneOp->head->seq = 0;
	   	$scanReq->pkgOneOp->keyValue->tableId = $tableId;
	   	$scanReq->pkgOneOp->keyValue->rowKey = $rowKey;
	   	$scanReq->pkgOneOp->keyValue->colKey = $colKey;
	   	$scanReq->num = $num;

		//for TTL
	   	$pkgFlag = KeyValue::FlagTTL;
		if($asc) {
			$pkgFlag |= KeyValue::FlagScanAsc;
		}
		if($isStart) {
			$pkgFlag |= KeyValue::FlagScanKeyStart;
		}
		if($isZop) {
			$pkgFlag |= KeyValue::FlagZop;
			$scanReq->pkgOneOp->keyValue->setScore($score);
			if($isOrderByScore) {
				$scanReq->pkgOneOp->keyValue->setColSpace(KeyValue::ColSpaceScore1);
			} else {
				$scanReq->pkgOneOp->keyValue->setColSpace(KeyValue::ColSpaceScore2);
			}
		}
		$scanReq->pkgOneOp->pkgFlag = $pkgFlag;
		$pkgLen = $scanReq->length();
		if($pkgLen > Protocal::MaxPkgLen) {
			WTableError::getException(WTableError::EcInvPkgLen);
		}

		$ecData = $scanReq->encode();
		$rece = $net->sendAndRecv($ecData['data']);
	
		// reply
		$reply = new PkgMultiOp();
		$reply->decode($rece, strlen($rece));
		return $reply;
	}

	public function doDump($net, $oneTable, $tableId, $colSpace, $rowKey, $colKey,$score, $startUnitId, $endUnitId)
	{
		$result = array();
		$dumpReq = new PkgDumpReq($startUnitId,$endUnitId);
		$dumpReq->pkgOneOp->head->seq = 0;
		$dumpReq->pkgOneOp->head->cid = $this->cid;
		$dumpReq->pkgOneOp->head->dbid = $this->dbid;
		$dumpReq->pkgOneOp->head->cmd = Protocal::CmdDump;
		$dumpReq->pkgOneOp->pkgFlag |= KeyValue::FlagTTL;
		if ($oneTable) {
			$dumpReq->pkgOneOp->pkgFlag |= KeyValue::FlagDumpTable;
		}
		$dumpReq->pkgOneOp->keyValue->tableId = $tableId;
		$dumpReq->pkgOneOp->keyValue->rowKey = $rowKey;
		$dumpReq->pkgOneOp->keyValue->colKey = $colKey;
		$dumpReq->pkgOneOp->keyValue->setColSpace($colSpace);
		$dumpReq->pkgOneOp->keyValue->setScore($score);
		
		$pkgLen = $dumpReq->length();
		if($pkgLen > Protocal::MaxPkgLen) {
			WTableError::getException(WTableError::EcInvPkgLen);
		}
		$ecData = $dumpReq->encode();
		$rece = $net->sendAndRecv($ecData['data']);
	
		// reply
		$reply = new PkgDumpResp();
		$reply->decode($rece, strlen($rece));

		return $reply;
	}
}
