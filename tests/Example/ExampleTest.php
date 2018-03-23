<?php

namespace Example\Tests;

class DemoTest extends ExampleTestCase
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
