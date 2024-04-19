<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';

$test = array(
    array(
        'description' => 'test description',
        'project' => 15419,
        'summary' => 'test summary',
        'assignee' => '5d35deb94fa5500c42b699ff'
    )
);

$jukumari = new Jukumari();
$return = $jukumari->createTickets($test);

print_r($return);
die('wwwwww');

$jukumari = new Jukumari();
$return = $jukumari->getApi();

die('qqqq');
return $return;
