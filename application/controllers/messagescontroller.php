<?php
class messagesController extends Controller
{

    function showmodal() {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) && $_POST['data'])
        {
            global $smarty;
            $smarty->assign('data', $_POST['data']);
        }
    }

    function showdane()
    {
        $this->message->populateWithPost();
        $messages = $this->message->getMessages();
        global $smarty;
        $smarty->assign('messages', $messages);
        $smarty->assign('type', $_POST['type']);
        if (isset($_POST['foreignkey'])) {
            $smarty->assign('foreignkey', $_POST['foreignkey']);
        } else {
            $smarty->assign('foreignkey', null);
        }
        $smarty->assign('containerId', $_POST['containerId']);

        unset($messages);
    }

    function saveupdate()
    {
        if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) )
        {

            if(!isset($_POST['message']) || $_POST['message'] =='')
                die('Wpisz wiadomość');

            $this->message->populateWithPost();
            echo(json_encode($this->message->saveupdate()));
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

            $this->message->populateWithPost();
            echo(json_encode($this->message->remove()));
        }
        else
        {
            echo('Błędne wywołanie');
        }
    }
}
