<?php
class messagesinvoicesController extends Controller
{
    function showdane()
    {

        global $smarty;
        $messages = $this->messagesinvoice->getMessages();
        $smarty->assign('messages',$messages);

        unset($messages);
    }

    function saveupdate()
    {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {

            if(!isset($_POST['message']) || $_POST['message'] =='')
                die('Wpisz wiadomość');

            $this->messagesinvoice->populateWithPost();
            echo(json_encode($this->messageinvoice->saveupdate()));
        }
        else
        {
            echo('Błędne wywołanie');
        }
    }

    function remove()
    {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {

            if(!isset($_POST['rowid']) || $_POST['rowid']=='')
                die('Nie można pobrać identyfikatora');

            $this->messagesinvoice->populateWithPost();
            echo(json_encode($this->messagesinvoice->remove()));
        }
        else
        {
            echo('Błędne wywołanie');
        }
    }
}
