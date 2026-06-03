<?php

namespace System\Core\Database\Table;

use System\Core\Database\Table;

class Column
{
    protected $column;
    protected $table;

    public function __construct($column, Table $table)
    {
        $this->column = $column;
        $this->table = $table;
    }

    public function add($condition)
    {
        return $this->table->alter("ADD COLUMN `{$this->column}` {$condition}");
    }

    public function drop()
    {
        return $this->table->alter("DROP COLUMN `{$this->column}`");
    }

    public function rename($to)
    {
        return $this->table->alter("RENAME COLUMN `{$this->column}` TO {$to}");
    }

    public function change($condition)
    {
        return $this->table->alter("CHANGE COLUMN `{$this->column}` {$condition}");
    }

    public function modify($condition)
    {
        return $this->table->alter("MODIFY COLUMN `{$this->column}` {$condition}");
    }
}