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


class TGetFunctionsReq extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TSessionHandle
   */
  public $sessionHandle = null;
  /**
   * @var string
   */
  public $catalogName = null;
  /**
   * @var string
   */
  public $schemaName = null;
  /**
   * @var string
   */
  public $functionName = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'sessionHandle',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TSessionHandle',
          ),
        2 => array(
          'var' => 'catalogName',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'schemaName',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'functionName',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetFunctionsReq';
  }

  public function read($input)
  {
    return $this->_read('TGetFunctionsReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetFunctionsReq', self::$_TSPEC, $output);
  }

}