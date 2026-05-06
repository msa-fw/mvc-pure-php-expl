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

    public function first()
    {
        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function all()
    {
        return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
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