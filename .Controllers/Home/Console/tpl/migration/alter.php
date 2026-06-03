<?php

use System\Core;

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

    public function example_addColumn()
    {
        $this->connection->database()->table('__table__')->column('simple')->add('varchar(255) null default null');
        return $this;
    }

    public function example_addIndex()
    {
        $this->connection->database()->table('__table__')->index('simple')->add()->index();
        return $this;
    }

    public function example_dropColumn()
    {
        $this->connection->database()->table('__table__')->column('simple')->drop();
        return $this;
    }

    public function example_dropIndex()
    {
        $this->connection->database()->table('__table__')->index('simple')->drop()->index();
        return $this;
    }
}