<?php

namespace Controllers\Home\Widgets;

class SimpleWidget
{
    public function __construct()
    {}

    public function exec()
    {
        return [
            'id' => 'test',
        ];
    }
}