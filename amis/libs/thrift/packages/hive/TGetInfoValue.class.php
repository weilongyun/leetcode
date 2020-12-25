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


class TGetInfoValue extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $stringValue = null;
  /**
   * @var int
   */
  public $smallIntValue = null;
  /**
   * @var int
   */
  public $integerBitmask = null;
  /**
   * @var int
   */
  public $integerFlag = null;
  /**
   * @var int
   */
  public $binaryValue = null;
  /**
   * @var int
   */
  public $lenValue = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'stringValue',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'smallIntValue',
          'type' => TType::I16,
          ),
        3 => array(
          'var' => 'integerBitmask',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'integerFlag',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'binaryValue',
          'type' => TType::I32,
          ),
        6 => array(
          'var' => 'lenValue',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetInfoValue';
  }

  public function read($input)
  {
    return $this->_read('TGetInfoValue', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetInfoValue', self::$_TSPEC, $output);
  }

}