<?php
namespace WTable\client;

/**
 * WtableClient类中scan函数返回值，可以通过getKvs函数获取ScanKV列表。<br>
 * @author spat
 * @package WTable\client
 * @see WTable\client\scan
 */
class ScanReply {
	/** @var int*/
	public $tableId;
	/** @var str*/
	public $rowKey;
	/** @var array()*/
	public $kvs;
	/** @var bool*/
	public $end;
	/** @var ScanContext*/
	private $ctx;
	public function __Construct($tableId, $rowKey) {
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->kvs = array();
		$this->end = false;
	}	
	/** 设置scan上下文环境
	 *  @param ScanContext ctx scan上下文环境
	 */
	public function setCtx($ctx) {
		$this->ctx = $ctx;
	}

	/** 获取scan上下文环境
	 *  @return ScanContext ctx scan上下文环境
	 */
	public function getCtx() {
		return $this->ctx;
	}
}
