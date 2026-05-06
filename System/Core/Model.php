<?php

namespace System\Core;

use System\Core;
use System\Core\Database\Builder;

class Model
{
    protected $table;

    protected $connection;

    public static function __callStatic($name, $arguments)
    {
        $model = new static();
        return $model->table($name)
            ->build();
    }

    public function __construct()
    {
        $this->connection = Core::Database()->connection();
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function build()
    {
        return new Builder($this->table, $this->connection);
    }
}