<?php

namespace horstoeko\objecttools\tests\assets;

class TestClassTwo
{
    public $value1 = 0;

    public $value2 = "";

    public function __construct(int $value1, string $value2)
    {
        $this->value1 = $value1;
        $this->value2 = $value2;
    }

    public function getValue1(): int
    {
        return $this->value1;
    }

    public function getValue2(): string
    {
        return $this->value2;
    }
};
