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


class Constant extends \Thrift\Type\TConstant {
  static protected $PRIMITIVE_TYPES;
  static protected $COMPLEX_TYPES;
  static protected $COLLECTION_TYPES;
  static protected $TYPE_NAMES;
  static protected $CHARACTER_MAXIMUM_LENGTH;
  static protected $PRECISION;
  static protected $SCALE;

  static protected function init_PRIMITIVE_TYPES() {
    return array(
            0 => true,
            1 => true,
            2 => true,
            3 => true,
            4 => true,
            5 => true,
            6 => true,
            7 => true,
            8 => true,
            9 => true,
            15 => true,
            16 => true,
            17 => true,
            18 => true,
            19 => true,
    );
  }

  static protected function init_COMPLEX_TYPES() {
    return array(
            10 => true,
            11 => true,
            12 => true,
            13 => true,
            14 => true,
    );
  }

  static protected function init_COLLECTION_TYPES() {
    return array(
            10 => true,
            11 => true,
    );
  }

  static protected function init_TYPE_NAMES() {
    return array(
            0 => "BOOLEAN",
            1 => "TINYINT",
            2 => "SMALLINT",
            3 => "INT",
            4 => "BIGINT",
            5 => "FLOAT",
            6 => "DOUBLE",
            7 => "STRING",
            8 => "TIMESTAMP",
            9 => "BINARY",
            10 => "ARRAY",
            11 => "MAP",
            12 => "STRUCT",
            13 => "UNIONTYPE",
            15 => "DECIMAL",
            16 => "NULL",
            17 => "DATE",
            18 => "VARCHAR",
            19 => "CHAR",
    );
  }

  static protected function init_CHARACTER_MAXIMUM_LENGTH() {
    return "characterMaximumLength";
  }

  static protected function init_PRECISION() {
    return "precision";
  }

  static protected function init_SCALE() {
    return "scale";
  }
}