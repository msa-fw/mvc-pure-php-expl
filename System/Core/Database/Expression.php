<?php

namespace System\Core\Database;

class Expression
{
    protected $query;

    public function __toString()
    {
        return $this->query;
    }

    public function __construct($query)
    {
        $this->query = $query;
    }
}