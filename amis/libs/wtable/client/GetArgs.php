<?php 
namespace WTable\client;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;

/**
 * WtableClient类中mGet、zmGet函数使用，用于指定get操作的参数。<br>
 * @author spat
 * @package WTable\client
 */
class GetArgs {
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
	/** @var int
	 *  @see WTable\Client\get*/
	public $cas;
	/** @var int
	 *  @see WTable\Client\get*/
	public $errCode;
	public function __Construct($tableId, $rowKey, $colKey,$cas=CasArgs::CAS_DEFAULT){
		if(!is_int($tableId) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcMGetFail);
		}
		$this->tableId = $tableId;
		$this->rowKey = $rowKey;
		$this->colKey = $colKey;
		$this->value = Null;
		$this->score = 0;
		$this->cas = $cas;
		$this->errCode = 0;
	}
}
