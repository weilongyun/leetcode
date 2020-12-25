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


class TSessionHandle extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\THandleIdentifier
   */
  public $sessionId = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'sessionId',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\THandleIdentifier',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TSessionHandle';
  }

  public function read($input)
  {
    return $this->_read('TSessionHandle', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TSessionHandle', self::$_TSPEC, $output);
  }

}