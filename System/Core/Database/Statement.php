<?php

namespace System\Core\Database;

use System\Core;

class Statement
{
    protected $query;
    protected $bindings = [];
    protected $connection;

    protected $debugger;

    public function __construct($query, array $bindings, \PDO $connection)
    {
        $this->query = $query;
        $this->bindings = $bindings;
        $this->connection = $connection;

        $this->debugger = Core::Debugger();
    }

    public function query()
    {
        return $this->query;
    }

    public function bindings()
    {
        return $this->bindings;
    }

    public function connection()
    {
        return $this->connection;
    }

    public function result()
    {
        $debugger = $this->debugger->database()->start($this->query);

        $statement = $this->connection->prepare($this->query);
        foreach($this->bindings as $index => $value){
            $statement->bindValue($index+1, $value, $this->detectBindingType($value));
        }
        $statement->execute();

        $debugger->end();
        return new Result($this->connection, $statement);
    }

    protected function detectBindingType($binding)
    {
        if(is_int($binding) || is_integer($binding)){
            return \PDO::PARAM_INT;
        }
        if(is_bool($binding)){
            return \PDO::PARAM_BOOL;
        }
        if(is_null($binding)){
            return \PDO::PARAM_NULL;
        }
        return \PDO::PARAM_STR;
    }
}