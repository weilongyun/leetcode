<?php
namespace WTable\client;

/**
 * WtableClient类中incr、zIncr、mIncr、zmIncr函数的返回值。<br>
 * @author spat
 * @package WTable\client
 */
class IncrReply {
	/** @var int
	 *  @see WTable\exception\WTableError*/
	public $errCode;
	/** @var int
	 *  @see WTable\client\incr*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\incr*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\incr*/
	public $colKey;
	/** @var str
	 *  @see WTable\client\incr*/
	public $value;
	/** @var longlong
	 *  @see WTable\client\incr*/
	public $score;

	public function __Construct($errCode, $tableId, $rowKey, $colKey, $value, $score){
		$this->errCode = $errCode;
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->value = $value;
		$this->score = $score;
	}
}
