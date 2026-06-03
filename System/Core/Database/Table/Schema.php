<?php

namespace System\Core\Database\Table;

use System\Core\Database\Table\Index\Create;

/**
 * Class Schema
 * @package System\Core\Database\Table
 *
 * @method Create int($column, $length, $condition)
 * @method Create tinyint($column, $length, $condition)
 * @method Create smallint($column, $length, $condition)
 * @method Create mediumint($column, $length, $condition)
 * @method Create bigint($column, $length, $condition)
 *
 * @method Create char($column, $length, $condition)
 * @method Create binary($column, $length, $condition)
 * @method Create varchar($column, $length, $condition)
 * @method Create varbinary($column, $length, $condition)
 * @method Create decimal($column, $length, $condition)
 *
 * @method Create float($column, $length, $condition)
 * @method Create double($column, $length, $condition)
 * @method Create real($column, $length, $condition)
 * @method Create bit($column, $length, $condition)
 * @method Create serial($column, $length, $condition)
 *
 * @method Create point($column, $length, $condition)
 * @method Create linestring($column, $length, $condition)
 * @method Create polygon($column, $length, $condition)
 *
 * @method Create multipoint($column, $length, $condition)
 * @method Create multilinestring($column, $length, $condition)
 * @method Create multipolygon($column, $length, $condition)
 *
 * @method Create json($column, $length, $condition)
 *
 * @method Create geometry($column, $length, $condition)
 * @method Create geometrycollection($column, $length, $condition)
 *
 * @method Create enum($column, $condition)
 * @method Create set($column, $condition)
 *
 * @method Create bool($column, $condition)
 * @method Create boolean($column, $condition)
 *
 * @method Create text($column, $length, $condition)
 * @method Create tinytext($column, $condition)
 * @method Create mediumtext($column, $condition)
 * @method Create longtext($column, $condition)
 *
 * @method Create blob($column, $length, $condition)
 * @method Create tinyblob($column, $condition)
 * @method Create mediumblob($column, $condition)
 * @method Create longblob($column, $condition)
 *
 * @method Create date($column, $condition)
 * @method Create datetime($column, $condition)
 * @method Create timestamp($column, $condition)
 * @method Create time($column, $condition)
 * @method Create year($column, $condition)
 */
class Schema
{
    protected $columns = [];
    protected $indexes = [];

    public function __call($name, $arguments)
    {
        $name = strtoupper($name);
        $column = $arguments[0];

        if(isset($arguments[2])){
            $length = "({$arguments[1]})";
            $condition = array_slice($arguments, 2);
        }else{
            $length = '';
            $condition = array_slice($arguments, 1);
        }
        return $this->column($column, "{$name}{$length} " . implode(' ', $condition));
    }

    public function __construct(&$columns, &$indexes)
    {
        $this->columns = &$columns;
        $this->indexes = &$indexes;
    }

    public function column($column, $condition)
    {
        $this->columns[$column] = $condition;
        return new Create($column, $this->indexes);
    }
}