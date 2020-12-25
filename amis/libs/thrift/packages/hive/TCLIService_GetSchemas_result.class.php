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


class TCLIService_GetSchemas_result extends TBase {
  static $_TSPEC;

  /**
   * @var \Thrift\Packages\Hive\TGetSchemasResp
   */
  public $success = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        0 => array(
          'var' => 'success',
          'type' => TType::STRUCT,
          'class' => '\Thrift\Packages\Hive\TGetSchemasResp',
          ),
        );
    }
    if (is_array($vals)) {
      parent::__construct(self::$_TSPEC, $vals);
    }
  }

  public function getName() {
    return 'TCLIService_GetSchemas_result';
  }

  public function read($input)
  {
    return $this->_read('TCLIService_GetSchemas_result', self::$_TSPEC, $input);
  }

  public function write($output) {
    return $this->_write('TCLIService_GetSchemas_result', self::$_TSPEC, $output);
  }

}