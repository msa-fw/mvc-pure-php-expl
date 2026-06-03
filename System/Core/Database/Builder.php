<?php

namespace System\Core\Database;

class Builder
{
    protected $table;

    protected $condition;
    protected $bindings = [];

    protected $limit = 30;
    protected $offset = 0;
    protected $order = [];

    protected $connection;

    public function __construct($table, Connection $connection)
    {
        $this->table = $table;
        $this->connection = $connection;
    }

    public function where($condition, array $bindings = [])
    {
        $this->condition = $condition;
        $this->bindings = $bindings;
        return $this;
    }

    public function order($column, $sorting = 'ASC')
    {
        $this->order[] = [
            'column' => $column,
            'sorting' => $sorting,
        ];
        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    public function insert(array $insert, array $update = [])
    {
        $query = [
            "INSERT INTO {$this->table}"
        ];

        $fields = $values = [];
        foreach($insert as $field => $value){
            $fields[] = $field;
            if($value instanceof Expression){
                $values[] = $value;
            }else{
                $key = "%insertKey_$field%";
                $values[] = $key;
                $this->bindings[$key] = $value;
            }
        }

        $query[] = "(" . implode(', ', $fields) . ")";
        $query[] = "VALUES(". implode(', ', $values) .")";

        if($update){
            $query[] = "ON DUPLICATE KEY UPDATE";

            $updates = [];
            foreach($update as $field => $value){
                if($value instanceof Expression){
                    $updates[] = "$field = $value";
                }else{
                    $key = "%updateKey_$field%";
                    $updates[] = "$field = $key";
                    $this->bindings[$key] = $value;
                }
            }
            $query[] = implode(', ', $updates);
        }

        $query = implode("\n", $query);
        return $this->connection->execute($query, $this->bindings);
    }

    public function update(array $update)
    {
        $query = [
            "UPDATE {$this->table} SET"
        ];

        $updates = [];
        foreach($update as $field => $value){
            if($value instanceof Expression){
                $updates[] = "$field = $value";
            }else{
                $key = "%updateKey_$field%";
                $updates[] = "$field = $key";
                $this->bindings[$key] = $value;
            }
        }
        $query[] = implode(', ', $updates);

        if($this->condition){
            $query[] = "WHERE {$this->condition}";
        }

        if($this->order){
            $order = [];
            foreach($this->order as $params){
                $order[] = "{$params['column']} {$params['sorting']}";
            }
            $query[] = "ORDER BY " . implode(', ', $order);
        }

        if($this->limit){
            $query[] = "LIMIT {$this->limit}";
        }

        $query = implode("\n", $query);
        return $this->connection->execute($query, $this->bindings);
    }

    public function delete()
    {
        $query = [
            "DELETE FROM {$this->table}"
        ];

        if($this->condition){
            $query[] = "WHERE {$this->condition}";
        }

        if($this->order){
            $order = [];
            foreach($this->order as $params){
                $order[] = "{$params['column']} {$params['sorting']}";
            }
            $query[] = "ORDER BY " . implode(', ', $order);
        }

        if($this->limit){
            $query[] = "LIMIT {$this->limit}";
        }

        if($this->offset){
            $query[] = "OFFSET {$this->offset}";
        }

        $query = implode("\n", $query);
        return $this->connection->execute($query, $this->bindings);
    }

    public function select(...$columns)
    {
        $columns = $columns ? implode(', ', $columns) : '*';

        $query = [
            "SELECT $columns FROM {$this->table}"
        ];

        if($this->condition){
            $query[] = "WHERE {$this->condition}";
        }

        if($this->order){
            $order = [];
            foreach($this->order as $params){
                $order[] = "{$params['column']} {$params['sorting']}";
            }
            $query[] = "ORDER BY " . implode(', ', $order);
        }

        if($this->limit){
            $query[] = "LIMIT {$this->limit}";
        }

        if($this->offset){
            $query[] = "OFFSET {$this->offset}";
        }

        $query = implode("\n", $query);
        return $this->connection->execute($query, $this->bindings);
    }
}