<?php
namespace WTable\exception;

/**
 * WtableClient定义异常类。<br>
 * 在客户端执行操作发生异常时抛出（例如请求超时等），通过getErrorCode()可以获取具体错误代码，这些代码在com.bj58.spat.wtable.exception.ErrorCode类之中定义。<br>
 * @author spat
 * @package WTable\exception
 */
class WTableException extends \Exception {
	public function __Construct($message, $errCode=0) {
		parent::__Construct($message, $errCode);
	}
}
