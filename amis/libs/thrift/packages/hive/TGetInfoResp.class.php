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


class TGetInfoResp extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TStatus
   */
  public $status = null;
  /**
   * @var \Thrift\Packages\Hive\TGetInfoValue
   */
  public $infoValue = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'status',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStatus',
          ),
        2 => array(
          'var' => 'infoValue',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TGetInfoValue',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TGetInfoResp';
  }

  public function read($input)
  {
    return $this->_read('TGetInfoResp', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TGetInfoResp', self::$_TSPEC, $output);
  }

}