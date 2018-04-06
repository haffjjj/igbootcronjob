<?php

include_once('config.php');
$dbmethod = new dbmethod();

$dataqueue = $dbmethod->readqueue()[0];

set_time_limit(0);
date_default_timezone_set('UTC');

require 'vendor/autoload.php';

/////// CONFIG ///////
$username = '#';
$password = '#';
$debug = true;
$truncatedDebug = false;
//////////////////////

/////// MEDIA ////////
$photoFilename = 'uploads/'.$dataqueue['imgname'];
$captionText = $dataqueue['caption'];
//////////////////////

$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);

try {
    $ig->login($username, $password);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
    exit(0);
}

try {
    $photo = new \InstagramAPI\Media\Photo\InstagramPhoto($photoFilename);
    $ig->timeline->uploadPhoto($photo->getFile(), ['caption' => $captionText]);
} catch (\Exception $e) {
    echo 'Something went wrong: '.$e->getMessage()."\n";
}

$dbmethod->updatequeue($dataqueue['id']);