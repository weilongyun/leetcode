<?php
namespace WTable\client;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;

/**
 * WtableClient类中mSet、zmSet函数使用，用于指定set操作的参数。<br>
 * @author spat
 * @package WTable\client
 */
class SetArgs {
	/** @var int
	 *  @see WTable\client\set*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\set*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\set*/
	public $colKey;
	/** @var str
	 *  @see WTable\client\set*/
	public $value;
	/** @var longlong
	 *  @see WTable\client\set*/
	public $score;
	/** @var int
	 *  @see WTable\client\set*/
	public $cas;
	/** @var int*/
	public $errCode;

	public function __Construct($tableId, $rowKey, $colKey, $value, $score,$cas=CasArgs::CAS_DEFAULT) {
		if(!is_int($tableId) || !is_int($score) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcMSetFail);
		}
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->value = $value;
		$this->score = $score;
		$this->cas = $cas;
		$this->errCode = 0;
	}
}
