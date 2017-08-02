<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$filmsMultiplexes = $CinemaPark->getFilmsMultiplexes();

print_r($filmsMultiplexes);