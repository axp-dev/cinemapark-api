<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$session = $CinemaPark->cancelBSession(26, 1195209, '2e9254d85984365af7');

print_r($session);