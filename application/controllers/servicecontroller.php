<?php
class serviceController extends Controller
{
    function show() {

    }

    function addClient() {
        echo $this->service->add($_POST, 'service_clients');
    }

    function updateClient() {
        echo json_encode($this->service->updateFromPostParams($_POST, 'service_clients', 'rowid_clients:i'));
    }

    function updateRequest() {
        echo json_encode($this->service->updateFromPostParams($_POST, 'service_requests', 'rowid:i'));
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

    function getServiceAvailableStatuses()
    {
        echo $this->service->getServiceAvailableStatuses();
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

    function getCurrentUserRequests() {
        echo $this->service->getCurrentUserRequests();
    }
}

