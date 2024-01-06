<?php

use horstoeko\objecttools\Invoker;

require dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

class TestClassOne
{
    protected $property1;

    public function __construct($property1)
    {
        $this->property1 = $property1;
    }

    public function getProperty1()
    {
        return $this->property1;
    }

    public function setProperty1($newValue)
    {
        $this->property1 = $newValue;
    }
}

class TestClassTwo
{
    protected $property1;
    protected $property2;
    protected $classProperty1;

    public function __construct($property1, $property2)
    {
        $this->property1 = $property1;
        $this->property2 = $property2;
        $this->classProperty1 = new TestClassOne(99);
    }

    public function getProperty1()
    {
        return $this->property1;
    }

    public function getProperty2()
    {
        return $this->property2;
    }

    public function getClassProperty1()
    {
        return $this->classProperty1;
    }

    public function setProperty1($newValue)
    {
        $this->property1 = $newValue;
    }

    public function setProperty2($newValue)
    {
        $this->property2 = $newValue;
    }

    public function setAll($newValue1, $newValue2)
    {
        $this->setProperty1($newValue1);
        $this->setProperty2($newValue2);
    }

    public function getPropertyByIndex($index)
    {
        if ($index === 1) {
            return $this->property1;
        }
        if ($index === 2) {
            return $this->property1;
        }
        return null;
    }
}

function out($value)
{
    echo " - " . (is_null($value) ? "NULL" : $value) . PHP_EOL;
}

function outdump($value)
{
    ob_start();
    var_dump($value);
    out(trim(ob_get_clean()));
}

// -------------------------------------------------
// --- Main
// -------------------------------------------------

$instance = new TestClassTwo(1, "A");
$invoker = Invoker::factory($instance);

// Will return 1
out($invoker->callFunc("getProperty1"));

// Will return A
out($invoker->callFunc("getProperty2"));

// Will return 99
out($invoker->callFuncPath('getClassProperty1.getProperty1'));

// Will return NULL
out($invoker->callFuncPath('getClassProperty1.getProperty2'));

// Will return 1024
$invoker->callProc("setProperty1", 1024);
out($invoker->callFunc("getProperty1"));

// Will return 2048 and "B"
$invoker->callProc("setAll", 2048, "B");
out($invoker->callFunc("getProperty1"));
out($invoker->callFunc("getProperty2"));

// Will return 888
$invoker->callProcPath("getClassProperty1.setProperty1", 888);
out($invoker->callFuncPath('getClassProperty1.getProperty1'));

// Will return 2048
out($invoker->callFunc("getPropertyByIndex", 1));