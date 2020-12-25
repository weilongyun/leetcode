<?php
namespace com\bj58\spat\scf\transport\exception;
use com\bj58\spat\scf\exception\ScfException;
/**
 * Class SF_FatalException
 * @brief: finagle-php的致命错误都继承自些类
 *
 */
class SF_FatalException extends ScfException {

    /**
     * @param string $message 异常信息
     * @param int $code  异常代码
     * @param Exception $previous
     */
    public function __construct($message, $code=0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return "[" . __CLASS__ . "]:{$this->message}";
    }

}


