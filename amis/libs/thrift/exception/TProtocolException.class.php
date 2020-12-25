<?php
namespace Thrift\Exception;



class TProtocolException extends TException
{
  const UNKNOWN = 0;
  const INVALID_DATA = 1;
  const NEGATIVE_SIZE = 2;
  const SIZE_LIMIT = 3;
  const BAD_VERSION = 4;
  const NOT_IMPLEMENTED = 5;
  const DEPTH_LIMIT = 6;

  public function __construct($message=null, $code=0)
  {
    parent::__construct($message, $code);
  }
}