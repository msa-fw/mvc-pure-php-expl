<?php

namespace System\Core\Database;

class Base
{
    protected $db;
    protected $connection;

    public function __construct($database, Connection $connection)
    {
        $this->db = $database;
        $this->connection = $connection;
    }

    public function db()
    {
        return $this->db;
    }

    public function connection()
    {
        return $this->connection;
    }

    public function exist()
    {
        foreach($this->connection->databases() as $item){
            if($item['Database'] == $this->db){
                return true;
            }
        }
        return false;
    }

    public function rename($to)
    {
        $tmp = new self($to, $this->connection);
        $tmp->add();

        foreach($this->tables() as $item){
            $key = "Tables_in_{$this->db}";
            $this->table($item[$key])->rename("`{$to}`.`{$item[$key]}`");
        }
        return $this->drop();
    }

    public function select()
    {
        $query = "USE `{$this->db}`";
        return $this->connection->execute($query)->result();
    }

    public function add()
    {
        $query = "CREATE DATABASE IF NOT EXISTS `{$this->db}`";
        return $this->connection->execute($query)->result();
    }

    public function drop()
    {
        $query = "DROP DATABASE IF EXISTS `{$this->db}`";
        return $this->connection->execute($query)->result();
    }

    public function status()
    {
        $query = "SHOW TABLE STATUS FROM `{$this->db}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function tables()
    {
        $query = "SHOW TABLES FROM `{$this->db}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function table($table)
    {
        return new Table($table, $this);
    }
}