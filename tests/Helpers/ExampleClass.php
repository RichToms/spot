<?php

namespace RichToms\Spot\Tests\Helpers;

class ExampleClass
{
    public $attributes = [];

    public function __construct()
    {
        $this->attributes = func_get_args();
    }

    public function run()
    {
        // Do nothing
    }

    public function return($value)
    {
        return $value;
    }

    public function sleep($time = 1)
    {
        sleep($time);
    }
}
