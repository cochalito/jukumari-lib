<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';

$test = array(
    array(
        'create' => true,
        'project' => "15773",
        'summary' => "Reunion semanal con el cliente",
        'description' => "Reunion semanal con el cliente",
        'assignee' => "5d35deb94fa5500c42b699ff",
        'hours' => "30m"
    ),
    array(
        'create' => true,
        'project' => "15773",
        'summary' => "Reuniones de QA/Test de cambios realizados",
        'description' => "Reuniones de QA/Test de cambios realizados",
        "assignee" => "5d35deb94fa5500c42b699ff",
        "hours" => "1h"
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
