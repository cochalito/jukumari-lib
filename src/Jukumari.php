<?php

namespace ProcessMaker\JukumariLib;

use ProcessMaker\JukumariLib\Classes\Api;

class Jukumari
{
    public function getInformation($dataRequest)
    {
        $return =  array(
            'Team' => 'Jukumari Team',
            'Author' => 'Brayan Pereyra (Cochalo)',
            'Project' => 'George Brown'
        );
        $return = array_merge($return, $dataRequest);
        return $return;
    }

    public function getApi()
    {
        $api = new Api();
        return $api->executeApi();
    }
}
