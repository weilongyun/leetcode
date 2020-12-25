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


class TCloseSessionResp extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TStatus
   */
  public $status = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'status',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStatus',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TCloseSessionResp';
  }

  public function read($input)
  {
    return $this->_read('TCloseSessionResp', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TCloseSessionResp', self::$_TSPEC, $output);
  }

}