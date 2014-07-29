<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Ioan 1:1-4,5,6,9,11-14,20-27&2:1,4-10;Evrei 12:16,1-5,22-27&22:1,5-6&4:88,55,1-3', false);
// $test->sort(true);
var_dump($test->getArray()[1]);

$test = new Reference('Matei 1:1&2:1-5');
// $test->sort(true);
var_dump($test->getArray());
