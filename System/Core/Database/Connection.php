<?php

namespace System\Core\Database;

class Connection
{
    protected $connection;

    public function __construct(array $config)
    {
        $connection = "{$config['driver']}:host={$config['host']}";
        if($config['base']){
            $connection .= ";dbname={$config['base']}";
        }
        if($config['socket']){
            $connection .= ";unix_socket={$config['socket']}";
        }
        if($config['charset']){
            $connection .= ";charset={$config['charset']}";
        }
        if($config['collate']){
            $connection .= ";collate={$config['collate']}";
        }

        $this->connection = new \PDO($connection, $config['user'], $config['pass']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        if($config['base']){
            $this->connection->exec("USE {$config['base']}");
        }

        $query = "SET ";
        $query .= "NAMES {$config['charset']}, \n";
        $query .= "time_zone = '" . date('P') . "', \n";
        $query .= "lc_messages = '{$config['locale']}', \n";
        $query .= "sql_mode='" . implode(',', $config['databaseMode']) . "', \n";
        $query .= "default_storage_engine = {$config['engine']}, \n";
        $query .= "default_tmp_storage_engine = {$config['engine']};";

        $this->connection->exec($query);
    }

    public function __destruct()
    {
        if($this->connection){
            $this->connection = null;
        }
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

        $statement = $this->connection->prepare($query);
        foreach($sorted as $index => $value){
            $statement->bindValue($index+1, $value, $this->detectBindingType($value));
        }

        $statement->execute();
        return new Result($this->connection, $statement);
    }

    public function pdo()
    {
        return $this->connection;
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