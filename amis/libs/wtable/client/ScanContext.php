<?php
namespace WTable\client;

/**
 * scan/zsacn操作保留的上下文信息。
 * @author spat
 * @package WTable\client
 */ 
class ScanContext {
	/** @var bool*/
	public $zop;
	/** @var bool*/
	public $asc;
	/** @var bool*/
	public $orderByScore;
	/** @var int*/
	public $num;
	/** @var ScanKv*/
	public $lastKv;
}
