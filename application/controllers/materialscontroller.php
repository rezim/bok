<?php

class materialsController extends Controller
{
    protected $countableColumns = array('blackCount', 'magentaCount', 'cyanCount', 'yellowCount');
    protected $eventTypeColumnName = 'eventType';
    protected $materialSendEventId = 2;

    function showdane()
    {
        global $smarty;
        $this->material->populateWithPost();
        $report = $this->material->getMaterialsReport();
        $groupedReport = $this->group_by_client_and_agreement($report, 'clientName', 'agreementNb');

        $arrClientReport = array();
        foreach ($groupedReport as $clientKey => $clientReport) {
            $arrAgreementReport = array();
            foreach ($clientReport as $agreementKey => $agreementEvents) {
                $agreement = array('agreementNb' => $agreementKey, 'events' => $agreementEvents, 'eventsCount' => count($agreementEvents));
                $sumOfCountable = $this->sum_countable($this->get_countable_from_events($agreementEvents));
                foreach ($sumOfCountable as $key => $value) {
                    $agreement[$key] = $value;
                }
                array_push($arrAgreementReport, $agreement);
            }

            $client = array('clientName' => $clientKey, 'agreements' => $arrAgreementReport, 'agreementCount' => count($arrAgreementReport));
            $sumOfCountable = $this->sum_countable($this->get_countable_from_events($arrAgreementReport));
            foreach ($sumOfCountable as $key => $value) {
                $client[$key] = $value;
            }

            array_push($arrClientReport, $client);
        }

        $smarty->assign('dataMaterials', $arrClientReport);
        unset($dataMaterials);
    }

    function get_countable_from_events($arrEvents) {
        return array_map(function($event) {
            $intersection = array_intersect_key($event, array_flip($this->countableColumns));
            if (isset($event[$this->eventTypeColumnName]) && $event[$this->eventTypeColumnName] === $this->materialSendEventId) {
                foreach ($this->countableColumns as $countableColumn) {
                    $intersection[$countableColumn] *= -1;
                }
            }

            return $intersection;
        }, $arrEvents);
    }

    function sum_countable($arrCountable)
    {
        if (count($arrCountable) === 0) {
            return array();
        }

        $initialSumOfCountable = array();
        foreach (array_keys($arrCountable[0]) as $countableColName) {
            $initialSumOfCountable[$countableColName] = 0;
        }

        return array_reduce($arrCountable, function ($v1, $v2) {
            foreach (array_keys($v2) as $countableColName) {
                $v1[$countableColName] += $v2[$countableColName];

            }
            return $v1;
        }, $initialSumOfCountable);
    }

    function group_by_client_and_agreement($data, $clientKey, $agreementKey)
    {
        $groupByClientKey = $this->group_by($clientKey, $data);

        foreach ($groupByClientKey as $key => $agreements) {
            $groupByClientKey[$key] = $this->group_by($agreementKey, $agreements);
        }

        return $groupByClientKey;
    }

    function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }
}
