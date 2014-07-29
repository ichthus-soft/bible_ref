<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Ioan 1:1-4,5,6,9,11-14,20-27;Evrei 12:16,1-5&13:5');
var_dump($test->getArray());
