<?php

namespace ISTPeregrination\Services\Migration;

use ISTPeregrination\Common\SingletonTrait;
use ISTPeregrination\Exceptions\MigrationFailedException;
use ISTPeregrination\Services\Database\DatabaseService;

class MigrationService implements IMigrationService
{
    use SingletonTrait;

    public function __construct()
    {
    }

    public function migrate(): void
    {
        $files = scandir(__DIR__ . "/Scripts", SCANDIR_SORT_ASCENDING);
        if ($files === false)
            throw new MigrationFailedException("Failed to scan migration scripts directory");

        $pdo = DatabaseService::getInstance()->getPDO();
        $passedMigrations = [];
        try {
            $fetchStmt = $pdo->prepare("SELECT name, passedat FROM datamigration");
            $fetchStmt->execute();
            $result = $fetchStmt->fetchAll(\PDO::FETCH_NAMED);
            foreach ($result as $migration) {
                $passedMigrations[] = $migration["name"];
            }
        }
        catch (\PDOException $e) {
            if ($e->getCode() !== "42S02")
                throw $e;

            $pdo->exec("CREATE TABLE datamigration (" .
                "name VARCHAR(50) NOT NULL PRIMARY KEY," .
                "passedat BIGINT NOT NULL" .
                ")");
        }

        foreach ($files as $file) {
            if (!str_ends_with($file, ".sql") || in_array($file, $passedMigrations))
                continue;

            $script = file_get_contents(__DIR__ . "/Scripts/" . $file);
            if ($script === false)
                throw new MigrationFailedException("Failed to read migration script: " . $file);

            try {
                $stmt = $pdo->prepare($script);
                $stmt->execute();

                $stmt = $pdo->prepare("INSERT INTO datamigration (name, passedat) VALUES (:name, :passedat)");
                $stmt->execute([
                    ":name" => $file,
                    ":passedat" => currentTimeInMillis()
                ]);
            }
            catch (\PDOException $e) {
                throw new MigrationFailedException("Failed to execute migration script: " . $file, previous: $e);
            }
        }
    }
}