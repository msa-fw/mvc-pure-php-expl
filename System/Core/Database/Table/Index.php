<?php

namespace System\Core\Database\Table;

use System\Core\Database\Table;
use System\Core\Database\Table\Index\Add;
use System\Core\Database\Table\Index\Drop;

class Index
{
    protected $index;
    protected $table;

    public function __construct($index, Table $table)
    {
        $this->index = $index;
        $this->table = $table;
    }

    public function add()
    {
        return new Add($this->index, $this->table);
    }

    public function drop()
    {
        return new Drop($this->index, $this->table);
    }

    public function rename($to)
    {
        return $this->table->alter("RENAME INDEX `{$this->index}` TO {$to}");
    }

    public function alter($condition)
    {
        return $this->table->alter("ALTER INDEX `{$this->index}` {$condition}");
    }
}