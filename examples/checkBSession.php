<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$check = $CinemaPark->checkBSession(21, 1199132, 0);

print_r($check);