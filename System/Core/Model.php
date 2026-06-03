<?php

namespace System\Core;

use System\Core;
use System\Core\Database\Builder;
use System\Helpers\Classes\Search;
use System\Core\Database\Statement;
use function database\statement2key;

class Model
{
    protected $table;
    protected $cache;
    protected $connection;

    public static function __callStatic($name, $arguments)
    {
        return new static($name);
    }

    public function __construct($table)
    {
        $this->table = $table;
        $this->cache = new Cache($this->table);
        $this->connection = Core::Database()->connection();
    }

    public function build()
    {
        return new Builder($this->table, $this->connection);
    }

    public function collect($data)
    {
        return new Search($data);
    }

    public function findOne(Statement $statement, ...$keys)
    {
        return $this->find($statement, function(Statement $statement){
            return $statement->result()->first();
        }, ...$keys);
    }

    public function findAll(Statement $statement, ...$keys)
    {
        return $this->find($statement, function(Statement $statement){
            return $statement->result()->all();
        }, ...$keys);
    }

    public function find(Statement $statement, callable $callback, ...$keys)
    {
        $cache = $this->cache->find(...$keys);
        $query = statement2key($statement);

        if($data = $cache->get($query)){
            return $this->collect($data);
        }

        if($data = call_user_func($callback, $statement)){
            $cache->set($query, $data);
        }
        return $this->collect($data);
    }
}