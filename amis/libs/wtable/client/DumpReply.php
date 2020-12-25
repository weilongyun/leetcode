<?php
namespace WTable\client;

/**
 * WtableClient类中dump函数返回值，可以通过getKvs函数获取DumpKV列表。<br>
 * @author spat
 * @package WTable\client
 * @see WTable\client\dumpDB
 */
class DumpReply {
	/** @var array*/
	public $kvs;
	/** @var bool*/
	public $end;
	/** @var DumpContext*/
	private $ctx;

	public function __Construct() {
		$this->kvs = array();
		$this->end = false;
	}
	/** 设置dump上下文环境
	 *  @return DumpContext ctx dump上下文环境
	 */
	public function setCtx($ctx) {
		$this->ctx = $ctx;
	}
	/** 获取dump上下文环境
	 *  @return DumpContext ctx dump上下文环境
	 */
	public function getCtx() {
		return $this->ctx;
	}
}
