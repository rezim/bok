<?php

class notificationsController extends InvoicesController
{


    function show()
    {

        global $smarty;
        $statusZgloszenie = $this->notification->getStatus();
        $smarty->assign('statusZgloszenie', $statusZgloszenie);

        unset($statusZgloszenie);


    }

    function showdane()
    {
        $this->notification->populateWithPost();
        $dataNoti = $this->notification->getData();
        global $smarty;
        $smarty->assign('dataNoti', $dataNoti);
        unset($dataNoti);

    }

    function addedit()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {


            $daneWykonuje = $this->notification->getOsoby();
            $daneStatus = $this->notification->getStatusy();
            $danePriority = $this->notification->getPriority();
            $daneType = $this->notification->getTypy();

            global $smarty;
            $smarty->assign('daneWykonuje', $daneWykonuje);
            $smarty->assign('daneStatus', $daneStatus);
            $smarty->assign('danePriority', $danePriority);
            $smarty->assign('daneType', $daneType);

            if (isset($_POST['serial']) && $_POST['serial']) {

                $printerData = $this->notification->getPrinterDataBySerial($_POST['serial']);

                $smarty->assign('agreementSerial', $_POST['serial']);

                $this->notification->_filedsToEdit['temat']['readonly'] = 1;

                $dane = array(array(
                    'rowid_client' => $printerData[0]['clientid'],
                    'clientdane' => $printerData[0]['clientname'],
                    'serial' => $_POST['serial'],
                    'serialdane' => $_POST['serial'],
                    'rowid_agreements' => $printerData[0]['agreementid'],
                    'umowadane' => $printerData[0]['agreementnumber'],
                    'osobazglaszajaca' => $_SESSION['user']['imie'] . ' ' . $_SESSION['user']['nazwisko'],
                    'email' => $_SESSION['user']['mail'],
                    'nr_telefonu' => null,
                    'sla' => null,
                    'wykonuje' => null,
                    'status' => null,
                    'rowid_priority' => 1,
                    'rowid_type' => 2,
                    'temat' => $_POST['tonertype'] !== 'Wymiana pojemnika' ?
                        'Wymiana tonera ' . $_POST['tonertype'] : 'Wymiana pojemnika na toner',
                    'date_email' => null,
                    'data_planowana' => null,
                    'tresc_wiadomosci' => $_POST['tonertype'] !== 'Wymiana pojemnika' ?
                        'Wymagana jest wymiana tonera ' . $_POST['tonertype'] . '.' :
                        'Wymagana jest wymiana pojemnika na toner',
                    'diagnoza' => null,
                    'cozrobione' => null,
                    'uzyte_materialy' => null,
                    'ilosc_km' => null,
                    'czas_pracy' => null,
                    'wartosc_materialow' => null,
                    'user_podjecia' => null,
                    'date_podjecia' => null,
                    'user_zakonczenia' => null,
                    'date_zakonczenia' => null,
                    'user_insert' => null,
                    'date_insert' => null,
                    'activity' => 1,
                    'user_delete' => null,
                    'date_delete' => null,
                ));
                $smarty->assign('dane', $dane);

                unset($dane);

            } else {
                if ($_POST['keyVal']) {
                    $smarty->assign('agreementSerial', $this->notification->getAgreementSerial($_POST['keyVal'])[0]['serial']);
                }
            }

            parent::addedit();

        } else {
            header("Location: /");
        }
    }

    function save()
    {
        $nameOfModel = ($this->_model);

        $this->$nameOfModel->populateFieldsToSave('_filedsToEdit', '1');
        $this->$nameOfModel->set('czydelete', $_POST['czydelete']);
        $this->_czyjuzpopulate = 1;
        if ($this->$nameOfModel->_filedsToEdit['status']['value'] == '2' && $this->$nameOfModel->_filedsToEdit['user_podjecia']['value'] == '') {
            $this->$nameOfModel->_filedsToEdit['user_podjecia']['value'] = $_SESSION['user']['rowid'];
            $this->$nameOfModel->_filedsToEdit['data_podjecia']['value'] = date('Y-m-d H:i:s');
        }
        if ($this->$nameOfModel->_filedsToEdit['status']['value'] == '3' &&
            ($this->$nameOfModel->_filedsToEdit['ilosc_km']['value'] == '' || $this->$nameOfModel->_filedsToEdit['czas_pracy']['value'] == '' || $this->$nameOfModel->_filedsToEdit['wartosc_materialow']['value'] == '')
        ) {

            echo('Aby zamknąć zleceni muszą być uzupełnione wszystkie pola ( ilość km, czas pracy, wartość materiałów )');
            die();

        }
        if ($this->$nameOfModel->_filedsToEdit['status']['value'] == '3' && $this->$nameOfModel->_filedsToEdit['user_zakonczenia']['value'] == '') {

            $this->$nameOfModel->_filedsToEdit['user_zakonczenia']['value'] = $_SESSION['user']['rowid'];
            $this->$nameOfModel->_filedsToEdit['date_zakonczenia']['value'] = date('Y-m-d H:i:s');
            if ((string)$this->$nameOfModel->_filedsToEdit['email']['value'] != '' && (string)$this->$nameOfModel->_filedsToEdit['rowid']['value'] != '') {
                $mailing = new mailing();
                $mailing->sendMailZakonczono((string)$this->$nameOfModel->_filedsToEdit['rowid']['value'],
                    $this->$nameOfModel->_filedsToEdit['email']['value'],
                    $this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value'],
                    $this->$nameOfModel->_filedsToEdit['temat']['value']);
                unset($mailing);
            }
        }
        $czyjuzbylo = 0;


        if ((string)$this->$nameOfModel->_filedsToEdit['rowid']['value'] != '') {
            $dataWykonuje = $this->$nameOfModel->getWykonuje($this->$nameOfModel->_filedsToEdit['rowid']['value']);
            if (!empty($dataWykonuje) && $dataWykonuje[0]['wykonuje'] != '') {
                $czyjuzbylo = 1;
            }

        }

        $wynik = parent::save();


        if ((string)$this->$nameOfModel->_filedsToEdit['wykonuje']['value'] != '0' && (string)$this->$nameOfModel->_filedsToEdit['wykonuje']['value'] != '' && $czyjuzbylo == 0) {
            $dataMail = $this->$nameOfModel->getMailByRowid($this->$nameOfModel->_filedsToEdit['wykonuje']['value']);
            if (!empty($dataMail) && $dataMail[0]['mail'] != '') {

                if ($this->$nameOfModel->_filedsToEdit['serial']['value'] == '') {
                    $modelurzadzenia = '';
                    $nrseryjny = '';
                    $przebieg = '';
                    $stantonera = '';
                    $adresip = '';
                    $firmware = '';
                    $lokalizacja = '';
                    $clientName = $wynik['clientname'];
                } else {

                    $printer = new printer();
                    $dataPrinter = $printer->getPrinterBySerial($this->$nameOfModel->_filedsToEdit['serial']['value']);


                    $modelurzadzenia = $dataPrinter[0]['model'];
                    $nrseryjny = $this->$nameOfModel->_filedsToEdit['serial']['value'];
                    $przebieg = $dataPrinter[0]['iloscstron_total'];
                    $stantonera = $dataPrinter[0]['black_toner'] . "%";
                    $adresip = $dataPrinter[0]['ip'];
                    $firmware = $dataPrinter[0]['nr_firmware'];
                    $lokalizacja = ($dataPrinter[0]['ulica'] && $dataPrinter[0]['ulica'] !== '') ? $dataPrinter[0]['ulica'] : '';
                    $lokalizacja .= ($dataPrinter[0]['miasto'] && $dataPrinter[0]['miasto'] !== '') ? ', ' . $dataPrinter[0]['miasto'] : '';
                    $lokalizacja .= ($dataPrinter[0]['kodpocztowy'] && $dataPrinter[0]['kodpocztowy'] !== '') ? ' ' . $dataPrinter[0]['kodpocztowy'] : '';

                    $clientName = $dataPrinter[0]['nazwa'];

                    unset($printer);

                }
                $dataZalacznikiFirst = array();


                $dataZalacznikiFirst = $this->$nameOfModel->getZalacznikiPierwszyMail($wynik['keyval']);

                $priority = $this->notification->getPriorityById($this->$nameOfModel->_filedsToEdit['rowid_priority']['value']);
                $priority = (!empty($priority) && $priority[0]['nazwa'] != '') ? $priority[0]['nazwa'] : '';

                $mailing = new mailing();
                $mailing->sendMailPrzydzielonoZlecenie($wynik['keyval'], $dataMail[0]['mail'], nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                    $clientName . " [Ticket#{$wynik['keyval']}] " . $this->$nameOfModel->_filedsToEdit['temat']['value'] . " #Serwis",
                    $clientName,
                    $this->$nameOfModel->_filedsToEdit['osobazglaszajaca']['value'],
                    $this->$nameOfModel->_filedsToEdit['nr_telefonu']['value'], $priority,
                    $modelurzadzenia, $nrseryjny, $lokalizacja, $przebieg, $stantonera, $adresip, $firmware, $this->$nameOfModel->_filedsToEdit['data_planowana']['value'],
                    $dataZalacznikiFirst
                );
                unset($mailing);

            }


        }


        if (isset($wynik['isnew']) && $this->$nameOfModel->_filedsToEdit['email']['value'] != '') {


            if ($this->$nameOfModel->_filedsToEdit['serial']['value'] == '') {
                $modelurzadzenia = '';
                $nrseryjny = '';
                $przebieg = '';
                $stantonera = '';
                $adresip = '';
                $firmware = '';
            } else {

                $printer = new printer();
                $dataPrinter = $printer->getPrinterBySerial($this->$nameOfModel->_filedsToEdit['serial']['value']);


                $modelurzadzenia = $dataPrinter[0]['model'];
                $nrseryjny = $this->$nameOfModel->_filedsToEdit['serial']['value'];
                $przebieg = $dataPrinter[0]['iloscstron_total'];
                $stantonera = $dataPrinter[0]['black_toner'] . "%";
                $adresip = $dataPrinter[0]['ip'];
                $firmware = $dataPrinter[0]['nr_firmware'];

                unset($printer);

            }


            if ($this->$nameOfModel->_filedsToEdit['email']['value'] != '') {


                $mailing = new mailing();
                $mailing->sendMailZarejestrowano($wynik['keyval'], $this->$nameOfModel->_filedsToEdit['email']['value'], nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                    "[Ticket#{$wynik['keyval']}] " . $this->$nameOfModel->_filedsToEdit['temat']['value']);
                unset($mailing);


            }

            $mailing = new mailing();
            $mailing->sendMailInfoNowy($wynik['keyval'], $this->$nameOfModel->_filedsToEdit['date_email']['value'], nl2br($this->$nameOfModel->_filedsToEdit['tresc_wiadomosci']['value']),
                "[Ticket#{$wynik['keyval']}] " . $this->$nameOfModel->_filedsToEdit['temat']['value'],
                $wynik['clientname'],
                $this->$nameOfModel->_filedsToEdit['osobazglaszajaca']['value'],
                $this->$nameOfModel->_filedsToEdit['nr_telefonu']['value'],
                $modelurzadzenia, $nrseryjny, $przebieg, $stantonera, $adresip, $firmware
            );
            unset($mailing);

        }

        echo(json_encode($wynik));
    }

    function shownotpaidinvoices() {
        $clientId = isset($_POST['client_id']) ? $_POST['client_id'] : null;
        if ($clientId) {
            // BOK client
            $client = $this->notification->getClientById($clientId);

            if (!empty($client)) {

                // Fakturownia client
                $client = $this->getClientByTaxNo($client[0]['nip']);

                if (!empty($client)) {
                    global $smarty;

                    $notPaidInvoices = $this->geInvoicesByClientId($client[0]['id'], false);

                    $notPaidInvoices = array_map(function($inv) {
                        $today = new DateTime();
                        $payment_to = new DateTime($inv['payment_to']);
                        $daysDiff =  $today > $payment_to ?
                            $today->diff($payment_to)->format('%a') : 0;

                        return (
                            array(
                                'number' => $inv['number'],
                                'payment_to' => $inv['payment_to'],
                                'late_days' => $daysDiff)
                        );
                    }, $notPaidInvoices);

                    $notPaidInvoices = array_filter($notPaidInvoices, function ($inv) {
                        return $inv['late_days'] > 0;
                    });

                    $smarty->assign('invoices', $notPaidInvoices);

                    unset($notPaidInvoices);
                }
            }
        }
    }
}