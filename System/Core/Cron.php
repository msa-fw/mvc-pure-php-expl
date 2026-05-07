<?php

namespace System\Core;

/**
 * Write `* * * * * php /path/to/cli cron:run` to your system crontab file
 *
 * Class Cron
 * @package System\Core
 */
class Cron
{
    protected $tasks = [];

    public function __construct()
    {
    }

    public function add($class, $method, $frequency = 3600, $timeout = 3600)
    {
        $key = md5($class . $method);
        $this->tasks[$key] = [
            'class' => $class,
            'method' => $method,
            'frequency' => $frequency,
            'timeout' => $timeout,
        ];
    }

    public function getAll()
    {
        return $this->tasks;
    }
}