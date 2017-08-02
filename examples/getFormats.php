<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$formats = $CinemaPark->getFormats();

print_r($formats);