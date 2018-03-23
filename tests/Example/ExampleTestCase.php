<?php

namespace Example\Tests;

use PHPUnit\Framework\TestCase;
use Example\Example;

class ExampleTestCase extends TestCase
{
    private static $test;

    public static function getTest()
    {
        if (!(self::$test instanceof Example)) {
            self::$test = Example::getInstance();
        }

        return self::$test;
    }
}
