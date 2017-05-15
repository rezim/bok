<?php
class serviceController extends Controller
{
    function show() {
    }

    function addClient() {
        echo json_encode($this->service->add($_POST, 'service_clients'));
    }

    function updateClient() {
        echo json_encode($this->service->updateFromPostParams($_POST, 'service_clients', 'rowid_clients:i'));
    }

    function updateRequest() {
        echo json_encode($this->service->updateFromPostParams($_POST, 'service_requests', 'rowid:i'));
    }

    function addRequest() {
        $result = $this->service->add($_POST, 'service_requests');

        $insertedServiceId = $this->service->getLastId();

        if ($result['status']) {
            $revers = $this->service->query("SELECT * FROM `service_revers` ORDER BY rowid DESC LIMIT 1");
            if (count($revers) == 0) {
                $res = $this->service->update("INSERT INTO service_revers(`number`, `year`) values(?,YEAR(CURDATE()))", 'i', array(1));
                // $res = $this->service->query("INSERT INTO service_revers(`number`, `year`) values(1,YEAR(CURDATE()))");
            } else {
                $currentNumber = $revers[0]['number'] + 1;
                if ($revers[0]['year'] < intval(date('Y'))) {
                    $currentNumber = 1;
                }
                $res = $this->service->update("UPDATE `service_revers` SET `number` = ?, `year` = YEAR(CURDATE())", 'i', array($currentNumber));
                // $this->service->query("UPDATE service_revers SET `number` = " . $currentNumber . ", `year` = YEAR(CURDATE()) WHERE rowid = " . $revers[0]['rowid'], 'rowid');
            }
            if ($res['status']) {
                $revers = $this->service->query("SELECT * FROM `service_revers` ORDER BY rowid DESC LIMIT 1");
                $newRevers = $revers[0]['number'] . "/" . $revers[0]['year'];
                $this->service->update("UPDATE `service_requests` SET `revers_number` =  ? WHERE rowid = ?", 'si', array($newRevers, $insertedServiceId));
            }
        }

        echo json_encode($result);
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

    function getEmails() {
        echo $this->service->getEmails($_POST['revers_number']);
    }

    function notifyEmployee() {
        if ($_POST['mail']) {
            $mailing = new mailing();
            $mailing->sendNewMail(
                $_POST['mail'],
                "Model:" . $_POST['model'] . "<br/>" .
                "Serial:" . $_POST['numer'] . "<br/>" .
                "Opis Usterki:" . $_POST['opis'] . "<br/>" ,
                "Nowe zgłoszenie serwisowe.",
                null
            );
        }
    }

    function sendMail() {
        if ($_POST['email'] && $_POST['temat'] && $_POST['tresc_wiadomosci'] && $_POST['revers_number']) {
            $mailing = new mailing();
            $_POST['wassent:i'] = 1;
            $_POST['wasread:i'] = 1;
            if($mailing->sendNewMail(
                $_POST['email'],
                $_POST['tresc_wiadomosci'],
                $_POST['temat'],
                $_POST['revers_number'],
                $_POST['wassent:i'],
                $_POST['wasread:i']
            )) {
                echo json_encode($this->service->add($_POST, 'service_mails'));
            }
        } else {
            echo 'Nie można wysłać emaila';
        }
    }

    function setEmailRead() {
        echo json_encode($this->service->updateFromPostParams($_POST, 'service_mails', 'rowid:i'));
    }

    function getCurrentUserRequests() {
        echo $this->service->getCurrentUserRequests();
    }
}

