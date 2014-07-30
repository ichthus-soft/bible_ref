<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Geneza 1:9&2:10-12;Ioan 1:4-5', false);
$array = $test->v2();
print_r(var_dump($array));
