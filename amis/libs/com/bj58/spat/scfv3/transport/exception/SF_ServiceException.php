<?php
namespace com\bj58\spat\scf\transport\exception;

use com\bj58\spat\scf\transport\exception\SF_FatalException;
class SF_ServiceException extends  SF_FatalException {

    public function __construct($message, $code=0, \Exception $previous = null) {
        parent::__construct("[". get_class($this) ."]".$message, $code, $previous);
    }

}