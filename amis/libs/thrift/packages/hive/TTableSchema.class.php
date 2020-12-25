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


class TTableSchema extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TColumnDesc[]
   */
  public $columns = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'columns',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TColumnDesc',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TTableSchema';
  }

  public function read($input)
  {
    return $this->_read('TTableSchema', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TTableSchema', self::$_TSPEC, $output);
  }

}