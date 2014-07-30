<?php
require_once __DIR__ . '/../vendor/autoload.php';

use BibleRef\Reference;
$test = new Reference('Geneza 2:9&1:10-12,9;Ioan 1:4-5', false);
$array = $test->v2();
var_dump($array['books']['Geneza']);
