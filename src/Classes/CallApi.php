<?php

namespace ProcessMaker\JukumariLib\Classes;

class CallApi
{
    public function executeEndPointBanner($url, $header, $method, $arrayPost = array())
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        if ($method == 'POST') {
            $postFields = json_encode($arrayPost);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($curl, CURLOPT_POST, TRUE);
        }

        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }

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
