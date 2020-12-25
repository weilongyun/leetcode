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


class TOperationHandle extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\THandleIdentifier
   */
  public $operationId = null;
  /**
   * @var int
   */
  public $operationType = null;
  /**
   * @var bool
   */
  public $hasResultSet = null;
  /**
   * @var double
   */
  public $modifiedRowCount = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'operationId',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\THandleIdentifier',
          ),
        2 => array(
          'var' => 'operationType',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'hasResultSet',
          'type' => TType::BOOL,
          ),
        4 => array(
          'var' => 'modifiedRowCount',
          'type' => TType::DOUBLE,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TOperationHandle';
  }

  public function read($input)
  {
    return $this->_read('TOperationHandle', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TOperationHandle', self::$_TSPEC, $output);
  }

}