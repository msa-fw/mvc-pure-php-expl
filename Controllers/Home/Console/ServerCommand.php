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

    /**
     * @param string $host
     * @help cli.help.runDeveloperServer
     * @help cli.help.runDeveloperServer1
     * @return bool
     */
    public function exec($host = '127.0.0.1:8080')
    {
        shell_exec(PHP_BINARY . " -S $host " . ROOT . "/server.php");
        return true;
    }
}