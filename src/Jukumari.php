<?php

namespace ProcessMaker\JukumariLib;

use ProcessMaker\JukumariLib\Classes\Jira;
use \Exception;

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
        try {
            $jira = new Jira();
            $response = array();
            foreach ($dataTickets as $ticket) {
                $response[] = $jira->createTicket($ticket);
                return $response;
            }
            return $response;
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jukumari::createTickets =>' . $error->getMessage());
        }
    }
}
