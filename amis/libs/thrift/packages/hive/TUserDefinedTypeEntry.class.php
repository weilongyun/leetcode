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


class TUserDefinedTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var string
   */
  public $typeClassName = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'typeClassName',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TUserDefinedTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TUserDefinedTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TUserDefinedTypeEntry', self::$_TSPEC, $output);
  }

}