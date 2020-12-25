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


class THandleIdentifier extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $guid = null;
  /**
   * @var string
   */
  public $secret = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'guid',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'secret',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'THandleIdentifier';
  }

  public function read($input)
  {
    return $this->_read('THandleIdentifier', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('THandleIdentifier', self::$_TSPEC, $output);
  }

}