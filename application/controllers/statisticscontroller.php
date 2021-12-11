<?php

class statisticsController extends Controller
{

    function show() {

    }

    function showdane()
    {
        $dataStatistics = $this->statistic->getStatistics($_POST['dateFrom'], $_POST['dateTo'], $_POST['showNotClosed']);
        global $smarty;
        $smarty->assign('dataStatistics', $dataStatistics);
        unset($dataStatistics);

    }
}
