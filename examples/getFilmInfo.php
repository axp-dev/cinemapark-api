<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$film = $CinemaPark->getFilmInfo(3679);

print_r($film);