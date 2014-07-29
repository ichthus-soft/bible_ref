<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Ioan 1:1&2:1', false);
$array = $test->getArray();
print_r(var_dump($array));
