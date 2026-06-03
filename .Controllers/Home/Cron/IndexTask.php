<?php

namespace Controllers\Home\Cron;

class IndexTask
{
    public function __construct()
    {
    }

    public function exec()
    {
        if(rand(0,1)){
            throw new \Exception("Test error");
        }
        print(__METHOD__ . PHP_EOL);
        sleep(rand(5,10));
        return true;
    }
}