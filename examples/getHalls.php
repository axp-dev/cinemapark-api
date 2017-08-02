<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$halls = $CinemaPark->getHalls();

print_r($halls);