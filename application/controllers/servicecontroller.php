<?php
class serviceController extends Controller
{
    function show() {

    }

    function addClient() {
        echo $this->service->add($_POST, 'service_clients');
    }

    function addRequest() {
        echo $this->service->add($_POST, 'service_requests');
    }

    function getClients() {
        echo $this->service->getClients();
    }

    function getRequests() {
        echo $this->service->getRequests();
    }

    function getStatuses() {
        echo $this->service->getStatuses();
    }

    function getUsers() {
        echo $this->service->getUsers();
    }

    function notifyEmployee() {
        if ($_POST['mail']) {
            $mailing = new mailing();
            $mailing->sendNewMail(null,
                $_POST['mail'],
                "Model:" . $_POST['model'] . "<br/>" .
                "Serial:" . $_POST['numer'] . "<br/>" .
                "Opis Usterki:" . $_POST['opis'] . "<br/>" ,
                "Nowe zgłoszenie serwisowe.",
                null
            );
        }
    }
}

