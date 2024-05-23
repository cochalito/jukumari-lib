<?php

namespace ProcessMaker\JukumariLib;

use ProcessMaker\JukumariLib\Classes\Jira;
use ProcessMaker\JukumariLib\Classes\Banner;

class Jukumari
{
    public function inicioBanner($dataBanner)
    {
        $banner = new Banner($dataBanner);
        $token = $banner->createTokenBanner();
        die('Funciona ' . $token);
    }

    public function setDueDateOldTicket()
    {
        $startDate = '2024-05-20';
        $endDate = '2024-05-24';
        $report = array();

        $jira = new Jira();

        $jql = 'project in (ADOA,ADPS,BIRMINGHAM,DSIERRA,FOUNDATION,MADISON,"GEORGE BROWN",MDP,"RIVER CITY","Sony Music","Thermo Fisher",WINGATE,ADTALEM,REDWOODS,"TRENTA TECH","UNIVERSIDAD NACIONAL DE COLOMBIA",AMNET) ';
        $jql .= 'and createdDate >= "' . $startDate . '" and createdDate <= "' . $endDate . '" ORDER BY created DESC';
        $jql = 'key=SM-672';
        $response = $jira->searchTicket($jql);

        foreach ($response->issues as $value) {
            if (isset($value->fields->status->name) && $value->fields->status->name == 'Canceled') {
                continue;
            }

            if (isset($value->fields->issuetype->name) && $value->fields->issuetype->name == 'Epic') {
                continue;
            }

            $keyTicket = $value->key;
            $temp = array();
            $temp['ASSIGNED'] = $value->fields->assignee->displayName;
            $temp['KEY'] = $keyTicket;

            $currentDueDate = $value->fields->duedate;

            $temp['STATUS_CURRENT'] = $value->fields->status->name;
            $temp['STATUS_RESET'] = 'NO';

            $temp['DUE_DATE_CURRENT'] = $currentDueDate;
            $temp['DUE_DATE_ACTION'] = 'NO';
            $temp['DUE_DATE_NEW'] = '-----';

            $temp['STAR_DATE_CURRENT'] = $value->fields->customfield_14714 ?? '(SIN VALOR)';
            $temp['STAR_DATE_ACTION'] = 'NO';
            $temp['STAR_DATE_NEW'] = '-----';

            $temp['RESOLUTION_DATE_CURRENT'] = $value->fields->resolutiondate;
            $temp['RESOLUTION_DATE_FORMAT'] = 'NO';
            $temp['RESOLUTION_DATE_EXIST'] = 'NO';

            $flagResetStatus = false;
            $flagEditDueDate = false;
            $flagEditStarDate = false;
            $fieldsData = array();

            if ($value->fields->status->name == 'Finished') {
                $flagResetStatus = true;
                $temp['STATUS_RESET'] = 'SI';
                $temp['RESOLUTION_DATE_EXIST'] = 'YES';
            }

            if ($temp['RESOLUTION_DATE_CURRENT'] != null) {
                $temp['RESOLUTION_DATE_FORMAT'] = substr($value->fields->resolutiondate, 0, 10);
                if ($currentDueDate > $temp['REssSOLUTION_DATE_FORMAT']) {
                    $updateDueDate = $temp['RESOLUTION_DATE_FORMAT'];
                    $temp['DUE_DATE_NEW'] = $updateDueDate;
                    $temp['DUE_DATE_ACTION'] = 'SI';
                    $flagEditDueDate = true;
                    $fieldsData['duedate'] = $updateDueDate;
                } else {
                    if ($currentDueDate < $startDate || $endDate < $currentDueDate) {
                        $updateDueDate = '2024-05-24';
                        $temp['DUE_DATE_NEW'] = $updateDueDate;
                        $temp['DUE_DATE_ACTION'] = 'SI';
                        $flagEditDueDate = true;
                        $fieldsData['duedate'] = $updateDueDate;
                    }
                }
            } else {
                if ($currentDueDate < $startDate || $endDate < $currentDueDate) {
                    $updateDueDate = '2024-05-24';
                    $temp['DUE_DATE_NEW'] = $updateDueDate;
                    $temp['DUE_DATE_ACTION'] = 'SI';
                    $flagEditDueDate = true;
                    $fieldsData['duedate'] = $updateDueDate;
                }
            }

            if (empty($value->fields->customfield_14714) || $value->fields->customfield_14714 == null) {
                $flagEditStarDate = true;
                $fieldsData['customfield_14714'] = $startDate;
                $temp['STAR_DATE_NEW'] = $startDate;
                $temp['STAR_DATE_ACTION'] = 'SI';
            }

            /// UPDATE TICKET
            if ($flagEditDueDate || $flagEditStarDate) {
                if ($flagResetStatus) {
                    $response = $jira->editStatusTicket($keyTicket, 're-open');
                }

                $dataTicket = array(
                    'fields' => $fieldsData
                );
                $jira->editTicket($keyTicket, $dataTicket);

                if ($flagResetStatus) {
                    $response = $jira->editStatusTicket($keyTicket, 'finished');
                }
            }
            $report[] = $temp;
        }

        // print_r($report);
        print json_encode($report);
        die('Funciona !!!!!');
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
