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


class Scribe_Log_result extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::I32,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'Scribe_Log_result';
  }

  public function read($input)
  {
    return $this->_read('Scribe_Log_result', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('Scribe_Log_result', self::$_TSPEC, $output);
  }

}