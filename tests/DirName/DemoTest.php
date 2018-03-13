<?php

namespace DirName\Tests;

class DemoTest extends DirNameTests
{
    public function demo()
    {
        return $this->getTest();
    }

    public function testDemo()
    {
        $test=$this->demo()->return0();

        $this->assertEquals(0, $test);
    }
}
