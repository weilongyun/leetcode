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


class TStructTypeEntry extends TBase {
  static $_TSPEC;

  /**
   * @var array
   */
  public $nameToTypePtr = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'nameToTypePtr',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::I32,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::I32,
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TStructTypeEntry';
  }

  public function read($input)
  {
    return $this->_read('TStructTypeEntry', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TStructTypeEntry', self::$_TSPEC, $output);
  }

}