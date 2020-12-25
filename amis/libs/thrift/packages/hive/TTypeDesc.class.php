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


class TTypeDesc extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TTypeEntry[]
   */
  public $types = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'types',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TTypeEntry',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TTypeDesc';
  }

  public function read($input)
  {
    return $this->_read('TTypeDesc', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TTypeDesc', self::$_TSPEC, $output);
  }

}