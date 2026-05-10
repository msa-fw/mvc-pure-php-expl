<?php

namespace System\Core\Database\Table\Index;

use System\Core\Database\Table;

class Drop
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
        return $this->table->alter("DROP KEY {$this->index} {$condition}");
    }

    public function index($condition)
    {
        return $this->table->alter("DROP INDEX {$this->index} {$condition}");
    }

    public function unique($condition)
    {
        return $this->table->alter("DROP INDEX {$this->index} {$condition}");
    }

    public function primary()
    {
        return $this->table->alter("DROP PRIMARY KEY");
    }
}