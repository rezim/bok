<?php
class clientinvoice extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';


    function getAgreements() {
        $query =
            "select c.nazwakrotka as client_name, c.nip as client_nip, a.nrumowy as agreement_id,
                    a.rowid as agreement_rowid, c.terminplatnosci as agreement_paymentdate,
                    a.activity as agreement_isactive
             from agreements a inner join clients c on a.rowidclient = c.rowid
             order by nazwakrotka";
        return json_encode($this->query($query,null,false));
    }

//    function getAgreementNotifications($dateFrom, $dateTo, $rowagreement_id) {
//        $query =
//            "
//            SELECT n.*, p.model, (IFNULL(ilosc_km, 0)*(SELECT stawka_kilometrowa from config)) as 'koszt_ilosc_km',
//                            (IFNULL(czas_pracy, 0)*(SELECT stawka_godzinowa from config)) as 'koszt_czas_pracy',
//                            IFNULL(wartosc_materialow, 0) as 'koszt_wartosc_materialow'
//            FROM `notifications` n LEFT OUTER JOIN `printers` p on n.serial = p.serial
//            WHERE n.rowid_agreements = {$rowagreement_id} and
//                DATE(n.date_zakonczenia) >= '{$dateFrom}' and
//                DATE(n.date_zakonczenia) <= '{$dateTo}'
//            ORDER BY date_zakonczenia DESC
//           ";
//        return json_encode($this->query($query,null,false));
//    }

//    function getOveralCosts($dateFrom, $dateTo) {
//        $query =
//            "
//            SELECT c.nazwakrotka as 'client_name', c.nip as 'client_nip', a.activity as 'agreement_isActive', a.rowid as 'client_agreement_id', a.nrumowy as 'client_agreement_rowid', p.model as 'printer_model', a.wartoscurzadzenia as 'client_agreement_value_unit', costs.*
//            FROM clients c LEFT OUTER JOIN agreements a on c.rowid = a.rowidclient LEFT OUTER JOIN printers p on a.serial = p.serial
//            LEFT OUTER JOIN (
//                        SELECT
//                            c.nip as 'nip',
//                            a.nrumowy as 'agreement_id',
//                            n.rowid_agreements as 'agreement_rowid',
//                            a.dataod as 'agreement_startDate',
//                            a.datado as 'agreement_endDate',
//                            n.serial as 'device_sn',
//                            (IFNULL(sum(ilosc_km), 0)*(SELECT stawka_kilometrowa from config)) as 'ilosc_km',
//                            (IFNULL(sum(czas_pracy), 0)*(SELECT stawka_godzinowa from config)) as 'czas_pracy',
//                            IFNULL(sum(wartosc_materialow), 0) as 'wartosc_materialow',
//                            IFNULL(a.wartoscurzadzenia, 0) as 'wartosc_urzadzenia'
//                        FROM
//                            notifications n
//                            LEFT OUTER JOIN
//                            agreements a on a.rowid = n.rowid_agreements
//                            LEFT OUTER JOIN
//                            clients c on c.rowid = a.rowidclient
//                        WHERE
//                            DATE(date_zakonczenia) >= '{$dateFrom}' and
//                            DATE(date_zakonczenia) <= '{$dateTo}'
//                        GROUP BY n.serial, n.rowid_agreements
//                ) AS costs ON c.nip = costs.nip and a.rowid = costs.agreement_rowid
//            WHERE (a.activity = 1 || a.activity = 0)
//            ORDER BY client_name, costs.agreement_rowid
//           ";
//        return json_encode($this->query($query,null,false));
//    }

//    function getInvoices($period, $dateFrom, $dateTo) {
//        $invoices = array();
//
//        $ch = curl_init();
//        $pageNb = 1;
//        do {
//          $url = FAKTUROWNIA_ENDPOINT . '/invoices.json?period=' . $period . '&page='. $pageNb .'&date_from=' . $dateFrom . '&date_to=' . $dateTo . '&api_token=' . FAKTUROWNIA_APITOKEN;
//          curl_setopt($ch, CURLOPT_URL, $url);
//          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//          $data = json_decode(curl_exec($ch), true);
//
//          $invoices = array_merge($invoices, $data);
//          $pageNb++;
//        } while(count($data) == 50);
//
//        curl_close ($ch);
//
//        return json_encode($invoices);
//    }
}