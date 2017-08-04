<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$seat = $CinemaPark->seatAction(26, 1195209, '2e9254d859844a7b41', 1, 61193);

print_r($seat);