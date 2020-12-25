<?php
namespace WTable\protocal;
use WTable\util\Byte;
use WTable\exception\WTableException;
use WTable\exception\WTableError;
use WTable\client\GetReply;
use WTable\client\IncrReply;

class PkgOneOp {
	public $head;
	public $pkgFlag;
	public $keyValue;

	public function __Construct(){
		$this->head = new PkgHead(array());
		$this->pkgFlag = 0;
	 	$this->keyValue = new KeyValue(array());
	}
	public function length(){
		return $this->head->length() + 1 + $this->keyValue->length();
	}
	public function decode($pkg, $pkgLen){
		$n = $this->head->decode($pkg, $pkgLen);
	
		if($n + 1 > $pkgLen) {
			throw new WTableException("recv pkgLen is unnormal(".$pkgLen.")", WTableError::EcInvPkgLen);
		}
		$this->pkgFlag = Byte::unpackUint8($pkg, $n);
		$n += 1;

		$m = $this->keyValue->decode(substr($pkg, $n), $pkgLen-$n);
		$n += $m;
		return $n;

	}
	public function encode(){
		$headRe = $this->head->encode();
		$n = $headRe['n'];
		$data = $headRe['data'];
		$result = array();
	
		$data .= Byte::packUint8($this->pkgFlag);
		$n += 1;
	
		$kvRe = $this->keyValue->encode();

		$data .= $kvRe['data'];
		$n += $kvRe['n'];
		
		$data = PkgHead::overWriteLen($data, $n);
		$result['data'] = $data;
		$result['n'] = $n;
		return $result;
	}
	public static function formatRespOneOp($oneOp) {
		if(false === ($oneOp instanceof PkgOneOp)) {
			throw new WTableException("formatRespOneOp input error(".get_class($oneOp).")", -1);
		}
	
		$reply;
		$errCode = 0;
		$kv = $oneOp->keyValue;
		switch($oneOp->head->cmd){
			case Protocal::CmdPing:
			case Protocal::CmdDel :
			case Protocal::CmdSet :
			case Protocal::CmdExpire :
				$errCode = $reply = $kv->errCode;
				break;
			case Protocal::CmdGet :
				$reply = new GetReply($kv->errCode, $kv->tableId, $kv->rowKey, $kv->colKey, $kv->value, $kv->score,$kv->ttl,$kv->cas);
				$errCode = $kv->errCode;
				break;
			case Protocal::CmdIncr :
				$reply = new IncrReply($kv->errCode, $kv->tableId, $kv->rowKey, $kv->colKey, $kv->value, $kv->score);
				$errCode = $kv->errCode;
				break;
			default:
				throw new WTableException("formatRespOneOp unknow cmd(".$oneOp->head->cmd.")", -2);
		}
		WTableError::getException($errCode);
		return $reply;
	}
}

