<?php

include_once '../vendor/autoload.php';

$CinemaPark = new AXP\CinemaPark\CinemaPark();
$edit = $CinemaPark->editBooking(26, 1195209, 'ojasmnreqs');

print_r($edit);