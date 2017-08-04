<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$layout = $CinemaPark->seatsLayout(26, 1195209);

print_r($layout);