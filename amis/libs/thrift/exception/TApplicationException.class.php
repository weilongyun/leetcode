<?php
namespace Thrift\Exception;

use Thrift\Type\TType;


class TApplicationException extends TException
{
  static $_TSPEC =
    array(1 => array('var' => 'message',
                     'type' => TType::STRING),
          2 => array('var' => 'code',
                     'type' => TType::I32));

  const UNKNOWN = 0;
  const UNKNOWN_METHOD = 1;
  const INVALID_MESSAGE_TYPE = 2;
  const WRONG_METHOD_NAME = 3;
  const BAD_SEQUENCE_ID = 4;
  const MISSING_RESULT = 5;
  const INTERNAL_ERROR = 6;
  const PROTOCOL_ERROR = 7;
  const INVALID_TRANSFORM = 8;
  const INVALID_PROTOCOL = 9;
  const UNSUPPORTED_CLIENT_TYPE = 10;

  public function __construct($message=null, $code=0)
  {
    parent::__construct($message, $code);
  }

  public function read($output)
  {
    return $this->_read('TApplicationException', self::$_TSPEC, $output);
  }

  public function write($output)
  {
    $xfer = 0;
    $xfer += $output->writeStructBegin('TApplicationException');
    if ($message = $this->getMessage()) {
      $xfer += $output->writeFieldBegin('message', TType::STRING, 1);
      $xfer += $output->writeString($message);
      $xfer += $output->writeFieldEnd();
    }
    if ($code = $this->getCode()) {
      $xfer += $output->writeFieldBegin('type', TType::I32, 2);
      $xfer += $output->writeI32($code);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();

    return $xfer;
  }
}