<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';


$jukumari = new Jukumari();
$return = $jukumari->setDueDateOldTicket();

print_r($return);
die('wwwwww');


$jukumari = new Jukumari();
$return = $jukumari->getApi();

die('qqqq');
return $return;
