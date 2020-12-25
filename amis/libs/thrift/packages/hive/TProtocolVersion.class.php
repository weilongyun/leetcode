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


class TProtocolVersion {
  const HIVE_CLI_SERVICE_PROTOCOL_V1 = 0;
  const HIVE_CLI_SERVICE_PROTOCOL_V2 = 1;
  const HIVE_CLI_SERVICE_PROTOCOL_V3 = 2;
  const HIVE_CLI_SERVICE_PROTOCOL_V4 = 3;
  const HIVE_CLI_SERVICE_PROTOCOL_V5 = 4;
  static public $__names = array(
    0 => 'HIVE_CLI_SERVICE_PROTOCOL_V1',
    1 => 'HIVE_CLI_SERVICE_PROTOCOL_V2',
    2 => 'HIVE_CLI_SERVICE_PROTOCOL_V3',
    3 => 'HIVE_CLI_SERVICE_PROTOCOL_V4',
    4 => 'HIVE_CLI_SERVICE_PROTOCOL_V5',
  );
}