<?php

class configController extends Controller
{
    function show()
    {
        global $smarty;
        $configuration = $this->config->getConfiguration();
        $smarty->assign('configuration', $configuration);
        unset($configuration);
    }

    function clearpaymentsmonitoring()
    {
        $result = $this->config->clearPaymentsMonitoring();

        if ($result['status'] == 1) {

            if ($result['rows_affected'] > 0) {
                $result['info'] = 'Monitoring usunięty dla ' . $result['rows_affected'] . ' klientów';
            } else {
                $result['info'] = 'Nie było monitorowanych klientów.';
            }
        }

        echo json_encode($result);
    }

    function saveconfiguration() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            $this->config->populateWithPost();
            echo(json_encode($this->config->saveConfiguration()));
        }
    }
}

