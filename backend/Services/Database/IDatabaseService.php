<?php

namespace ISTPeregrination\Services\Database;

interface IDatabaseService
{
    function getPDO(): \PDO;
    function beginTransaction(): void;
    function commit(): void;
    function rollBack(): void;

    function playScript(string $script): void;
}