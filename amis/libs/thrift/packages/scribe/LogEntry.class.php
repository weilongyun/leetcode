<?php
namespace Thrift\Packages\Scribe;

use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


class LogEntry extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $category = null;
  /**
   * @var string
   */
  public $message = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'category',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'message',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'LogEntry';
  }

  public function read($input)
  {
    return $this->_read('LogEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('LogEntry', self::$_TSPEC, $output);
  }

}