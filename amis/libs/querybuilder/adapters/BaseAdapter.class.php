<?php
namespace Libs\QueryBuilder\Adapters;

use Libs\QueryBuilder\Exception;
use Libs\QueryBuilder\Connection;
use Libs\QueryBuilder\Raw;

abstract class BaseAdapter {

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $sanitizer = '';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Build select query string and bindings
     *
     * @param $statements
     *
     * @throws \PDOException
     * @return array
     */
    public function select($statements)
    {
        if (!array_key_exists('table', $statements)) {
            throw new Exception('No table specified.', 503);
        } elseif (!array_key_exists('selects', $statements)) {
            $statements['selects'][] = '*';
        }

        // From
        $table = $this->arrayStr($statements['table'], ', ');
        // Select
        $selects = $this->arrayStr($statements['selects'], ', ');


        // Wheres
        list($whereCriteria, $whereBindings) = $this->buildCriteriaWithType($statements, 'wheres', 'WHERE');
        // Group bys
        $groupBys = '';
        if (isset($statements['groupBys']) && $groupBys = $this->arrayStr($statements['groupBys'], ', ')) {
            $groupBys = 'GROUP BY ' . $groupBys;
        }

        // Order bys
        $orderBys = '';
        if (isset($statements['orderBys']) && is_array($statements['orderBys'])) {
            foreach ($statements['orderBys'] as $orderBy) {
                $orderBys .= $this->wrapSanitizer($orderBy['field']) . ' ' . $orderBy['type'] . ', ';
            }

            if ($orderBys = trim($orderBys, ', ')) {
                $orderBys = 'ORDER BY ' . $orderBys;
            }
        }

        // Limit and offset
        $limit = isset($statements['limit']) ? 'LIMIT ' . $statements['limit'] : '';
        $offset = isset($statements['offset']) ? 'OFFSET ' . $statements['offset'] : '';

        // Having
        list($havingCriteria, $havingBindings) = $this->buildCriteriaWithType($statements, 'havings', 'HAVING');

        $sqlArray = array(
            'SELECT' . (isset($statements['distinct']) ? ' DISTINCT' : ''),
            $selects,
            'FROM',
            $table,
            $whereCriteria,
            $groupBys,
            $havingCriteria,
            $orderBys,
            $limit,
            $offset
        );

        $sql = $this->concatenateQuery($sqlArray);

        $bindings = array_merge(
            $whereBindings,
            $havingBindings
        );

        return compact('sql', 'bindings');
    }

    /**
     * Build just criteria part of the query
     *
     * @param      $statements
     * @param bool $bindValues
     *
     * @return array
     */
    public function criteriaOnly($statements, $bindValues = true)
    {
        $sql = $bindings = array();
        if (!isset($statements['criteria'])) {
            return compact('sql', 'bindings');
        }

        list($sql, $bindings) = $this->buildCriteria($statements['criteria'], $bindValues);

        return compact('sql', 'bindings');
    }

    /**
     * Build a generic insert/ignore/replace query
     *
     * @param       $statements
     * @param array $data
     *
     * @return array
     * @throws \PDOException
     */
    private function doInsert($statements, array $data, $type)
    {
        if (!isset($statements['table'])) {
            throw new Exception('No table specified.', 503);
        } elseif (count($data) < 1) {
            throw new Exception('No data given.', 504);
        }

        $table = end($statements['table']);

        $bindings = $keys = $values = array();

        foreach ($data as $key => $value) {
            $keys[] = $key;
            if ($value instanceof Raw) {
                $values[] = (string) $value;
            } else {
                $placeholder = is_int($value) ? ':'.$key : ':_'.$key;
                $values[] = $placeholder;
                $bindings[trim($placeholder, ':')] = $value;
            }
        }

        $sqlArray = array(
            $type . ' INTO',
            $this->wrapSanitizer($table),
            '(' . $this->arrayStr($keys, ',') . ')',
            'VALUES',
            '(' . $this->arrayStr($values, ',', false) . ')',
        );

        $sql = $this->concatenateQuery($sqlArray, ' ', false);

        return compact('sql', 'bindings');
    }

    /**
     * Build Insert query
     *
     * @param       $statements
     * @param array $data
     *
     * @return array
     * @throws \PDOException
     */
    public function insert($statements, array $data)
    {
        return $this->doInsert($statements, $data, 'INSERT');
    }

    /**
     * Build Insert Ignore query
     *
     * @param       $statements
     * @param array $data
     *
     * @return array
     * @throws \PDOException
     */
    public function replace($statements, array $data)
    {
        return $this->doInsert($statements, $data, 'REPLACE');
    }

