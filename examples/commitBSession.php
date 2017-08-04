<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$commit = $CinemaPark->commitBSession(26, 1195209, '2e9254d85984365af7', 2, 'axp-dev@yandex.com', '9000000000', 1);

print_r($commit);