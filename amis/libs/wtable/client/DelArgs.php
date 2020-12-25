<?php
namespace WTable\client;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;

/**
 * WtableClient类中mDel、zmDel函数参数，用于指定每一个Delete操作的参数。<br>
 * @author spat
 * @package WTable\client
 */
class DelArgs {
	/** @var int
	 *  @see WTable\client\del*/
	public $tableId;
	/** @var str
	 *  @see WTable\client\del*/
	public $rowKey;
	/** @var str
	 *  @see WTable\client\del*/
	public $colKey;
	/** @var int
	 *  @see WTable\client\del*/
	public $cas;
	/** @var int*/
	public $errCode;

	public function __Construct($tableId, $rowKey, $colKey,$cas=CasArgs::CAS_DEFAULT){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcMDelFail);
		}
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->cas = $cas;
		$this->errCode = 0;
	}
}
