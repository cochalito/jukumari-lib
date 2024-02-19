<?php

namespace ProcessMaker\JukumariLib;

use ProcessMaker\JukumariLib\Classes\Api;

class Jukumari
{
    public function getInformation()
    {
        return array(
            'Team' => 'Jukumari Team',
            'Author' => 'Brayan Pereyra (Cochalo)'
        );
    }

    public function getApi()
    {
        $api = new Api();
        return $api->executeApi();
    }
}
