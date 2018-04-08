<?php

namespace Example\Tests;

class ExampleTest extends ExampleTestCase
{
    public function example()
    {
        return $this->getTest();
    }

    public function testExample()
    {
        $test = $this->example()->return0();

        $this->assertEquals(0, $test);
    }
}
