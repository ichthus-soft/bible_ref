<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Genesis 2:9&1:10-12,9;John 1:4-5', false);
$array = $test->v2();
echo '<pre>';
print_r($array);
