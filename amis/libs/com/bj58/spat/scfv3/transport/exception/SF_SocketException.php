<?php
namespace com\bj58\spat\scf\transport\exception;

use com\bj58\spat\scf\transport\exception\SF_NormalException;
/**
 * Class SF_SocketTimeoutException
 * @brief: socket其他错误时抛出异常
 */
class SF_SocketException extends SF_NormalException {

    public function __construct($message, $code=0, \Exception $previous = null) {
        parent::__construct("[". get_class($this) ."]".$message, $code, $previous);
    }

}