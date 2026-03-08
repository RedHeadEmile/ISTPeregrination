<?php

namespace ISTPeregrination\Exceptions;

class InvalidNameException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The provided name is not valid");
    }
}