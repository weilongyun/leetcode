<?php
namespace WTable\client;

/**
 * WtableClient类中set、zSet、mSet、zmSet函数的返回值。<br>
 * @author spat
 * @package WTable\client
 */
class SetReply {
	/** @var int
	 *  @see WTable\exception\WTableError*/
	public $errCode;
	/** @var int
	 *  @see WTable\client\setEx*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\setEx*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\setEx*/
	public $colKey;

	public function __Construct($errCode, $tableId, $rowKey, $colKey){
		$this->errCode = $errCode;
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
	}
}
