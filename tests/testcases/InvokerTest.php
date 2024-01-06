<?php

namespace horstoeko\objecttools\tests\testcases;

use horstoeko\objecttools\Invoker;
use horstoeko\objecttools\tests\TestCase;
use horstoeko\objecttools\tests\assets\TestClassOne;
use horstoeko\objecttools\tests\assets\TestClassTwo;

class InvokerTest extends TestCase
{
    protected $testClassOne;
    protected $testClassTwo;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->testClassOne = new TestClassOne(1);
        $this->testClassTwo = new TestClassTwo(100, "AAA");
    }

    public function testCallProc()
    {
        $invoker = Invoker::factory($this->testClassTwo);
        $invoker->callProc('setProperty1', 2);
        $invoker->callProc('setProperty2', "B");

        $this->assertEquals(2, $this->testClassTwo->property1);
        $this->assertEquals("B", $this->testClassTwo->property2);
    }

    public function testCallProcOnNull()
    {
        $invoker = Invoker::factory(null);
        $invoker->callProc('setProperty1', 2);

        $this->assertTrue(true);
    }

    public function testCallProcOnNonExistingMethod()
    {
        $invoker = Invoker::factory($this->testClassTwo);
        $invoker->callProc('setProperty3', 2);

        $this->assertEquals(100, $this->testClassTwo->property1);
        $this->assertEquals("AAA", $this->testClassTwo->property2);
    }

    public function testCallProcFirst()
    {
        $invoker = Invoker::factory($this->testClassTwo);

        $this->assertEquals(100, $this->testClassTwo->property1);
        $this->assertEquals("AAA", $this->testClassTwo->property2);

        $invoker->callProcFirst(['setProperty1', 'setProperty2'], 101);

        $this->assertEquals(101, $this->testClassTwo->property1);
        $this->assertEquals("AAA", $this->testClassTwo->property2);

        $invoker->callProcFirst(['unknown', 'setProperty2'], "BBB");

        $this->assertEquals(101, $this->testClassTwo->property1);
        $this->assertEquals("BBB", $this->testClassTwo->property2);

        $invoker->callProcFirst(['unknown', 'unknown2'], "XXX");

        $this->assertEquals(101, $this->testClassTwo->property1);
        $this->assertEquals("BBB", $this->testClassTwo->property2);
    }

    public function testCallProcFirstOnNull()
    {
        $invoker = Invoker::factory(null);

        $this->assertNull($invoker->callFunc("getProperty1"));
        $this->assertNull($invoker->callFunc("getProperty2"));

        $this->assertTrue(true);
    }

    public function testCallProcPath()
    {
        $invoker = Invoker::factory($this->testClassTwo);

        $invoker->callProcPath("setProperty1", 200);

        $this->assertEquals(200, $this->testClassTwo->property1);

        $invoker->callProcPath("getClassProperty1.setProperty1", 300);

        $this->assertEquals(300, $this->testClassTwo->classProperty1->property1);
    }

    public function testCallFunc()
    {
        $invoker = Invoker::factory($this->testClassTwo);

        $this->assertEquals(100, $invoker->callFunc("getProperty1"));
        $this->assertEquals("AAA", $invoker->callFunc("getProperty2"));
        $this->assertNull($invoker->callFunc("getProperty3"));
        $this->assertNotNull($invoker->callFunc("getClassProperty1"));
    }

    public function testCallFuncFirst()
    {
        $invoker = Invoker::factory($this->testClassTwo);

        $this->assertEquals(100, $this->testClassTwo->property1);
        $this->assertEquals("AAA", $this->testClassTwo->property2);

        $this->assertEquals(100, $invoker->callFuncFirst(['getProperty1', 'getProperty2']));
        $this->assertEquals("AAA", $invoker->callFuncFirst(['unknown', 'getProperty2']));
        $this->assertNull($invoker->callFuncFirst(['unknown', 'unknown2']));
    }

    public function testCallFuncFirstOnNull()
    {
        $invoker = Invoker::factory(null);

        $this->assertNull($invoker->callFuncFirst(['getProperty1', 'getProperty2']));
        $this->assertNull($invoker->callFuncFirst(['unknown', 'getProperty2']));
        $this->assertNull($invoker->callFuncFirst(['unknown', 'unknown2']));
    }

    public function testCallFuncPath()
    {
        $invoker = Invoker::factory($this->testClassTwo);

        $this->assertEquals(100, $invoker->callFuncPath('getProperty1'));
        $this->assertEquals("AAA", $invoker->callFuncPath('getProperty2'));
        $this->assertEquals(1, $invoker->callFuncPath('getClassProperty1.getProperty1'));
        $this->assertNull($invoker->callFuncPath('getClassProperty1.getProperty2'));
        $this->assertNull($invoker->callFuncPath(''));
    }
}
