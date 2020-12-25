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


class TTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TPrimitiveTypeEntry
   */
  public $primitiveEntry = null;
  /**
   * @var \Thrift\Packages\Hive\TArrayTypeEntry
   */
  public $arrayEntry = null;
  /**
   * @var \Thrift\Packages\Hive\TMapTypeEntry
   */
  public $mapEntry = null;
  /**
   * @var \Thrift\Packages\Hive\TStructTypeEntry
   */
  public $structEntry = null;
  /**
   * @var \Thrift\Packages\Hive\TUnionTypeEntry
   */
  public $unionEntry = null;
  /**
   * @var \Thrift\Packages\Hive\TUserDefinedTypeEntry
   */
  public $userDefinedTypeEntry = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'primitiveEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TPrimitiveTypeEntry',
          ),
        2 => array(
          'var' => 'arrayEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TArrayTypeEntry',
          ),
        3 => array(
          'var' => 'mapEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TMapTypeEntry',
          ),
        4 => array(
          'var' => 'structEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TStructTypeEntry',
          ),
        5 => array(
          'var' => 'unionEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TUnionTypeEntry',
          ),
        6 => array(
          'var' => 'userDefinedTypeEntry',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TUserDefinedTypeEntry',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TTypeEntry', self::$_TSPEC, $output);
  }

}