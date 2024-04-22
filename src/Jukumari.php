<?php

namespace ProcessMaker\JukumariLib;

use ProcessMaker\JukumariLib\Classes\Jira;

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

    public function createTickets($dataTickets)
    {
        $jira = new Jira();
        $response = array();
        foreach ($dataTickets as $ticket) {
            $response[] = $jira->createTicket($ticket);
        }
        return $response;
    }
}
