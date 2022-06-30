<?php

namespace App;

class Foo
{
    public function doFoo(): \Closure
    {
        return function (): int {
            return \random_int(0, 100);
        };
    }
}