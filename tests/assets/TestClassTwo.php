<?php

namespace horstoeko\objecttools\tests\assets;

class TestClassTwo
{
    public $property1;
    public $property2;
    public $classProperty1;

    public function __construct($property1, $property2)
    {
        $this->property1 = $property1;
        $this->property2 = $property2;
        $this->classProperty1 = new TestClassOne(1);
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
};
