<?php

namespace Controllers\__CONTROLLER__\Console;

class __ACTION__Command
{
    protected $command;
    protected $params = [];

    public function __construct($command, array $params)
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function exec()
    {
        return true;
    }
}