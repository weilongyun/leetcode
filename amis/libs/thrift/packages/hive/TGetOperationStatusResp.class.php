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


class TGetOperationStatusResp extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TStatus
   */
  public $status = null;
  /**
   * @var int
   */
  public $operationState = null;
  /**
   * @var string
   */
  public $sqlState = null;
  /**
   * @var int
   */
  public $errorCode = null;
  /**
   * @var string
   */
  public $errorMessage = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'status',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStatus',
          ),
        2 => array(
          'var' => 'operationState',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'sqlState',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'errorCode',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'errorMessage',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetOperationStatusResp';
  }

  public function read($input)
  {
    return $this->_read('TGetOperationStatusResp', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetOperationStatusResp', self::$_TSPEC, $output);
  }

}