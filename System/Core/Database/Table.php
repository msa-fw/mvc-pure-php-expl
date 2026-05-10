<?php

namespace System\Core\Database;

use System\Core\Database\Table\Index;
use System\Core\Database\Table\Column;
use System\Core\Database\Table\Schema;

class Table
{
    protected $database;
    protected $table;
    protected $config = [];
    protected $connection;

    public function __construct($database, $table, array $config, Connection $connection)
    {
        $this->database = $database;
        $this->table = $table;
        $this->config = $config;
        $this->connection = $connection;
    }

    /**
     * @param $condition
     * @return self
     */
    public function alter($condition)
    {
        $query = "ALTER TABLE `{$this->database}`.`{$this->table}` {$condition}";
        $this->connection->execute($query)->result();
        return $this;
    }

    /**
     * @param callable $function
     * @param null $engine
     * @param null $charset
     * @param null $collate
     * @return self
     */
    public function add(callable $function, $engine = null, $charset = null, $collate = null)
    {
        $engine = $engine ?: $this->config['engine'];
        $charset = $charset ?: $this->config['charset'];
        $collate = $collate ?: $this->config['collate'];

        $query = "CREATE TABLE IF NOT EXISTS `{$this->database}`.`{$this->table}` (" . PHP_EOL;

        $columns = $indexes = [];
        $schema = new Schema($columns, $indexes);
        call_user_func($function, $schema);

        $result = [];
        foreach($columns as $column => $condition){
            $result[] = "`{$column}` {$condition}";
        }
        foreach($indexes as $index => $condition){
            $result[] = $condition;
        }
        $query .= implode("," . PHP_EOL, $result) . PHP_EOL;
        $query .= ") engine = '{$engine}', charset='{$charset}', collate='{$collate}';";

        $this->connection->execute($query)->result();
        return $this;
    }

    /**
     * @return self
     */
    public function drop()
    {
        $query = "DROP TABLE IF EXISTS `{$this->database}`.`{$this->table}`";
        $this->connection->execute($query)->result();
        return $this;
    }

    public function truncate()
    {
        $query = "TRUNCATE TABLE IF EXISTS `{$this->database}`.`{$this->table}`";
        return $this->connection->execute($query)->result();
    }

    public function optimize()
    {
        $query = "OPTIMIZE TABLE IF EXISTS `{$this->database}`.`{$this->table}`";
        return $this->connection->execute($query)->result();
    }

    public function rename($to)
    {
        return $this->alter("RENAME TO {$to}");
    }

    public function columns()
    {
        $query = "SHOW FULL COLUMN FROM `{$this->database}`.`{$this->table}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function indexes()
    {
        $query = "SHOW INDEXES FROM `{$this->database}`.`{$this->table}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function column($column)
    {
        return new Column($column, $this);
    }

    public function index($index)
    {
        return new Index($index, $this);
    }
}