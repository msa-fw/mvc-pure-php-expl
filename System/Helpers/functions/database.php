<?php

namespace database;

use System\Core;
use System\Core\Database\Statement;
use System\Core\Database\Expression;

function raw($sql)
{
    return new Expression($sql);
}

function now()
{
    return raw('NOW()');
}

function quote($value, $connection = 'default')
{
    return Core::Database()->connection($connection)
        ->pdo()->quote($value);
}

function compress($raw, $connection = 'default')
{
    if(is_array($raw) || is_object($raw)){
        $raw = json_encode($raw);
    }
    $query = quote($raw, $connection);
    return raw("COMPRESS($query)");
}

function decompress(...$columns)
{
    $result = [];
    foreach($columns as $column){
        $result[] = "UNCOMPRESS($column) AS $column";
    }
    return implode(', ', $result);
}

function statement2key(Statement $statement)
{
    $query[] = $statement->query();
    if($bindings = $statement->bindings()){
        $query[] = implode(',', $bindings);
    }
    return implode(':', $query);
}