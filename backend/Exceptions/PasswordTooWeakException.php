<?php

namespace ISTPeregrination\Exceptions;

class PasswordTooWeakException extends \Exception
{
    public function __construct()
    {
        parent::__construct("The provided password is too weak.");
    }
}