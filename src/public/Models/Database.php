<?php

class Database
{
    protected $pdo;

    public function getPdo($host = 'db', $port = '5432', $dbname = 'postgres', $user = 'arsik', $password = '0000')
    {
        return $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;", $user, $password);
    }
}