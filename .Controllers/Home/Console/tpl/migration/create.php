<?php

use System\Core;
use System\Core\Database\Table\Schema;

/**
 * Only public methods will be executed
 * @see \Controllers\Home\Console\DatabaseCommand::migrate()
 * Class __name__
 */
class __name__
{
    protected $connection;

    public function __construct()
    {
        $this->connection = Core::Database()->connection();
    }

    public function drop()
    {
        $this->connection->database()->table('__table__')->drop();
        return $this;
    }

    public function create()
    {
        $this->connection->database()->table('__table__')->add(function(Schema $schema){
            $schema->bigint('id', 128, 'unsigned not null auto_increment')->primary();

            $schema->varchar('name', 250, 'null default null')->unique();
            $schema->longtext('content', 'null default null');

            $schema->timestamp('created', 'not null default current_timestamp')->key();
            $schema->timestamp('updated', 'not null default current_timestamp on update current_timestamp')->key();
            $schema->timestamp('deleted', 'not null default current_timestamp')->key();
        });
        return $this;
    }
}