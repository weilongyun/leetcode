<?php
namespace Thrift\Packages\Scribe;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class ResultCode {
  const OK = 0;
  const TRY_LATER = 1;
  static public $__names = array(
    0 => 'OK',
    1 => 'TRY_LATER',
  );
}