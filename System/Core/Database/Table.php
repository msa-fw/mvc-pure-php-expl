<?php

namespace System\Core\Database;

use System\Core\Database\Table\Index;
use System\Core\Database\Table\Column;
use System\Core\Database\Table\Schema;

class Table
{
    protected $table;
    protected $base;

    protected $db;
    protected $connection;

    public function __construct($table, Base $base)
    {
        $this->table = $table;
        $this->base = $base;

        $this->db = $this->base->db();
        $this->connection = $this->base->connection();
    }

    public function exist()
    {
        foreach($this->base->tables() as $item){
            if($item["Tables_in_{$this->db}"] == $this->table){
                return true;
            }
        }
        return false;
    }

    /**
     * @param $condition
     * @return self
     */
    public function alter($condition)
    {
        $query = "ALTER TABLE `{$this->db}`.`{$this->table}` {$condition}";
        $this->connection->execute($query)->result();
        return $this;
    }

    /**
     * @param callable $function(\System\Core\Database\Table\Schema $schema)
     * @param null $engine
     * @param null $charset
     * @param null $collate
     * @return self
     */
    public function add(callable $function, $engine = null, $charset = null, $collate = null)
    {
        $engine = $engine ?: $this->base->connection()->config('engine');
        $charset = $charset ?: $this->base->connection()->config('charset');
        $collate = $collate ?: $this->base->connection()->config('collate');

        $query = "CREATE TABLE IF NOT EXISTS `{$this->db}`.`{$this->table}` (" . PHP_EOL;

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
        $query = "DROP TABLE IF EXISTS `{$this->db}`.`{$this->table}`";
        $this->connection->execute($query)->result();
        return $this;
    }

    /**
     * @return self
     */
    public function truncate()
    {
        $query = "TRUNCATE TABLE IF EXISTS `{$this->db}`.`{$this->table}`";
        $this->connection->execute($query)->result();
        return $this;
    }

    /**
     * @return self
     */
    public function optimize()
    {
        $query = "OPTIMIZE TABLE IF EXISTS `{$this->db}`.`{$this->table}`";
        $this->connection->execute($query)->result();
        return $this;
    }

    public function rename($to)
    {
        return $this->alter("RENAME TO {$to}");
    }

    public function columns()
    {
        $query = "SHOW FULL COLUMNS FROM `{$this->db}`.`{$this->table}`";
        return $this->connection->execute($query)->result()->all();
    }

    public function indexes()
    {
        $query = "SHOW INDEXES FROM `{$this->db}`.`{$this->table}`";
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