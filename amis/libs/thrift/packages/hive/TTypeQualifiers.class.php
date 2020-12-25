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


class TTypeQualifiers extends TBase {
  static $_TSPEC;

  /**
   * @var array
   */
  public $qualifiers = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'qualifiers',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::STRUCT,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::STRUCT,
            'class' => '\Thrift\Packages\Hive\TTypeQualifierValue',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TTypeQualifiers';
  }

  public function read($input)
  {
    return $this->_read('TTypeQualifiers', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TTypeQualifiers', self::$_TSPEC, $output);
  }

}