<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$films = $CinemaPark->getFilms();

print_r($films);