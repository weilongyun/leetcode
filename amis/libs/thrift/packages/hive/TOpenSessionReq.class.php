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


class TOpenSessionReq extends TBase {
  static $_TSPEC;

  /**
   * @var int
   */
  public $client_protocol =   4;
  /**
   * @var string
   */
  public $username = null;
  /**
   * @var string
   */
  public $password = null;
  /**
   * @var array
   */
  public $configuration = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'client_protocol',
          'type' => TType::I32,
          ),
        2 => array(
          'var' => 'username',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'password',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'configuration',
          'type' => TType::MAP,
          'ktype' => TType::STRING,
          'vtype' => TType::STRING,
          'key' => array(
            'type' => TType::STRING,
          ),
          'val' => array(
            'type' => TType::STRING,
            ),
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TOpenSessionReq';
  }

  public function read($input)
  {
    return $this->_read('TOpenSessionReq', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TOpenSessionReq', self::$_TSPEC, $output);
  }

}