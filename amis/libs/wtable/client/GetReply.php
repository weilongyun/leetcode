<?php
namespace WTable\client;

/**
 * WtableClient类中get、zGet、mGet、zmGet函数的返回值。<br>
 * 若记录没有设置超时时间，则TTL为0。<br>
 * @author spat
 * @package WTable\client
 */
class GetReply {
	/** @var int
	 *  @see WTable\exception\WTableError*/
	public $errCode;
	/** @var int
	 *  @see WTable\client\get*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\get*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\get*/
	public $colKey;
	/** @var str
	 *  @see WTable\client\get*/
	public $value;
	/** @var longlong
	 *  @see WTable\client\get*/
	public $score;
	/** 剩余的ttl时间，单位秒，如果ttl=0表示未设置ttl
	 *  @var int*/
	public $ttl;
	/** @var int
	 *  @see WTable\client\get*/
	public $cas;

	public function __Construct($errCode, $tableId, $rowKey, $colKey, $value, $score, $ttl, $cas = CasArgs::CAS_DEFAULT){
		$this->errCode = $errCode;
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->value = $value;
		$this->score = $score;
		$this->ttl = $ttl;
		$this->cas = $cas;
	}
}
