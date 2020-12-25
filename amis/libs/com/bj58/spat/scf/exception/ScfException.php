<?php
namespace com\bj58\spat\scf\exception;

class ScfException extends \Exception{

//     public function __construct($message = '', $code=0) {
//         // notice: The previous parameter was added after php5.3.0
//         parent::__construct($message, $code);
//     }

    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        // notice: The previous parameter was added after php5.3.0
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ":{$this->message}\n";
    }
}