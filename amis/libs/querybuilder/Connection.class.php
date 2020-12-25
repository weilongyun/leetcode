<?php
namespace Libs\QueryBuilder;;

use Libs\DB\DBConnManager;

class Connection extends DBConnManager {

    protected static $storedConnection;
    protected static $singletons = array();

    protected function __construct($database, $readretry, $writeretry, $connectretry)
    {
        parent::__construct($database, $readretry, $writeretry, $connectretry);
        if (!static::$storedConnection) {
            static::$storedConnection = $this;
        }
    }

    public static function getConn($database = NULL)
    {
        $class = get_called_class();
        $database = !empty($database) ? $database : $class::_DATABASE_;
        $readRetry = isset($class::$read_retry) ? $class::$read_retry : 2;
        $writeRetry = isset($class::$write_retry) ? $class::$write_retry : 2;
        $connectRetry = isset($class::$connect_retry) ? $class::$connect_retry : 3;
        if (isset($singletons[$database])) {
            return $singletons[$database];
        }

        $singletons[$database] = new self($database, $readRetry, $writeRetry, $connectRetry);
        return $singletons[$database];
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function setDatabase($database)
    {
        !empty($database) && $this->database = $database;
    }

    /**
     * @return Connection
     */
    public static function getStoredConnection()
    {
        return static::$storedConnection;
    }

}