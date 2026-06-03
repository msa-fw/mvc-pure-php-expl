<?php

namespace System\Core\Database;

class Result
{
    protected $statement;
    protected $connection;

    public function __construct(\PDO $connection, \PDOStatement $statement)
    {
        $this->connection = $connection;
        $this->statement = $statement;
    }

    public function statement()
    {
        return $this->statement;
    }

    public function first($object = false)
    {
        $style = $object ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC;
        return $this->statement->fetch($style);
    }

    public function all($object = false)
    {
        $style = $object ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC;
        return $this->statement->fetchAll($style);
    }

    public function rows()
    {
        return $this->statement->rowCount();
    }

    public function id()
    {
        return $this->connection->lastInsertId();
    }
}