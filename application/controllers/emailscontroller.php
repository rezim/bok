<?php



// include 'application/utils/Email_reader.php';

class emailsController extends Controller
{
    function readdevicecounters() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {
            echo json_encode($this->email->pullDeviceCounters());
        }
    }
}

