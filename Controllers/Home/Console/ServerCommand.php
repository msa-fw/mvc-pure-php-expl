<?php

namespace Controllers\Home\Console;

class ServerCommand
{
    protected $command;
    protected $params = [];

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function exec($host = '127.0.0.1:8080')
    {
        shell_exec(PHP_BINARY . " -S $host " . ROOT . "/server.php");
        return true;
    }
}