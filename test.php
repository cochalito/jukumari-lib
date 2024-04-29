<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';

$test = array(
    array(
        'create' => true,
        'project' => array(
            'value'     => '15419',
            'content'   => 'Jukumari',
        ),
        'summary' => "Correccion proceso de creacion de tickets",
        'description' => "Correccion proceso de creacion de tickets",
        'assignee' => "557058:ee888405-8b48-4b4a-89b6-6fd31f0bb9ae",
        'hours' => "1h",
        'storyPoints' => "1",
        'label' => "PS_Investment"
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
