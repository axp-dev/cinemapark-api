<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$multiplexRepertoir = $CinemaPark->getMultiplexRepertoir(21);

print_r($multiplexRepertoir);