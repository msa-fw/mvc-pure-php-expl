<?php

namespace Controllers\Home\Console;

class IndexCommand
{
    public function __construct()
    {
    }

    public function exec($test, $second = true)
    {
        dbg([__METHOD__ => func_get_args()]);
        return true;
    }
}