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


class TArrayTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $objectTypePtr = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'objectTypePtr',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TArrayTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TArrayTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TArrayTypeEntry', self::$_TSPEC, $output);
  }

}