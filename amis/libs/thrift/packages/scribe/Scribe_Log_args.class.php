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


class Scribe_Log_args extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Scribe\LogEntry[]
   */
  public $messages = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'messages',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Scribe\LogEntry',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Scribe_Log_args';
  }

  public function read($input)
  {
    return $this->_read('Scribe_Log_args', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('Scribe_Log_args', self::$_TSPEC, $output);
  }

}