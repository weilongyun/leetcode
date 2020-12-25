<?php
namespace WTable\client;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;

/**
 * WtableClient类中mIncr、zmIncr函数使用，用于指定incr操作的参数。<br>
 * @author spat
 * @package WTable\client
 */
class IncrArgs {
	/** @var int
	 *  @see WTable\client\incr*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\incr*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\incr*/
	public $colKey;
	/** @var longlong
	 *  @see WTable\client\incr*/
	public $score;
	/** @var int
	 *  @see WTable\client\incr*/
	public $cas;
	/** @var int*/
	public $errCode;

	public function __Construct($tableId, $rowKey, $colKey, $score,$cas=CasArgs::CAS_DEFAULT){
		if(!is_int($tableId) || !is_int($score) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcMGetFail);
		}
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->score = $score;
		$this->cas = $cas;
		$this->errCode = 0;
	}
}
