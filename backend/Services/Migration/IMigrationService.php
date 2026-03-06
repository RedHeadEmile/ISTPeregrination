<?php

namespace ISTPeregrination\Services\Migration;

use ISTPeregrination\Exceptions\MigrationFailedException;

interface IMigrationService
{
    /**
     * Migrate the database to the latest version by playing migration scripts.
     * @return void
     * @throws MigrationFailedException
     */
    function migrate(): void;
}