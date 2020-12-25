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


class TGetDelegationTokenReq extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TSessionHandle
   */
  public $sessionHandle = null;
  /**
   * @var string
   */
  public $owner = null;
  /**
   * @var string
   */
  public $renewer = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'sessionHandle',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TSessionHandle',
          ),
        2 => array(
          'var' => 'owner',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'renewer',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetDelegationTokenReq';
  }

  public function read($input)
  {
    return $this->_read('TGetDelegationTokenReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetDelegationTokenReq', self::$_TSPEC, $output);
  }

}