<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('1 Ioan 1:9; Filipeni 1:21', false);
$array = $test->v2();
echo '<pre>';
print_r($array);
