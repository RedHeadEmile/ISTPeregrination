<?php

namespace ISTPeregrination\Exceptions;

class EmailAlreadyExistingException extends \Exception
{
    public function __construct()
    {
        parent::__construct("A user with this email already exists");
    }
}