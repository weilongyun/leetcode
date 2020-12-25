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


class TExecuteStatementReq extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TSessionHandle
   */
  public $sessionHandle = null;
  /**
   * @var string
   */
  public $statement = null;
  /**
   * @var array
   */
  public $confOverlay = null;
  /**
   * @var bool
   */
  public $runAsync = false;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'sessionHandle',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TSessionHandle',
          ),
        2 => array(
          'var' => 'statement',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'confOverlay',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::STRING,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::STRING,
            ),
          ),
        4 => array(
          'var' => 'runAsync',
          'type' => TType::BOOL,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TExecuteStatementReq';
  }

  public function read($input)
  {
    return $this->_read('TExecuteStatementReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TExecuteStatementReq', self::$_TSPEC, $output);
  }

}