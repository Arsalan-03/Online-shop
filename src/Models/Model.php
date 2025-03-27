<?php
namespace Models;

use PDO;

abstract class Model
{
    protected static PDO $pdo;

    public static function getPdo($host = 'db', $port = '5432', $dbname = 'postgres', $user = 'arsik', $password = '0000'): PDO
    {
        return static::$pdo = new \PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);
    }

    abstract static protected function getTableName(): string;
}