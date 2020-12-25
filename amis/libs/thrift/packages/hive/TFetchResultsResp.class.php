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


class TFetchResultsResp extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TStatus
   */
  public $status = null;
  /**
   * @var bool
   */
  public $hasMoreRows = null;
  /**
   * @var \Thrift\Packages\Hive\TRowSet
   */
  public $results = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'status',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStatus',
          ),
        2 => array(
          'var' => 'hasMoreRows',
          'type' => TType::BOOL,
          ),
        3 => array(
          'var' => 'results',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TRowSet',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TFetchResultsResp';
  }

  public function read($input)
  {
    return $this->_read('TFetchResultsResp', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TFetchResultsResp', self::$_TSPEC, $output);
  }

}