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


class TFetchOrientation {
  const FETCH_NEXT = 0;
  const FETCH_PRIOR = 1;
  const FETCH_RELATIVE = 2;
  const FETCH_ABSOLUTE = 3;
  const FETCH_FIRST = 4;
  const FETCH_LAST = 5;
  static public $__names = array(
    0 => 'FETCH_NEXT',
    1 => 'FETCH_PRIOR',
    2 => 'FETCH_RELATIVE',
    3 => 'FETCH_ABSOLUTE',
    4 => 'FETCH_FIRST',
    5 => 'FETCH_LAST',
  );
}