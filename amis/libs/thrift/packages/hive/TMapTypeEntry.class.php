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


class TMapTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $keyTypePtr = null;
  /**
   * @var int
   */
  public $valueTypePtr = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'keyTypePtr',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'valueTypePtr',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TMapTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TMapTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TMapTypeEntry', self::$_TSPEC, $output);
  }

}