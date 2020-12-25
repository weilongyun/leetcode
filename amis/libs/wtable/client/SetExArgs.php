<?php
namespace WTable\client;
use WTable\exception\WTableInnerError;
use WTable\exception\WTableException;

/**
 * WtableClient类中mSetEx、zmSetEx函数使用，用于指定setEx操作的参数。<br>
 * @author spat
 * @package WTable\client
 */
class SetExArgs extends SetArgs{
	/** @var int
	 *  @see WTable\client\setEx*/
	public $ttl;
	public function __Construct($tableId, $rowKey, $colKey, $value, $score,$ttl,$cas=CasArgs::CAS_DEFAULT) {
		if(!is_int($tableId) || !is_int($score) || !is_int($ttl) || !is_int($cas)) {
			throw new WTableException("parameters type invalid", WTableInnerError::IEcMSetFail);
		}
		parent::__Construct($tableId, $rowKey, $colKey, $value, $score,$cas);
		$this->ttl = $ttl;
	}
}
