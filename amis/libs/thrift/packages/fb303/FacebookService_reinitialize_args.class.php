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


class FacebookService_reinitialize_args extends TBase {
  static $_TSPEC;


  public function __construct() {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        );
    }
  }

  public function getName() {
    return 'FacebookService_reinitialize_args';
  }

  public function read($input)
  {
    return $this->_read('FacebookService_reinitialize_args', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('FacebookService_reinitialize_args', self::$_TSPEC, $output);
  }

}