<?php

namespace ISTPeregrination\Common;

trait SingletonTrait
{
    /**
     * @var static
     */
    static private $instance;

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        if (!isset(self::$instance))
            self::$instance = new static();

        return self::$instance;
    }

    abstract protected function __construct();
}