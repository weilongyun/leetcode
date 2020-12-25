<?php
namespace Libs\DB;

use Libs\Log\ExceptionLog;
use Libs\Wmonitor\WMonitorRBI;

class DBConnManager {

    public static function getConn() {
        static $singletons = array();
        $class = get_called_class();
        $database = $class::_DATABASE_;
        $readRetry = isset($class::$read_retry) ? $class::$read_retry : 2;
        $writeRetry = isset($class::$write_retry) ? $class::$write_retry : 2;
        $connectRetry = isset($class::$connect_retry) ? $class::$connect_retry : 3;
        if (isset($singletons[$database])) {
            return $singletons[$database];
        }

        $singletons[$database] = new DBConnManager($database, $readRetry, $writeRetry, $connectRetry);
        return $singletons[$database];
    }

    protected $database = null;
    protected $configs = array('MASTER' => null, 'SLAVES' => null);
    protected $conns = array();
    protected $readRetry;
    protected $writeRetry;
    protected $connectRetry;

    protected function __construct($database, $readretry, $writeretry, $connectretry) {
        $this->database = $database;
        $this->readRetry = $readretry;
        $this->writeRetry = $writeretry;
        $this->connectRetry = $connectretry;
    }

    public function write($sql, $params=array()) {
        try{
            return $this->_write($sql, $params);
        } catch (\Exception $e) {
            WMonitorRBI::setRBI(WMonitorRBI::WMONITOR_GONG_MYSQL_ERROR, 1);
            ExceptionLog::Log($e, 'mysql_exception_log');
            throw $e;
        }
    }

    private function _write($sql, $params=array()) {
        $that = $this;
        return \Frame\Helper\Util::retry(
            $this->writeRetry,
            function() use ($sql, $params, $that) {
                try {
                    return $that->getConnection('MASTER')->write($sql, $params);
                } catch (\Frame\Exception\RetryException $e) {
                    $that->releaseConn('MASTER');
                    //real retry
                    throw new \Frame\Exception\RetryException($e->getMessage());
                }
            }
        );
    }

    public function read($sql, $params=array(), $master = false, $hashkey = null) {
        try{
            return $this->_read($sql, $params, $master, $hashkey);
        } catch (\Exception $e) {
            WMonitorRBI::setRBI(WMonitorRBI::WMONITOR_GONG_MYSQL_ERROR, 1);
            ExceptionLog::Log($e, 'mysql_exception_log');
            throw $e;
        }
    }

    private function _read($sql, $params=array(), $master = false, $hashkey = null) {
        $that = $this;
        return \Frame\Helper\Util::retry(
            $this->readRetry,
            function() use ($sql, $params, $master, $hashkey, $that) {
                try {
                    $connection = $master ? $that->getConnection('MASTER') : $that->getConnection('SLAVES');
                    return $connection->read($sql, $params, $hashkey);
                } catch (\Frame\Exception\RetryException $e) {
                    $master ? $that->releaseConn('MASTER') : $that->releaseConn('SLAVES');
                    throw new \Frame\Exception\RetryException($e->getMessage());
                }
            }
        );
    }
    
    public function getInsertId() {
        return $this->getConnection('MASTER')->getInsertId();
    }

    public function getConnection($type) {
        if (isset($this->conns[$type]) && !is_null($this->conns[$type])) {
            return $this->conns[$type];
        }
        $config = $this->loadConfig($this->database, $type);
        $host = $config['HOST'];
        $port = $config['PORT'];
        $user = $config['USER'];
        $pass = $config['PASS'];
        $db   = $config['DB'];

        $this->conns[$type] = \Frame\Helper\Util::retry(
            $this->connectRetry,
            function() use ($host, $db, $user, $pass, $port) {
                return new \Frame\Connect\Database($host, $db, $user, $pass, $port);
            }
        );
        return $this->conns[$type];
    }

    public function releaseConn($type) {
        $this->conns[$type] = null;
    }

    protected function loadConfig($database, $type) {
        is_null($this->configs[$type]) && $this->configs[$type] = DBConfig::instance()->loadConfig($database, $type);
        $conf = $this->configs[$type]->current();
        $this->configs[$type]->next();
        !$this->configs[$type]->valid() && $this->configs[$type]->rewind();
        return $conf;
    }

}
