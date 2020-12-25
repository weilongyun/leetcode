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


class FacebookService_setOption_args extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $key = null;
  /**
   * @var string
   */
  public $value = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'key',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'value',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'FacebookService_setOption_args';
  }

  public function read($input)
  {
    return $this->_read('FacebookService_setOption_args', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('FacebookService_setOption_args', self::$_TSPEC, $output);
  }

}