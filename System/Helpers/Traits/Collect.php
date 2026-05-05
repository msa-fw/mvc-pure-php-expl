<?php

namespace System\Helpers\Traits;

use System\Helpers\Classes\Search;

trait Collect
{
    protected $subject = [];

    public function __call($name, $arguments)
    {
        $collection = new Search($this->subject);
        return $collection->find($name, ...$arguments);
    }
}