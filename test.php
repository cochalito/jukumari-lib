<?php


use ProcessMaker\JukumariLib\Jukumari;

require_once 'vendor/autoload.php';

$test = array(
    array(
        'create' => true,
        'project' => array(
            'value'     => '15708',
            'content'   => 'Thermo Fisher',
        ),
        'summary' => "Realizar test del proceso MSC en dev server",
        'description' => "Realizar test del proceso MSC en dev server",
        'assignee' => "557058:ee888405-8b48-4b4a-89b6-6fd31f0bb9ae",
        'hours' => "1h",
        'storyPoints' => "1",
        'label' => "PS_Non-billable"
    )
);


//inicio
/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://gbcbdm02u.georgebrown.ca/AppXtenderReST/api/axdatasources/TEST/AXDocExportResults/JK168E30E6695D279B6BA76ADBAAFD5B81DA',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/pdf',
    'Authorization: Basic QkRNQVBJX1VTRVI6dV9waWNrX2l0'
  ),
));

$response = curl_exec($curl);

curl_close($curl);

file_put_contents('hola.pdf', $response);
die('fin1111');
//$aResponse = array('response' => $sResponse, 'info' => $sInfo);
*/






$jukumari = new Jukumari();
$return = $jukumari->createTickets($test);

print_r($return);
die('wwwwww');


$jukumari = new Jukumari();
$return = $jukumari->getApi();

die('qqqq');
return $return;
