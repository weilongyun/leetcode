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


class TGetLogReq extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TOperationHandle
   */
  public $operationHandle = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'operationHandle',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TOperationHandle',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetLogReq';
  }

  public function read($input)
  {
    return $this->_read('TGetLogReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetLogReq', self::$_TSPEC, $output);
  }

}