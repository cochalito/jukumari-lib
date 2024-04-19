<?php

namespace ProcessMaker\JukumariLib\Classes;

use ProcessMaker\JukumariLib\Classes\CallApi;
use \Exception;

class Jira extends CallApi
{
    public $server = 'processmaker.atlassian.net';
    public $user = 'brayan@processmaker.com';
    public $pass = 'eDm67yx9HS0SsXw7mfioB2FA';

    public function __construct($dataJira = array())
    {
        $this->server = $dataJira['SERVER'] ?? $this->server;
        $this->user = $dataJira['JIRA_USER'] ?? $this->user;
        $this->pass = $dataJira['JIRA_PASS'] ?? $this->pass;
    }

    public function createTicket($dataTicket)
    {
        $description = $this->createTemplate($dataTicket['description']);
        $dataTicket = array(
            'fields' => array(
                'project'       => array('id' => $dataTicket['project']),
                'summary'       => $dataTicket['summary'],
                'description'   => $description,
                'issuetype'     => array('name' => 'Task'),
                'assignee'      => array('id' => $dataTicket['assignee'])
            )
        );
        $resp = $this->postTicket($dataTicket);
        return $resp;
    }

    public function createTemplate($description)
    {
        $body = '* Ticket created By Jukumari Process *';
        //$description .= "\n" . 'Project: *' . $dataTicket['PRO_BASECAMP_NAME'] . '*';
        //$description .= "\n" . 'Reporter: *' . $dataTicket['TIC_BASECAMP_AUTHOR_NAME'] . '*';
        $body .= "\n\n" . $description;

        /*
        $link  = 'https://colosa.basecamphq.com/projects/' . $dataTicket['PRO_BASECAMP_ID'];
        $link .= '/posts/' . $dataTicket['TIC_BASECAMP_ID'] . '/comments';
        */

        $leads = '[Edgardo Silva|~accountid:557058:db398c98-5767-4b05-bf20-0788e8d0bc44] ';
        $leads .= '[Brayan Pereyra|~accountid:557058:ee888405-8b48-4b4a-89b6-6fd31f0bb9ae] ';
        $leads .= '[Ronald Rodriguez|~accountid:5ada0fbfba41192e23d7c49a]';

        //$description .= "\n\n" . 'BaseCamp Link: ' . $link;
        $body .= "\n\n" . 'cc: ' . $leads;
        return $body;
    }

    public function postTicket($dataTicket)
    {
        $uri = 'rest/api/2/issue';
        $respEndPoint = $this->executeEndPointBasicAuth($uri, 'POST', $dataTicket);
        $dataTicket = json_decode($respEndPoint['response']);
        return $dataTicket;
    }

}
