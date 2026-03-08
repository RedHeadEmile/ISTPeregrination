<?php

namespace ISTPeregrination\Exceptions;

class InvalidEmailException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The provided email is not valid");
    }
}