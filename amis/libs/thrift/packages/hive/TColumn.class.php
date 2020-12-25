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


class TColumn extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TBoolValue[]
   */
  public $boolColumn = null;
  /**
   * @var \Thrift\Packages\Hive\TByteValue[]
   */
  public $byteColumn = null;
  /**
   * @var \Thrift\Packages\Hive\TI16Value[]
   */
  public $i16Column = null;
  /**
   * @var \Thrift\Packages\Hive\TI32Value[]
   */
  public $i32Column = null;
  /**
   * @var \Thrift\Packages\Hive\TI64Value[]
   */
  public $i64Column = null;
  /**
   * @var \Thrift\Packages\Hive\TDoubleValue[]
   */
  public $doubleColumn = null;
  /**
   * @var \Thrift\Packages\Hive\TStringValue[]
   */
  public $stringColumn = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'boolColumn',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TBoolValue',
            ),
          ),
        2 => array(
          'var' => 'byteColumn',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TByteValue',
            ),
          ),
        3 => array(
          'var' => 'i16Column',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TI16Value',
            ),
          ),
        4 => array(
          'var' => 'i32Column',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TI32Value',
            ),
          ),
        5 => array(
          'var' => 'i64Column',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TI64Value',
            ),
          ),
        6 => array(
          'var' => 'doubleColumn',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TDoubleValue',
            ),
          ),
        7 => array(
          'var' => 'stringColumn',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TStringValue',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TColumn';
  }

  public function read($input)
  {
    return $this->_read('TColumn', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TColumn', self::$_TSPEC, $output);
  }

}