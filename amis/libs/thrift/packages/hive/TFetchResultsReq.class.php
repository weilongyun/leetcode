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


class TFetchResultsReq extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TOperationHandle
   */
  public $operationHandle = null;
  /**
   * @var int
   */
  public $orientation =   0;
  /**
   * @var int
   */
  public $maxRows = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'operationHandle',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TOperationHandle',
          ),
        2 => array(
          'var' => 'orientation',
          'type' => TType::I32,
          ),
        3 => array(
          'var' => 'maxRows',
          'type' => TType::I64,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TFetchResultsReq';
  }

  public function read($input)
  {
    return $this->_read('TFetchResultsReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TFetchResultsReq', self::$_TSPEC, $output);
  }

}