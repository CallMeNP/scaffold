<?php


namespace App\Core;


use Envms\FluentPDO\Query;

class DB extends Query
{
    public function __construct($dbName = 'default')
    {
        $dsn = Core::Config()->get("database.$dbName");
        Core::Logger()->info($dsn);
        parent::__construct(new \PDO($dsn));
    }
}