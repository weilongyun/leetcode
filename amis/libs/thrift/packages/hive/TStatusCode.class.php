<?php
namespace Thrift\Packages\Hive;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class TStatusCode {
  const SUCCESS_STATUS = 0;
  const SUCCESS_WITH_INFO_STATUS = 1;
  const STILL_EXECUTING_STATUS = 2;
  const ERROR_STATUS = 3;
  const INVALID_HANDLE_STATUS = 4;
  static public $__names = array(
    0 => 'SUCCESS_STATUS',
    1 => 'SUCCESS_WITH_INFO_STATUS',
    2 => 'STILL_EXECUTING_STATUS',
    3 => 'ERROR_STATUS',
    4 => 'INVALID_HANDLE_STATUS',
  );
}