<?php
namespace Libs\QueryBuilder;;

use Libs\QueryBuilder\Adapters\Mysql;

class QueryBuilder {

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $statements = array();

    /**
     * @var \Libs\QueryBuilder\Adapters\Mysql
     */
    protected $adapterInstance;


    public function __construct(Connection $connection = null)
    {
        if (is_null($connection)) {
            if (!$connection = Connection::getStoredConnection()) {
                throw new Exception('No table specified.', 501);
            }
        }

        $this->connection = $connection;

        // Query builder adapter instance
        $this->adapterInstance = new Mysql($this->connection);

    }

    /**
     * @param Connection $connection
     *
     * @return $this
     */
    public function setConnection(Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function addStatement($key, $value)
    {
        if (!is_array($value)) {
            $value = array($value);
        }

        if (!isset($this->statements[$key])) {
            $this->statements[$key] = $value;
        } else {
            $this->statements[$key] = array_merge($this->statements[$key], $value);
        }
    }

    /**
     * @param $key
     */
    protected function resetStatement($key='')
    {
        if(!empty($key)) {
            unset($this->statements[$key]);
        }else {
            $this->statements = array();
        }
    }

    /**
     * @return array
     */
    public function getStatements()
    {
        return $this->statements;
    }

    /**
     * @param $tables
     *
     * @return static
     */
    public function table($table)
    {
        $this->addStatement('table', $table);
        return $this;
    }

    /**
     * @param $fields
     *
     * @return $this
     */
    public function select($fields)
    {
        if (!is_array($fields)) {
            $fields = func_get_args();
        }

        $this->addStatement('selects', $fields);
        return $this;
    }

    /**
     * @param $fields
     *
     * @return $this
     */
    public function selectDistinct($fields)
    {
        $this->select($fields);
        $this->addStatement('distinct', true);
        return $this;
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function where($key, $operator = null, $value = null)
    {
        // If two params are given then assume operator is =
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        return $this->_where($key, $operator, $value);
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function orWhere($key, $operator = null, $value = null)
    {
        // If two params are given then assume operator is =
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }

        return $this->_where($key, $operator, $value, 'OR');
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function whereNot($key, $operator = null, $value = null)
    {
        // If two params are given then assume operator is =
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        return $this->_where($key, $operator, $value, 'AND NOT');
    }

    /**
     * @param $key
     * @param $operator
     * @param $value
     *
     * @return $this
     */
    public function orWhereNot($key, $operator = null, $value = null)
    {
        // If two params are given then assume operator is =
        if (func_num_args() == 2) {
            $value = $operator;
            $operator = '=';
        }
        return $this->_where($key, $operator, $value, 'OR NOT');
    }

    /**
     * @param       $key
     * @param array $values
     *
     * @return $this
     */
    public function whereIn($key, array $values)
    {
        return $this->_where($key, 'IN', $values, 'AND');
    }

    /**
     * @param       $key
     * @param array $values
     *
     * @return $this
     */
    public function whereNotIn($key, array $values)
    {
        return $this->_where($key, 'NOT IN', $values, 'AND');
    }

    /**
     * @param       $key
     * @param array $values
     *
     * @return $this
     */
    public function orWhereIn($key, array $values)
    {
        return $this->_where($key, 'IN', $values, 'OR');
    }

    /**
     * @param       $key
     * @param array $values
     *
     * @return $this
     */
    public function orWhereNotIn($key, array $values)
    {
        return $this->_where($key, 'NOT IN', $values, 'OR');
    }

    /**
     * @param $key
     * @param $valueFrom
     * @param $valueTo
     *
     * @return $this
     */
    public function whereBetween($key, $valueFrom, $valueTo)
    {
        return $this->_where($key, 'BETWEEN', array($valueFrom, $valueTo), 'AND');
    }

    /**
     * @param $key
     * @param $valueFrom
     * @param $valueTo
     *
     * @return $this
     */
    public function orWhereBetween($key, $valueFrom, $valueTo)
    {
        return $this->_where($key, 'BETWEEN', array($valueFrom, $valueTo), 'OR');
    }

    /**
     * @param $key
     * @return QueryBuilder
     */
    public function whereNull($key)
    {
        return $this->_whereNull($key);
    }

    /**
     * @param $key
     * @return QueryBuilder
     */
    public function whereNotNull($key)
    {
        return $this->_whereNull($key, 'NOT');
    }

    /**
     * @param $key
     * @return QueryBuilder
     */
    public function orWhereNull($key)
    {
        return $this->_whereNull($key, '', 'or');
    }

    /**
     * @param $key
     * @return QueryBuilder
     */
    public function orWhereNotNull($key)
    {
        return $this->_whereNull($key, 'NOT', 'or');
    }

    protected function _whereNull($key, $prefix = '', $operator = '')
    {
        $key = $this->adapterInstance->wrapSanitizer($key);
        return $this->{$operator . 'Where'}($this->raw("{$key} IS {$prefix} NULL"));
    }

    /**
     * @param        $key
     * @param        $operator
     * @param        $value
     * @param string $joiner
     *
     * @return $this
     */
    protected function _where($key, $operator = null, $value = null, $joiner = 'AND')
    {
        $this->statements['wheres'][] = compact('key', 'operator', 'value', 'joiner');
        return $this;
    }

    /**
     * @param $field
     *
     * @return $this
     */
    public function groupBy($field)
    {
        $this->addStatement('groupBys', $field);
        return $this;
    }

    /**
     * @param        $fields
     * @param string $defaultDirection
     *
     * @return $this
     */
    public function orderBy($fields, $defaultDirection = 'ASC')
    {
        if (!is_array($fields)) {
            $fields = array($fields);
        }

        foreach ($fields as $key => $value) {
            $field = $key;
            $type = $value;
            if (is_int($key)) {
                $field = $value;
                $type = $defaultDirection;
            }

            $this->statements['orderBys'][] = compact('field', 'type');
        }

        return $this;
    }

    /**
     * @param $limit
     *
     * @return $this
     */
    public function limit($limit)
    {
        $this->statements['limit'] = $limit;
        return $this;
    }

    /**
     * @param $offset
     *
     * @return $this
     */
    public function offset($offset)
    {
        $this->statements['offset'] = $offset;
        return $this;
    }

    /**
     * @param        $key
     * @param        $operator
     * @param        $value
     * @param string $joiner
     *
     * @return $this
     */
    public function having($key, $operator, $value, $joiner = 'AND')
    {
        $this->statements['havings'][] = compact('key', 'operator', 'value', 'joiner');
        return $this;
    }

    /**
     * @param        $key
     * @param        $operator
     * @param        $value
     *
     * @return $this
     */
    public function orHaving($key, $operator, $value)
    {
        return $this->having($key, $operator, $value, 'OR');
    }

    /**
     * Add a raw query
     *
     * @param $value
     * @param $bindings
     *
     * @return mixed
     */
    public function raw($value, $bindings = array())
    {
        return new Raw($value, $bindings);
    }

    /**
     * @param string $type
     * @param array  $dataToBePassed
     *
     * @return array
     * @throws \PDOException
     */
    public function getQuery($type = 'select', $dataToBePassed = array())
    {
        $type = strtolower($type);
        $allowedTypes = array('select', 'insert', 'replace', 'delete', 'update');
        if (!in_array($type, $allowedTypes)) {
            throw new Exception($type . ' is not a known type.', 502);
        }

        $strict = isset($this->statements['strict']) && $this->statements['strict'] == false ? false : true;
        if($strict == true) {
            if(($type == 'update' || $type == 'delete') && !isset($this->statements['wheres'])) {
                throw new Exception($type . ' is not allow without where.', 505);
            }
            if(!isset($this->statements['limit'])) {
                $this->statements['limit'] = 2000;
            }
        }


        $queryArr = $this->adapterInstance->$type($this->statements, $dataToBePassed);
        return $queryArr;
    }

    /**
     * Get all rows
     *
     * @return \stdClass|null
     */
    public function get()
    {
        $query = $this->getQuery('select');
        $result = $this->connection->read($query['sql'], $query['bindings']);
        $this->resetStatement();
        return $result;
    }

    /**
     * Get first row
     *
     * @return \stdClass|null
     */
    public function first()
    {
        $this->limit(1);
        $result = $this->get();
        return empty($result) ? null : $result[0];
    }

    /**
     * @param        $value
     * @param string $fieldName
     *
     * @return null|\stdClass
     */
    public function findAll($fieldName, $value)
    {
        $this->where($fieldName, '=', $value);
        return $this->get();
    }

    /**
     * @param        $value
     * @param string $fieldName
     *
     * @return null|\stdClass
     */
    public function find($value, $fieldName = 'id')
    {
        $this->where($fieldName, '=', $value);
        return $this->first();
    }

    /**
     * Get count of rows
     *
     * @return int
     */
    public function count()
    {
        unset($this->statements['orderBys']);
        unset($this->statements['limit']);
        unset($this->statements['offset']);

        $count = $this->aggregate('count');

        return $count;
    }

    /**
     * @param $type
     *
     * @return int
     */
    protected function aggregate($type)
    {
        // Get the current selects
        $mainSelects = isset($this->statements['selects']) ? $this->statements['selects'] : null;
        // Replace select with a scalar value like `count`
        $this->statements['selects'] = array($this->raw($type . '(1) as `'.$type.'`'));
        $this->strict(false);
        $row = $this->get();

        // Set the select as it was
        if ($mainSelects) {
            $this->statements['selects'] = $mainSelects;
        } else {
            unset($this->statements['selects']);
        }

        return isset($row[0][$type]) ? (int) $row[0][$type] : 0;
    }

    /***
     * @return int
     */
    public function getInsertId()
    {
        return $this->connection->getInsertId();
    }

    /**
     * @param $data
     *
     * @return array|string
     */
    private function doInsert($data, $type)
    {
        // If first value is not an array
        // Its not a batch insert
        if (!is_array(current($data))) {
            $query = $this->getQuery($type, $data);
            $rowCount = $this->connection->write($query['sql'], $query['bindings']);
            $return = $rowCount === 1 ? $this->getInsertId() : null;
        } else {
            // Its a batch insert
            $return = array();
            foreach ($data as $key => $subData) {
                if($key > 0 && $key % 200 == 0) {
                    usleep(500);
                }
                $query = $this->getQuery($type, $subData);
                $rowCount = $this->connection->write($query['sql'], $query['bindings']);
                if($rowCount === 1){
                    $return[] = $this->getInsertId();
                }
            }
        }

        $this->resetStatement();

        return $return;
    }

    /**
     * @param $data
     *
     * @return array|string
     */
    public function insert($data)
    {
        return $this->doInsert($data, 'insert');
    }

    /**
     * @param $data
     *
     * @return array|string
     */
    public function replace($data)
    {
        return $this->doInsert($data, 'replace');
    }

    /**
     * @param $data
     *
     * @return int
     */
    public function update($data)
    {
        $query = $this->getQuery('update', $data);
        $rowCount = $this->connection->write($query['sql'], $query['bindings']);
        $this->resetStatement();
        return $rowCount;
    }

    /**
     * @param $data
     *
     * @return array|string
     */
    public function updateOrInsert($data)
    {
        if ($this->first()) {
            return $this->update($data);
        } else {
            return $this->insert($data);
        }
    }

    /**
     * @return int
     */
    public function delete()
    {
        $query = $this->getQuery('delete');
        $rowCount = $this->connection->write($query['sql'], $query['bindings']);
        $this->resetStatement();
        return $rowCount;
    }

    /**
     * @param $strict
     * @return $this
     */
    public function strict($strict)
    {
        $this->statements['strict'] = $strict;
        return $this;
    }
}