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


class TRowSet extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $startRowOffset = null;
  /**
   * @var \Thrift\Packages\Hive\TRow[]
   */
  public $rows = null;
  /**
   * @var \Thrift\Packages\Hive\TColumn[]
   */
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'startRowOffset',
          'type' => TType::I64,
          ),
        2 => array(
          'var' => 'rows',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TRow',
            ),
          ),
        3 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TColumn',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TRowSet';
  }

  public function read($input)
  {
    return $this->_read('TRowSet', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TRowSet', self::$_TSPEC, $output);
  }

}