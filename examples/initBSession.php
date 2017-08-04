<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$session = $CinemaPark->initBSession(26, 1195209, 2);

print_r($session);