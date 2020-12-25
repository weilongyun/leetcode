<?php
namespace WTable\client;

/**
 * WtableClient类中dump函数将返回DumpKV的列表，可通过getColSpace获取key所在的空间，0表示默认空间，1表示Z空间。<br>
 * @author spat
 * @package WTable\client
 * @see WTable\Client\dumpDB
 */
class DumpKv {
	/** @var int*/
	public $tableId;
	/** @var int*/
	public $colSpace;
	/** @var str*/
	public $rowKey;
	/** @var str*/
	public $colKey;
	/** @var str*/
	public $value;
	/** @var longlong*/
	public $score;
	/** @var int*/
	public $ttl;

	public function __Construct() {
		$this->tableId = 0;
		$this->colSpace = 0;
		$this->rowKey = Null;
		$this->colKey = Null;
		$this->value = Null;
		$this->score = 0;
		$this->ttl = 0;
	}
}
