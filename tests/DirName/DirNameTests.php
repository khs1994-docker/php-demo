<?php

namespace DirName\Tests;

use PHPUnit\Framework\TestCase;
use DirName\DirName;

class DirNameTests extends TestCase
{
    private static $test;

    public static function getTest()
    {
        if (!(self::$test instanceof DirName)) {
            self::$test = DirName::getInstance();
        }

        return self::$test;
    }
}
