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

    public function key()
    {
        return $this->table->alter("DROP KEY {$this->index}");
    }

    public function index()
    {
        return $this->table->alter("DROP INDEX {$this->index}");
    }

    public function unique()
    {
        return $this->table->alter("DROP INDEX {$this->index}");
    }

    public function primary()
    {
        return $this->table->alter("DROP PRIMARY KEY");
    }
}