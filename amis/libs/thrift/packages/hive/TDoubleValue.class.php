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


class TDoubleValue extends TBase {
  static $_TSPEC;

  /**
   * @var double
   */
  public $value = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'value',
          'type' => TType::DOUBLE,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TDoubleValue';
  }

  public function read($input)
  {
    return $this->_read('TDoubleValue', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TDoubleValue', self::$_TSPEC, $output);
  }

}