<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$session = $CinemaPark->initSSession(26, 34554, 'kpahsroqwui', 2);

print_r($session);