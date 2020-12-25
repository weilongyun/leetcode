<?php
namespace Thrift\Packages\Fb303;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class FacebookService_getCounters_result extends TBase {
  static $_TSPEC;

  /**
   * @var array
   */
  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::I64,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::I64,
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'FacebookService_getCounters_result';
  }

  public function read($input)
  {
    return $this->_read('FacebookService_getCounters_result', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('FacebookService_getCounters_result', self::$_TSPEC, $output);
  }

}