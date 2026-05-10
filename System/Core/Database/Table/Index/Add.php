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

    public function key($condition)
    {
        return $this->table->alter("ADD KEY {$this->index} {$condition}");
    }

    public function index($condition)
    {
        return $this->table->alter("ADD INDEX {$this->index} {$condition}");
    }

    public function unique($condition)
    {
        return $this->table->alter("ADD UNIQUE INDEX {$this->index} {$condition}");
    }

    public function primary($condition)
    {
        return $this->table->alter("ADD PRIMARY KEY ({$this->index}) {$condition}");
    }
}