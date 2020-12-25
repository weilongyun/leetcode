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


class TRow extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TColumnValue[]
   */
  public $colVals = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'colVals',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TColumnValue',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TRow';
  }

  public function read($input)
  {
    return $this->_read('TRow', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TRow', self::$_TSPEC, $output);
  }

}