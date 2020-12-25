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


class TColumnDesc extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $columnName = null;
  /**
   * @var \Thrift\Packages\Hive\TTypeDesc
   */
  public $typeDesc = null;
  /**
   * @var int
   */
  public $position = null;
  /**
   * @var string
   */
  public $comment = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'columnName',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'typeDesc',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TTypeDesc',
          ),
        3 => array(
          'var' => 'position',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'comment',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TColumnDesc';
  }

  public function read($input)
  {
    return $this->_read('TColumnDesc', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TColumnDesc', self::$_TSPEC, $output);
  }

}