    /**
     * Build fields assignment part of SET ... or ON DUBLICATE KEY UPDATE ... statements
     *
     * @param array $data
     *
     * @return array
     */
    private function getUpdateStatement($data)
    {
        $bindings = array();
        $statement = '';

        foreach ($data as $key => $value) {
            if ($value instanceof Raw) {
                $statement .= $this->wrapSanitizer($key) . '=' . $value . ',';
            } else {
                $placeholder = is_int($value) ? ':'.$key : ':_'.$key;
                $placeholder .= 'set';
                $statement .= $this->wrapSanitizer($key) . '='.$placeholder.',';
                $bindings[trim($placeholder, ':')] = $value;
            }
        }

        $statement = trim($statement, ',');
        return array($statement, $bindings);
    }

    /**
     * Build update query
     *
     * @param       $statements
     * @param array $data
     *
     * @return array
     * @throws \PDOException
     */
    public function update($statements, array $data)
    {
        if (!isset($statements['table'])) {
            throw new Exception('No table specified.', 503);
        } elseif (count($data) < 1) {
            throw new Exception('No data given.', 504);
        }

        $table = end($statements['table']);

        // Update statement
        list($updateStatement, $bindings) = $this->getUpdateStatement($data);

        // Wheres
        list($whereCriteria, $whereBindings) = $this->buildCriteriaWithType($statements, 'wheres', 'WHERE');

        // Limit
        $limit = isset($statements['limit']) ? 'LIMIT ' . $statements['limit'] : '';

        $sqlArray = array(
            'UPDATE',
            $this->wrapSanitizer($table),
            'SET ' . $updateStatement,
            $whereCriteria,
            $limit
        );

        $sql = $this->concatenateQuery($sqlArray, ' ', false);

        $bindings = array_merge($bindings, $whereBindings);
        return compact('sql', 'bindings');
    }

    /**
     * Build delete query
     *
     * @param $statements
     *
     * @return array
     * @throws \PDOException
     */
    public function delete($statements)
    {
        if (!isset($statements['table'])) {
            throw new Exception('No table specified.', 503);
        }

        $table = end($statements['table']);

        // Wheres
        list($whereCriteria, $whereBindings) = $this->buildCriteriaWithType($statements, 'wheres', 'WHERE');

        // Limit
        $limit = isset($statements['limit']) ? 'LIMIT ' . $statements['limit'] : '';

        $sqlArray = array('DELETE FROM', $this->wrapSanitizer($table), $whereCriteria, $limit);
        $sql = $this->concatenateQuery($sqlArray, ' ', false);
        $bindings = $whereBindings;

        return compact('sql', 'bindings');
    }

    /**
     * Array concatenating method, like implode.
     * But it does wrap sanitizer and trims last glue
     *
     * @param array $pieces
     * @param       $glue
     * @param bool  $wrapSanitizer
     *
     * @return string
     */
    protected function arrayStr(array $pieces, $glue, $wrapSanitizer = true)
    {
        $str = '';
        foreach ($pieces as $key => $piece) {
            if ($wrapSanitizer) {
                $piece = $this->wrapSanitizer($piece);
            }

            if (!is_int($key)) {
                $piece = ($wrapSanitizer ? $this->wrapSanitizer($key) : $key) . ' AS ' . $piece;
            }

            $str .= $piece . $glue;
        }

        return trim($str, $glue);
    }

    /**
     * Join different part of queries with a space.
     *
     * @param array $pieces
     *
     * @return string
     */
    protected function concatenateQuery(array $pieces)
    {
        $str = '';
        foreach ($pieces as $piece) {
            $str = trim($str) . ' ' . trim($piece);
        }
        return trim($str);
    }

