<?php

namespace System\Core\Database\Table\Index;

use System\Core\Database\Table;

class Add
{
    protected $index;
    protected $table;

    public function __construct($index, Table $table)
    {
        $this->index = $index;
        $this->table = $table;
    }

    public function key(...$columns)
    {
        return $this->table->alter("ADD KEY {$this->index}" . $this->createColumnsString(...$columns));
    }

    public function index(...$columns)
    {
        return $this->table->alter("ADD INDEX {$this->index}" . $this->createColumnsString(...$columns));
    }

    public function unique(...$columns)
    {
        return $this->table->alter("ADD UNIQUE INDEX {$this->index}" . $this->createColumnsString(...$columns));
    }

    public function primary()
    {
        return $this->table->alter("ADD PRIMARY KEY ({$this->index})");
    }

    protected function createColumnsString(...$columns)
    {
        if(!$columns){
            $columns = [$this->index];
        }
        return " (" . implode(',', $columns) . ")";
    }
}