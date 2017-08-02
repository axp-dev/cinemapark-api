<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$repertoir = $CinemaPark->getRepertoir(1531);

print_r($repertoir);