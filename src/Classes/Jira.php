<?php

namespace ProcessMaker\JukumariLib\Classes;

use ProcessMaker\JukumariLib\Classes\CallApi;
use \Exception;
use Dotenv\Dotenv;

class Jira extends CallApi
{
    public $server;
    public $user;
    public $pass;

    public function __construct($dataJira = array())
    {
        try {

            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $this->server = $_ENV['JIRA_SERVER'];
            $this->user = $_ENV['JIRA_USER'];
            $this->pass = $_ENV['JIRA_PASS'];
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jira::__construct =>' . $error->getMessage());
        }
    }

    public function createTicket($dataTicket)
    {
        try {
            $description = $this->createTemplate($dataTicket['description']);
            return $description;
            $dataTicket = array(
                'fields' => array(
                    'project'       => array('id' => (int)$dataTicket['project']),
                    'summary'       => $dataTicket['summary'],
                    'description'   => $description,
                    'issuetype'     => array('name' => 'Task'),
                    'assignee'      => array('id' => $dataTicket['assignee'])
                )
            );
            $return = array(
                'data1' => $dataTicket,
                'data2' => $this->server,
                'data3' => $this->user,
                'data4' => $this->pass
                
            );
            return $return;
            $resp = $this->postTicket($dataTicket);
            return $resp;
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jira::createTicket => ' . $error->getMessage());
        }
    }

    public function createTemplate($description)
    {
        try {
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
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jira::createTemplate => ' . $error->getMessage());
        }
    }

    public function postTicket($dataTicket)
    {
        try {
            $uri = 'rest/api/2/issue';
            $respEndPoint = $this->executeEndPointBasicAuth($uri, 'POST', $dataTicket);
            $dataTicket = json_decode($respEndPoint['response']);
            return $dataTicket;
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jira::postTicket => ' . $error->getMessage());
        }
    }
}
