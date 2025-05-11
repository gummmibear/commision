<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Services\Hello;

$hello = new Hello();

$hello->sayHello();

echo "\n";
