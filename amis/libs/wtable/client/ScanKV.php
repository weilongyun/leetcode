<?php
namespace WTable\client;

/**
 * WtableClient类中scan函数将返回ScanKV的列表。<br>
 * @author spat
 * @package WTable\client
 * @see WTable\client\scan
 */
class ScanKV {
	/** @var str*/
	public $colKey;
	/** @var str*/
	public $value;
	/** @var longlong*/
	public $score;
	/** @var int*/
	public $ttl;

	public function __Construct($colKey, $value, $score, $ttl) {
		$this->colKey = $colKey;
		$this->value = $value;
		$this->score = $score;
		$this->ttl = $ttl;
	}
}
