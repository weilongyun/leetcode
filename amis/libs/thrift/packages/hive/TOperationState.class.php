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


class TOperationState {
  const INITIALIZED_STATE = 0;
  const RUNNING_STATE = 1;
  const FINISHED_STATE = 2;
  const CANCELED_STATE = 3;
  const CLOSED_STATE = 4;
  const ERROR_STATE = 5;
  const UKNOWN_STATE = 6;
  const PENDING_STATE = 7;
  static public $__names = array(
    0 => 'INITIALIZED_STATE',
    1 => 'RUNNING_STATE',
    2 => 'FINISHED_STATE',
    3 => 'CANCELED_STATE',
    4 => 'CLOSED_STATE',
    5 => 'ERROR_STATE',
    6 => 'UKNOWN_STATE',
    7 => 'PENDING_STATE',
  );
}