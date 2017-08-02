<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$timeTable = $CinemaPark->getTimeTable(1);

print_r($timeTable);