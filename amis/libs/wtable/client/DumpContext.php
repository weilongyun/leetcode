<?php
namespace WTable\client;

/**
 * dump相关操作保留的上下文信息。
 * @author spat
 * @package WTable\client
 */ 
class DumpContext {
	/** @var bool*/
	public $oneTable;
	/** @var int*/
	public $tableId;
	/** @var int*/
	public $startSlotId;
	/** @var int*/
	public $endSlotId;
	/** @var int*/
	public $lastSlotId;
	/** @var bool*/
	public $slotStart;
	/** @var DumpKv*/
	public $lastKv;
}
