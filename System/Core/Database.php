<?php

namespace System\Core;

use System\Core;
use System\Core\Database\Connection;

class Database
{
    protected $config;

    protected $connections = [];

    public function __construct()
    {
        $this->config = Core::Config();
    }

    /**
     * @param string $connection
     * @return Connection
     * @throws \Exception
     */
    public function connection($connection = 'default')
    {
        if($config = $this->config->database($connection)->read([])){
            if(!isset($this->connections[$connection])){
                return $this->new($connection, $config);
            }
            return $this->connections[$connection];
        }
        throw new \Exception("Undefined config key `{$connection}`");
    }

    /**
     * @param $connection
     * @param array $config
     * @return Connection
     */
    public function new($connection, array $config)
    {
        $this->connections[$connection] = new Connection($config);
        return $this->connections[$connection];
    }

    public function drop($connection)
    {
        if(isset($this->connections[$connection])){
            unset($this->connections[$connection]);
        }
        return $this;
    }
}