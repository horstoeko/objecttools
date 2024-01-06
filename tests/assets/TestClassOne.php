<?php

namespace horstoeko\objecttools\tests\assets;

class TestClassOne
{
    public $property1;

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
