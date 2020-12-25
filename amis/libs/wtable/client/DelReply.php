<?php
namespace WTable\client;

/**
 * WtableClient类中mDel、zmDel函数的返回值。<br>
 * @author spat
 * @package WTable\client
 */
class DelReply {
	/** @var int
	 *  @see WTable\exception\WTableError*/
	public $errCode;
	/** @var int
	 *  @see WTable\client\del*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\del*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\del*/
	public $colKey;

	public function __Construct($errCode, $tableId, $rowKey, $colKey){
		$this->errCode = $errCode;
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
	}
}
