<?php

namespace horstoeko\objecttools\tests\testcases;

use horstoeko\objecttools\Instance;
use horstoeko\objecttools\tests\TestCase;

class TestInstance extends TestCase
{
    public function testInstanciateWithoutConstructorArgs()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassOne');
        $this->assertInstanceOf(\horstoeko\objecttools\tests\assets\TestClassOne::class, $instance->value());
    }

    public function testInstanciateWithConstructorArgs()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassTwo', 99, "Baum");
        $this->assertInstanceOf(\horstoeko\objecttools\tests\assets\TestClassTwo::class, $instance->value());
    }

    public function testInstanciateOnUnknown()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassThree');
        $this->assertNull($instance->value());
    }

    public function testCall()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassTwo', 99, "Baum");
        $this->assertEquals(99, $instance->getValue1());
        $this->assertEquals("Baum", $instance->getValue2());
    }

    public function testGet()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassTwo', 99, "Baum");
        $this->assertEquals(99, $instance->value1);
        $this->assertEquals("Baum", $instance->value2);
    }

    public function testSet()
    {
        $instance = new Instance('horstoeko\objecttools\tests\assets\TestClassTwo', 99, "Baum");
        $this->assertEquals(99, $instance->value1);
        $instance->value1 = 100;
        $this->assertEquals(100, $instance->value1);
    }
}