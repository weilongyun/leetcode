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


class TI64Value extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $value = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'value',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TI64Value';
  }

  public function read($input)
  {
    return $this->_read('TI64Value', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TI64Value', self::$_TSPEC, $output);
  }

}