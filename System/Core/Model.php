<?php

namespace System\Core;

use System\Core;
use System\Core\Database\Builder;
use System\Helpers\Classes\Search;

class Model
{
    protected $table;
    protected $cache;
    protected $connection;

    public static function __callStatic($name, $arguments)
    {
        $model = new static();
        return $model->build($name);
    }

    public function __construct()
    {
        $this->cache = Core::Cache();
        $this->connection = Core::Database()->connection();
    }

    public function build($table = null)
    {
        return new Builder($table ?: $this->table, $this->connection);
    }

    public function collect($data)
    {
        return new Search($data);
    }
}