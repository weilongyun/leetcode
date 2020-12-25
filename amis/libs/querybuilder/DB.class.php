<?php
namespace Libs\QueryBuilder;

class DB {
    /**
     * @var QueryBuilder
     */
    protected static $queryBuilderInstance = array();

    protected static $instance;

    protected static $database;

    private function __construct() {}

    private function __clone() {}

    public static function instance() {
        if (!isset(self::$instance)) {
            $class = new self;
            self::$instance = $class;
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args)
    {
        $clz = get_called_class();
        $result = call_user_func_array(array($clz::instance(), $method), $args);
        return $result;
    }

    protected function database($database)
    {
        $queryBuilder = $this->_factory($database);
        return $queryBuilder;
    }

    protected function table($table)
    {
        $queryBuilder = $this->_factory(static::$database);
        $queryBuilder->table($table);
        return $queryBuilder;
    }

    protected function raw($value, $bindings = array())
    {
        return new Raw($value, $bindings);
    }

    private function _factory($database)
    {
        if(empty($database)) {
            throw new Exception('No database specified.', 501);
        }
        if (empty(static::$queryBuilderInstance[$database])) {
            $connection = Connection::getConn($database);
            static::$queryBuilderInstance[$database] = new QueryBuilder($connection);
        }
        static::$database = static::$queryBuilderInstance[$database]->getConnection()->getDatabase();

        return static::$queryBuilderInstance[$database];
    }

}