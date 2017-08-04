<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$seat = $CinemaPark->seatStates(26, 1195209, '2e9254d85984365af7');

print_r($seat);