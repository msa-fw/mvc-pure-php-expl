<?php

namespace System\Core\Database;

class Base
{
    protected $database;
    protected $config = [];
    protected $connection;

    public function __construct($database, array $config, Connection $connection)
    {
        $this->database = $database;
        $this->config = $config;
        $this->connection = $connection;
    }

    public function select()
    {
        $query = "USE `{$this->database}`";
        return $this->connection->execute($query)->result();
    }

    public function add()
    {
        $query = "CREATE DATABASE IF NOT EXISTS `{$this->database}`";
        return $this->connection->execute($query)->result();
    }

    public function drop()
    {
        $query = "DROP DATABASE IF EXISTS `{$this->database}`";
        return $this->connection->execute($query)->result();
    }

    public function status()
    {
        $query = "SHOW TABLE STATUS FROM `{$this->database}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function tables()
    {
        $query = "SHOW TABLES FROM `{$this->database}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function rename($to)
    {
        $tmp = new self($to, $this->config, $this->connection);
        $tmp->add();

        foreach($this->tables() as $item){
            $key = "Tables_in_{$this->database}";
            $this->table($item[$key])->rename("`{$to}`.`{$item[$key]}`");
        }
        return $this->drop();
    }

    public function table($table)
    {
        return new Table($this->database, $table, $this->config, $this->connection);
    }
}