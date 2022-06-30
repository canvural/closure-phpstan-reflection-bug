<?php

namespace App;

use function PHPStan\dumpType;

function doStuff(Bar $bar) {
    dumpType($bar->magicMethod());
}