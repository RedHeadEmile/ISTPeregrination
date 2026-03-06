<?php

namespace ISTPeregrination\Controllers;

class ErrorHandlerController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        echo "Error " . $this->vars['code'];
        print_r($this->vars);
    }
}