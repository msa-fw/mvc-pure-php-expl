<?php

namespace System\Core\Database\Table;

class Schema
{
    protected $columns = [];
    protected $indexes = [];

    public function __construct(&$columns, &$indexes)
    {
        $this->columns = &$columns;
        $this->indexes = &$indexes;
    }

    public function column($column, $condition)
    {
        $this->columns[$column] = $condition;
    }

    public function index($index, $condition)
    {
        $this->indexes[$index] = $condition;
    }
}