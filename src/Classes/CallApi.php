<?php

namespace ProcessMaker\JukumariLib\Classes;

class CallApi
{
    /*
    public function __construct($dataJira)
    {
        $this->server = $dataJira['SERVER'] ?? $this->server;
        $this->user = $dataJira['JIRA_USER'] ?? $this->user;
        $this->pass = $dataJira['JIRA_PASS'] ?? $this->pass;
    }
    */

    public function executeEndPointBasicAuth($uri, $method = 'GET', $data = array())
    {
        try {
            $sServer = 'https://' . $this->server . '/' . $uri;
            $sUserPass = $this->user . ':' . $this->pass;
            $curl = curl_init();

            if ($method == 'POST') {
                $sHeader = array(
                    'Content-Type: application/json'
                );
                $sParam = json_encode($data);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $sHeader);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $sParam);
            } elseif ($method == 'PUT') {
                $sHeader = array(
                    'Content-Type: application/json'
                );
                $sParam = json_encode($data);
                curl_setopt($curl, CURLOPT_HTTPHEADER, $sHeader);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $sParam);
            }

            curl_setopt($curl, CURLOPT_URL, $sServer);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERPWD, $sUserPass);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            $sResponse = curl_exec($curl);
            $sInfo = curl_getinfo($curl);

            $aResponse = array('response' => $sResponse, 'info' => $sInfo);
            return $aResponse;
        } catch (Exception $oError) {
            throw $oError;
        }
    }
}
