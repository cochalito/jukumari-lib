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
            $dataTicket = (array)$dataTicket;
            //$description = $this->createTemplateDescription($dataTicket['description']);
            $description = $dataTicket['description'];
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

    public function createTemplateDescription($description)
    {
        try {
            return $description;
        } catch (Exception $error) {
            exit('An error occurred in the execution of function Jira::createTemplateDescription => ' . $error->getMessage());
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
