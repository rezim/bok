<?php
class profitability extends Model
{
    protected $dataod='',$datado='',$filterklient='',$filterdrukarka='',$nazwakrotka='';

    function getCostsPerAgreements($dateFrom, $dateTo) {
        $query =
            "SELECT c.nazwakrotka, c.nip, a.nrumowy, a.wartoscurzadzenia, n.serial, ilosc_km, czas_pracy, wartosc_materialow
                from
                agreements a left outer join printers b on a.serial=b.serial
                                left outer join clients c on a.rowidclient=c.rowid
                                left outer join notifications as n on a.serial = n.serial                                 
                WHERE DATE(date_zakonczenia) >= '{$dateFrom}' and 
                      DATE(date_zakonczenia) <= '{$dateTo}' and 
                      c.activity=1
                
                group by n.serial  
                                                
                order by c.nazwakrotka";
        return json_encode($this->query($query,null,false));
    }

    function getCostsPerClients($dateFrom, $dateTo) {
        $query =
            "SELECT c.nazwakrotka, c.nip, sum(a.wartoscurzadzenia) as 'wartosc_urzadzen', 
                    IFNULL(ilosc_km,0) as 'ilosc_km', 
                    IFNULL(czas_pracy, 0) as 'czas_pracy', 
                    IFNULL(wartosc_materialow,0) as 'wartosc_materialow', 
                    IFNULL((ilosc_km + czas_pracy + wartosc_materialow), 0) as 'total'
             FROM
                clients c 
                LEFT OUTER JOIN 
                agreements a on a.rowidclient=c.rowid 
                LEFT OUTER JOIN 
                printers b on a.serial=b.serial
                LEFT OUTER JOIN 
                (
                	SELECT serial, 
                	      (IFNULL(sum(ilosc_km), 0)*(SELECT stawka_kilometrowa from config)) as 'ilosc_km', 
                	      (IFNULL(sum(czas_pracy), 0)*(SELECT stawka_godzinowa from config)) as 'czas_pracy', 
                	       IFNULL(sum(wartosc_materialow), 0) as 'wartosc_materialow'
                	FROM notifications                            
                	WHERE DATE(date_zakonczenia) >= '{$dateFrom}' and 
                      	  DATE(date_zakonczenia) <= '{$dateTo}'
                    GROUP BY serial
                ) n on a.serial = n.serial     
                WHERE c.activity=1                
                GROUP BY c.nip                                                  
                ORDER BY c.nazwakrotka";
        return json_encode($this->query($query,null,false));
    }

    function getInvoices($period, $dateFrom, $dateTo) {
        $invoices = array();

        $ch = curl_init();
        $pageNb = 1;
        do {
          $url = 'http://otus.fakturownia.pl/invoices.json?period=' . $period . '&page='. $pageNb .'&date_from=' . $dateFrom . '&date_to=' . $dateTo . '&api_token=kVWaYhlLHXhWQNKDTSk/OTUS';
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          $data = json_decode(curl_exec($ch), true);

          $invoices = array_merge($invoices, $data);
          $pageNb++;
        } while(count($data) == 50);

        curl_close ($ch);

        return json_encode($invoices);
    }
}