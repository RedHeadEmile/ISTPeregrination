<?php

namespace ISTPeregrination\Services\Database;

use ISTPeregrination\Common\SingletonTrait;

class DatabaseService implements IDatabaseService
{
    use SingletonTrait;

    private readonly \PDO $pdo;

    private function __construct()
    {
        $host = $_ENV['mysql_host'];
        $dbname = $_ENV['mysql_database'];
        $user = $_ENV['mysql_user'];
        $password = $_ENV['mysql_password'];

        $this->pdo = new \PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }

    public function playScript(string $script): void
    {
        $this->pdo->exec($script);
    }
}