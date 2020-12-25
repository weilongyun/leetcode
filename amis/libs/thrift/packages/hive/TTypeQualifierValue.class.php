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


class TTypeQualifierValue extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $i32Value = null;
  /**
   * @var string
   */
  public $stringValue = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'i32Value',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'stringValue',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TTypeQualifierValue';
  }

  public function read($input)
  {
    return $this->_read('TTypeQualifierValue', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TTypeQualifierValue', self::$_TSPEC, $output);
  }

}