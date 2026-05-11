<?php

namespace System\Core\Database\Table\Index;

class Create
{
    protected $column;
    protected $indexes;

    public function __construct($column, &$indexes)
    {
        $this->column = $column;
        $this->indexes = &$indexes;
    }

    public function key($index = null, ...$columns)
    {
        $this->indexes[] = "KEY " . $this->createIndexString($index, ...$columns);
        return $this;
    }

    public function index($index = null, ...$columns)
    {
        $this->indexes[] = "INDEX " . $this->createIndexString($index, ...$columns);
        return $this;
    }

    public function unique($index = null, ...$columns)
    {
        $this->indexes[] = "UNIQUE KEY " . $this->createIndexString($index, ...$columns);
        return $this;
    }

    public function primary()
    {
        $this->indexes[] = "PRIMARY KEY ({$this->column})";
        return $this;
    }

    protected function createIndexString($index, ...$columns)
    {
        if(!$index){
            $index = $this->column;
            array_unshift($columns, $index);
        }else{
            array_unshift($columns, $this->column);
        }
        $columns = implode(',', $columns);

        return "{$index} ({$columns})";
    }
}