    /**
     * Build generic criteria string and bindings from statements, like "a = b and c = ?"
     *
     * @param      $statements
     * @param bool $bindValues
     *
     * @return array
     */
    protected function buildCriteria($statements, $bindValues = true)
    {
        $criteria = '';
        $bindings = array();
        $valuePlaceholderArr = array();
        foreach ($statements as $statement) {
            $key = $this->wrapSanitizer($statement['key']);
            $value = $statement['value'];
            $count = 0;

            if (is_array($value)) {
                // where_in or between like query
                $criteria .= $statement['joiner'] . ' ' . $key . ' ' . $statement['operator'];

                switch ($statement['operator']) {
                    case 'BETWEEN':
                        $valuePlaceholderLow = is_int($statement['value'][0]) ? ":{$statement['key']}" : ":_{$statement['key']}";
                        $valuePlaceholderLow .= 'low';
                        while(in_array($valuePlaceholderLow, $valuePlaceholderArr)) {
                            $valuePlaceholderLow = is_int($statement['value'][0]) ? ":{$statement['key']}" : ":_{$statement['key']}";
                            $valuePlaceholderLow .= 'low'.$count;
                            $count++;
                        }
                        $valuePlaceholderArr[] = $valuePlaceholderLow;
                        $bindings[trim($valuePlaceholderLow, ':')] = $statement['value'][0];

                        $valuePlaceholderHigh = is_int($statement['value'][1]) ? ":{$statement['key']}" : ":_{$statement['key']}";
                        $valuePlaceholderHigh .= 'high';
                        while(in_array($valuePlaceholderHigh, $valuePlaceholderArr)) {
                            $valuePlaceholderHigh = is_int($statement['value'][1]) ? ":{$statement['key']}" : ":_{$statement['key']}";
                            $valuePlaceholderHigh .= 'high'.$count;
                            $count++;
                        }
                        $valuePlaceholderArr[] = $valuePlaceholderHigh;
                        $bindings[trim($valuePlaceholderHigh, ':')] = $statement['value'][1];

                        $criteria .= " {$valuePlaceholderLow} AND {$valuePlaceholderHigh} ";
                        break;
                    default:
                        foreach ($statement['value'] as $subValue) {
                            $valuePlaceholder = is_int($subValue) ? ":{$statement['key']}" : ":_{$statement['key']}";
                            $valuePlaceholder .= $count;
                            $valuePlaceholderArr[] = $valuePlaceholder;
                            $bindings[trim($valuePlaceholder, ':')] = $subValue;
                            $count++;
                        }

                        $valuePlaceholder = implode(', ', $valuePlaceholderArr);
                        $criteria .= ' (' . $valuePlaceholder . ') ';
                        break;
                }
            } else {
                // Usual where like criteria

                if (!$bindValues) {
                    // Specially for joins

                    // We are not binding values, lets sanitize then
                    $value = $this->wrapSanitizer($value);
                    $criteria .= $statement['joiner'] . ' ' . $key . ' ' . $statement['operator'] . ' ' . $value . ' ';
                } elseif ($statement['key'] instanceof Raw) {
                    $criteria .= $statement['joiner'] . ' ' . $key . ' ';
                    $bindings = array_merge($bindings, $statement['key']->getBindings());
                } else {
                    // For wheres

                    $valuePlaceholder = is_int($value) ? ":{$statement['key']}" : ":_{$statement['key']}";
                    while(in_array($valuePlaceholder, $valuePlaceholderArr)) {
                        $valuePlaceholder =  is_int($value) ? ":{$statement['key']}" : ":_{$statement['key']}";
                        $valuePlaceholder .= $count;
                        $count++;
                    }
                    $valuePlaceholderArr[] = $valuePlaceholder;
                    $bindings[trim($valuePlaceholder, ':')] = $value;
                    $criteria .= $statement['joiner'] . ' ' . $key . ' ' . $statement['operator'] . ' '
                        . $valuePlaceholder . ' ';
                }
            }
        }

        // Clear all white spaces, and, or from beginning and white spaces from ending
        $criteria = preg_replace('/^(\s?AND ?|\s?OR ?)|\s$/i','', $criteria);

        return array($criteria, $bindings);
    }

    /**
     * Build criteria string and binding with various types added, like WHERE and Having
     *
     * @param      $statements
     * @param      $key
     * @param      $type
     * @param bool $bindValues
     *
     * @return array
     */
    protected function buildCriteriaWithType($statements, $key, $type, $bindValues = true)
    {
        $criteria = '';
        $bindings = array();

        if (isset($statements[$key])) {
            // Get the generic/adapter agnostic criteria string from parent
            list($criteria, $bindings) = $this->buildCriteria($statements[$key], $bindValues);

            if ($criteria) {
                $criteria = $type . ' ' . $criteria;
            }
        }

        return array($criteria, $bindings);
    }

    /**
     * Wrap values with adapter's sanitizer like, '`'
     *
     * @param $value
     *
     * @return string
     */
    public function wrapSanitizer($value)
    {
        // Its a raw query, just cast as string, object has __toString()
        if ($value instanceof Raw) {
            return (string)$value;
        } elseif ($value instanceof \Closure) {
            return $value;
        }

        $value = trim($value);
        return $value == '*' ? $value : $this->sanitizer . $value . $this->sanitizer;
    }
    
}