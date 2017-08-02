<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$multiplexes = $CinemaPark->getMultiplexes();

print_r($multiplexes);