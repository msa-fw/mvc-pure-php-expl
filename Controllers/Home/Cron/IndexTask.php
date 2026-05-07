<?php

namespace Controllers\Home\Cron;

class IndexTask
{
    public function __construct()
    {
    }

    public function exec()
    {
        dbg(__METHOD__);
        sleep(10);
        return true;
    }
}