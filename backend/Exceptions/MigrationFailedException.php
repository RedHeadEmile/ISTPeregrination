<?php

namespace ISTPeregrination\Exceptions;

class MigrationFailedException extends \Exception
{
    public function __construct(string $message = "Migration failed", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}