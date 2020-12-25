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


class TTypeId {
  const BOOLEAN_TYPE = 0;
  const TINYINT_TYPE = 1;
  const SMALLINT_TYPE = 2;
  const INT_TYPE = 3;
  const BIGINT_TYPE = 4;
  const FLOAT_TYPE = 5;
  const DOUBLE_TYPE = 6;
  const STRING_TYPE = 7;
  const TIMESTAMP_TYPE = 8;
  const BINARY_TYPE = 9;
  const ARRAY_TYPE = 10;
  const MAP_TYPE = 11;
  const STRUCT_TYPE = 12;
  const UNION_TYPE = 13;
  const USER_DEFINED_TYPE = 14;
  const DECIMAL_TYPE = 15;
  const NULL_TYPE = 16;
  const DATE_TYPE = 17;
  const VARCHAR_TYPE = 18;
  const CHAR_TYPE = 19;
  static public $__names = array(
    0 => 'BOOLEAN_TYPE',
    1 => 'TINYINT_TYPE',
    2 => 'SMALLINT_TYPE',
    3 => 'INT_TYPE',
    4 => 'BIGINT_TYPE',
    5 => 'FLOAT_TYPE',
    6 => 'DOUBLE_TYPE',
    7 => 'STRING_TYPE',
    8 => 'TIMESTAMP_TYPE',
    9 => 'BINARY_TYPE',
    10 => 'ARRAY_TYPE',
    11 => 'MAP_TYPE',
    12 => 'STRUCT_TYPE',
    13 => 'UNION_TYPE',
    14 => 'USER_DEFINED_TYPE',
    15 => 'DECIMAL_TYPE',
    16 => 'NULL_TYPE',
    17 => 'DATE_TYPE',
    18 => 'VARCHAR_TYPE',
    19 => 'CHAR_TYPE',
  );
}