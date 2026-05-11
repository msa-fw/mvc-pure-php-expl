<?php

namespace System\Core\Database;

class Connection
{
    protected $config = [];
    protected $connection;

    public function __construct(array $config)
    {
        $this->config = $config;

        $connection = "{$this->config['driver']}:host={$this->config['host']}";
        if($this->config['base']){
            $connection .= ";dbname={$this->config['base']}";
        }
        if($this->config['socket']){
            $connection .= ";unix_socket={$this->config['socket']}";
        }
        if($this->config['charset']){
            $connection .= ";charset={$this->config['charset']}";
        }
        if($this->config['collate']){
            $connection .= ";collate={$this->config['collate']}";
        }

        $this->connection = new \PDO($connection, $this->config['user'], $this->config['pass']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if($this->config['base']){
            $this->database()->select();
        }

        $query = "SET ";
        $query .= "NAMES {$this->config['charset']}, \n";
        $query .= "time_zone = '" . date('P') . "', \n";
        $query .= "lc_messages = '{$this->config['locale']}', \n";
        $query .= "sql_mode='" . implode(',', $this->config['databaseMode']) . "', \n";
        $query .= "default_storage_engine = {$this->config['engine']}, \n";
        $query .= "default_tmp_storage_engine = {$this->config['engine']};";

        $this->execute($query)->result();
    }

    public function __destruct()
    {
        if($this->connection){
            $this->connection = null;
        }
    }

    public function config($key)
    {
        return isset($this->config[$key]) ? $this->config[$key] : null;
    }

    public function execute($query, array $bindings = [])
    {
        $sorted = [];
        $pattern = implode('|', array_keys($bindings));
        $query = preg_replace_callback("#($pattern)#usm", function($matches)use($bindings, &$sorted){
            if(isset($bindings[$matches[1]])){
                $sorted[] = $bindings[$matches[1]];
                return '?';
            }
            return $matches[1];
        }, $query);

        return new Statement($query, $sorted, $this->connection);
    }

    public function pdo()
    {
        return $this->connection;
    }

    public function databases()
    {
        $query = "SHOW DATABASES";
        return $this->execute($query)->result()->all();
    }

    public function database($database = null)
    {
        $database = $database ?: $this->config('base');
        return new Base($database, $this);
    }
}