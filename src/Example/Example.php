<?php

namespace Example;

/**
 *
 */
class Example
{
    private static $instance;

    private function __construct()
    {
        /**
         *
         */
    }

    private function __clone()
    {
        /**
         *
         */
    }

    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function return0()
    {
        return 0;
    }
}
