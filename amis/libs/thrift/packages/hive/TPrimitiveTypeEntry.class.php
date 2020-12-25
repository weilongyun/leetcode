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


class TPrimitiveTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $type = null;
  /**
   * @var \Thrift\Packages\Hive\TTypeQualifiers
   */
  public $typeQualifiers = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'type',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'typeQualifiers',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TTypeQualifiers',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TPrimitiveTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TPrimitiveTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TPrimitiveTypeEntry', self::$_TSPEC, $output);
  }

}