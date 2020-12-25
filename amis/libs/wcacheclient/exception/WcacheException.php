<?php
namespace wcacheclient\exception;

class WcacheException extends \Exception
{
    protected   $message = 'Unknown exception';   
    protected $code = 0;                        
    protected $file;                            
    protected $line;

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
        $this->line = parent::getLine();
        $this->file = parent::getFile();
    }

    public function __toString() {
        return "[File:{$this->file} Line:{$this->line}], " . __CLASS__ . ": [{$this->code}]:  {$this->message}\n";
    }

}