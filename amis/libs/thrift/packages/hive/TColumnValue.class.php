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


class TColumnValue extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TBoolValue
   */
  public $boolVal = null;
  /**
   * @var \Thrift\Packages\Hive\TByteValue
   */
  public $byteVal = null;
  /**
   * @var \Thrift\Packages\Hive\TI16Value
   */
  public $i16Val = null;
  /**
   * @var \Thrift\Packages\Hive\TI32Value
   */
  public $i32Val = null;
  /**
   * @var \Thrift\Packages\Hive\TI64Value
   */
  public $i64Val = null;
  /**
   * @var \Thrift\Packages\Hive\TDoubleValue
   */
  public $doubleVal = null;
  /**
   * @var \Thrift\Packages\Hive\TStringValue
   */
  public $stringVal = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'boolVal',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TBoolValue',
          ),
        2 => array(
          'var' => 'byteVal',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TByteValue',
          ),
        3 => array(
          'var' => 'i16Val',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TI16Value',
          ),
        4 => array(
          'var' => 'i32Val',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TI32Value',
          ),
        5 => array(
          'var' => 'i64Val',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TI64Value',
          ),
        6 => array(
          'var' => 'doubleVal',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TDoubleValue',
          ),
        7 => array(
          'var' => 'stringVal',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStringValue',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TColumnValue';
  }

  public function read($input)
  {
    return $this->_read('TColumnValue', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TColumnValue', self::$_TSPEC, $output);
  }

}