<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';

$test = array();
if (($gestor = fopen("horas.csv", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
        $projectContent = explode("[", $datos[1]);
        $projectContent = explode("]", $projectContent[1]);
        $temp = array(
            'create' => true,
            'project' => array(
                'value' => $datos[0],
                'content' => trim($projectContent[0]),
            ),
            'summary' => trim($projectContent[1]),
            'description' => $datos[2],
            'assignee' => $datos[3],
            'hours' => $datos[4],
            'storyPoints' => "1",
            'label' => "PS_Investment"
        );
        $test[] = $temp;
    }
    fclose($gestor);
}

$jukumari = new Jukumari();
$return = $jukumari->createTickets($test);

print_r($return);
die('funciono!!!!');


/*
$test = array(
    array(
        'create' => true,
        'project' => "15419",
        'summary' => "DESDE SCRIPT test 100",
        'description' => "DESDE SCRIPT test 100 des",
        'assignee' => "557058:ee888405-8b48-4b4a-89b6-6fd31f0bb9ae",
        'hours' => "30m"
    ),
    array(
        'create' => true,
        'project' => "15419",
        'summary' => "DESDE SCRIPT test 100",
        'description' => "DESDE SCRIPT test 100 des",
        "assignee" => "5d1a2f38f4228c0d18a0b34e",
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
*/