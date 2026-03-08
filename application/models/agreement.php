<?php

class agreement extends Model
{
    protected $rowid = 0, $nrumowy = '', $dataod = '', $datado = '', $stronwabonamencie = '', $cenazastrone = '', $serial = '',
        $rowidclient = '', $opis = '', $rozliczenie = '', $abonament = '', $kwotawabonamencie = '', $odbiorca_id,
        $iloscstron_kolor = '',
        $cenazastrone_kolor = '',
        $iloscskanow = '',
        $cenazaskan = '',
        $cenainstalacji = '',
        $rabatdoabonamentu = '',
        $rabatdowydrukow = '',
        $prowizjapartnerska = '',
        $sla = '',
        $wartoscurzadzenia = '', $jakczarne = '', $rowid_type, $activity, $selectedStatuses;
    protected $filternrumowy = '', $filterserial = '', $filternazwaklienta = '', $clientrowid = '';

    protected $prtcntrowid = 0,
        $counterstart, $countercolorstart, $counterscansstart, $datacounterstart,
        $counterend, $countercolorend, $counterscansend, $datacounterend;

    function delete()
    {
        $result = $this->update
        (
            "UPDATE agreements AS a
                   JOIN printers AS p ON a.serial = p.serial
                   SET a.activity = 0,
                        p.lokalizacja = NULL,
                        p.ulica = NULL,
                        p.miasto = NULL,
                        p.kodpocztowy = NULL,
                        p.telefon = NULL,
                        p.mail = NULL,
                        p.nazwa = NULL,
                        p.osobakontaktowa = NULL,
                        p.address_ip = NULL
                   WHERE a.rowid = ?;"
            , 'i',
            array
            (
                $this->rowid
            )
        );
        $this->updateAgreementPrinters();
        return $result;
    }

    function getAgreements($canListActive, $canListDraft, $canListClosed)
    {

        $availableStatuses = [];

        if ($canListActive) {
            $availableStatuses[] = 1;
        }
        if ($canListDraft) {
            $availableStatuses[] = -1;
        }
        if ($canListClosed) {
            $availableStatuses[] = 0;
        }

        $where = '';

        if ($this->selectedStatuses !== '') {
            $selectedStatuses = array_filter(
                array_map('intval', explode(',', $this->selectedStatuses)),
                fn($s) => in_array($s, [-1, 0, 1], true)
            );

            $statuses = array_values(array_intersect($availableStatuses, $selectedStatuses));

            if (!empty($statuses)) {
                $in = implode(', ', $statuses);
                $where = "WHERE a.activity IN ($in)";
            } else {
                // Nie ma wspólnych statusów między UI a dostępem
                $where = "WHERE a.activity NOT IN (-1, 0, 1)";
            }
        } else {
            // [TODO TR]: not sure if this is needed
//            if (!empty($availableStatuses)) {
//                $in = implode(', ', $availableStatuses);
//                $where = "WHERE a.activity IN ($in)";
//            } else {
                $where = "WHERE a.activity NOT IN (-1, 0, 1)";
//            }
        }

        if ($this->filternrumowy != '') {
            $where .= " and ( a.nrumowy like '%{$this->filternrumowy}%')   ";
        }
        if ($this->filterserial != '') {
            $where .= " and ( a.serial like '%{$this->filterserial}%' or b.model like '%{$this->filterserial}%')";
        }
        if ($this->filternazwaklienta != '') {
            $where .= " and ( c.nazwakrotka like '%{$this->filternazwaklienta}%' || c.nazwapelna like '%{$this->filternazwaklienta}%')";
        }
        if ($this->clientrowid != '') {
            $where .= " and ( a.rowidclient = {$this->clientrowid})   ";
        }

        $query = "  
                select 
                a.nrumowy as 'nrumowy',
                a.dataod as 'dataod',
                a.datado as 'datado',
                a.stronwabonamencie as 'stronwabonamencie',
                a.cenazastrone as 'cenazastrone',
                a.rowid as 'rowid',
                a.`serial` as 'serial',
                a.odbiorca_id as 'odbiorca_id',
                b.model as 'model',
                c.nazwakrotka as 'nazwakrotka',
                a.rowidclient as 'rowidclient',
                a.rozliczenie as `rozliczenie`,
                a.abonament as 'abonament',
                a.kwotawabonamencie as 'kwotawabonamencie',
                a.sla as 'sla',
                t.description as 'type',
                aa.nrumowy as 'umowazbiorcza',
                a.activity,
                (select d.rowid from logs d where d.serial=a.serial and d.przeczytany=0 limit 1) as `blad`,a.abonament
                from
                (agreements a left outer join printers b on a.`serial`=b.`serial` left outer join agreement_type t on a.rowid_type=t.rowid
                 left outer join agreements aa on a.rowidumowazbiorcza = aa.rowid)
                left outer join clients c on a.rowidclient=c.rowid  and c.activity=1  
                {$where}
                order by c.nazwakrotka asc
        ";
        return $this->query($query, null, false);
    }

    function saveupdate()
    {
        if ($this->rowid != 0) {
            $result = $this->update
            (
                "update agreements
                                     set 
                                    `nrumowy`=?,
                                    `dataod`=?,
                                    `datado`=?,
                                    `stronwabonamencie`=?,
                                    `cenazastrone`=?,
                                    `abonament`=?,
                                    `kwotawabonamencie`=?,
                                    `dateinsert`=?,
                                    `serial`=?,
                                    `rowidclient`=?,
                                    `odbiorca_id`=?,
                                    `opis`=?,
                                    `rozliczenie`=?,
                                    `iloscstron_color`=?,
                                    `cenazastrone_kolor`=?,
                                    `iloscskans`=?,
                                    `cenazascan`=?,
                                    `cenainstalacji`=?,
                                    `rabatdoabonamentu`=?,
                                    `rabatdowydrukow`=?,
                                    `prowizjapartnerska`=?,
                                    `sla`=?,
                                    `wartoscurzadzenia`=?,
                                    `jakczarne`=?,
                                    `rowid_type`=?,
                                    `activity`= ?
                                     where `rowid`=?"
                , 'sssidddssisssidddddddidiiii',
                array
                (
                    $this->nrumowy == '' ? "NULL" : $this->nrumowy,
                    ($this->dataod == '' || $this->dataod == '0000-00-00') ? "NULL" : $this->dataod,
                    ($this->datado == '' || $this->datado == '0000-00-00') ? "NULL" : $this->datado,
                    $this->stronwabonamencie == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->stronwabonamencie)),
                    $this->cenazastrone == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazastrone)),
                    $this->abonament == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->abonament)),
                    $this->kwotawabonamencie == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->kwotawabonamencie)),
                    date('Y-m-d H:i:s'),
                    $this->serial == '' ? "NULL" : $this->serial,
                    $this->rowidclient == '' ? "NULL" : $this->rowidclient,
                    $this->odbiorca_id == '' ? "NULL" : $this->odbiorca_id,
                    $this->opis == '' ? "NULL" : $this->opis,
                    $this->rozliczenie == '' ? "NULL" : $this->rozliczenie,
                    $this->iloscstron_kolor == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->iloscstron_kolor)),
                    $this->cenazastrone_kolor == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazastrone_kolor)),
                    $this->iloscskanow == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->iloscskanow)),
                    $this->cenazaskan == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazaskan)),
                    $this->cenainstalacji == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenainstalacji)),
                    $this->rabatdoabonamentu == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->rabatdoabonamentu)),
                    $this->rabatdowydrukow == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->rabatdowydrukow)),
                    $this->prowizjapartnerska == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->prowizjapartnerska)),
                    $this->sla == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->sla)),
                    $this->wartoscurzadzenia == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->wartoscurzadzenia)),
                    $this->jakczarne == '' ? "NULL" : $this->jakczarne,
                    $this->rowid_type == '' ? "1" : $this->rowid_type,
                    $this->activity,
                    $this->rowid
                )
            );

        } else {

            $columnList = "`nrumowy`,
                            `dataod`,
                            `datado`,
                            `stronwabonamencie`,
                            `cenazastrone`,
                            `abonament`,
                            `kwotawabonamencie`,
                            `serial`,
                            `rowidclient`,`odbiorca_id`,`dateinsert`,`opis`,`rozliczenie`,
                             `iloscstron_color`,
                                    `cenazastrone_kolor`,
                             `iloscskans`,
                                    `cenazascan`,                                    
                                    `cenainstalacji`,
                                    `rabatdoabonamentu`,
                                    `rabatdowydrukow`,
                                    `prowizjapartnerska`,
                                    `sla`,
                                    `wartoscurzadzenia`,
                                    `jakczarne`,
                                    `rowid_type`,
                                    `activity`
                            ";
            $this->_table = 'agreements';
            $result = $this->insert($columnList, 'sssidddsissssidddddddidiii',
                array(
                    $this->nrumowy == '' ? "NULL" : $this->nrumowy,
                    ($this->dataod == '' || $this->dataod == '0000-00-00') ? "NULL" : $this->dataod,
                    ($this->datado == '' || $this->datado == '0000-00-00') ? "NULL" : $this->datado,
                    $this->stronwabonamencie == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->stronwabonamencie)),
                    $this->cenazastrone == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazastrone)),
                    $this->abonament == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->abonament)),
                    $this->kwotawabonamencie == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->kwotawabonamencie)),
                    $this->serial == '' ? "NULL" : $this->serial,
                    $this->rowidclient == '' ? "NULL" : $this->rowidclient,
                    $this->odbiorca_id == '' ? "NULL" : $this->odbiorca_id,
                    date('Y-m-d H:i:s'), $this->opis == '' ? "NULL" : $this->opis, $this->rozliczenie == '' ? "NULL" : $this->rozliczenie,
                    $this->iloscstron_kolor == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->iloscstron_kolor)),
                    $this->cenazastrone_kolor == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazastrone_kolor)),
                    $this->iloscskanow == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->iloscskanow)),
                    $this->cenazaskan == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenazaskan)),
                    $this->cenainstalacji == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->cenainstalacji)),
                    $this->rabatdoabonamentu == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->rabatdoabonamentu)),
                    $this->rabatdowydrukow == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->rabatdowydrukow)),
                    $this->prowizjapartnerska == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->prowizjapartnerska)),
                    $this->sla == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->sla)),
                    $this->wartoscurzadzenia == '' ? "NULL" : str_replace(' ', '', str_replace(',', '.', $this->wartoscurzadzenia)),
                    $this->jakczarne == '' ? "NULL" : $this->jakczarne,
                    $this->rowid_type == '' ? "1" : $this->rowid_type,
                    $this->activity
                ));

            $this->rowid = isset($result) ? $result['rowid'] : 0;
        }


        $this->updateAgreementPrinters();

        return $result;
    }


    function updateAgreementPrinters()
    {
        if ($this->rowid && $this->serial) {
            if (!$this->prtcntrowid) {
                $columnList = "
            `rowid_agreement`,
            `serial`,
            `date_start`,
            `date_koniec`,
            `ilosc_start`,
            `ilosc_koniec`,
            `ilosckolor_start`,
            `ilosckolor_koniec`,
            `iloscskans_start`,
            `iloscskans_koniec`";
                $this->_table = 'agreement_printers';
                $this->insert($columnList, "isssiiiiii", array(
                    $this->rowid,
                    $this->serial,
                    ($this->datacounterstart == '' || $this->datacounterstart == '0000-00-00') ? "NULL" : $this->datacounterstart,
                    ($this->datacounterend == '' || $this->datacounterend == '0000-00-00') ? "NULL" : $this->datacounterend,
                    str_replace(' ', '', $this->counterstart),
                    str_replace(' ', '', $this->counterend),
                    str_replace(' ', '', $this->countercolorstart),
                    str_replace(' ', '', $this->countercolorend),
                    str_replace(' ', '', $this->counterscansstart),
                    str_replace(' ', '', $this->counterscansend),
                ));

                // update agreement in pages (counters table) to reflect agreement start date
                if (!($this->datacounterstart == '' || $this->datacounterstart == '0000-00-00')) {
                    $this->update("update pages set `rowid_agreement`=? where `serial`=? and `datawiadomosci` >=?", 'iss', array($this->rowid, $this->serial, $this->datacounterstart));
                    $this->update("update scans set `rowid_agreement`=? where `serial`=? and `datawiadomosci` >=?", 'iss', array($this->rowid, $this->serial, $this->datacounterstart));
                }
            } else {
                $this->update("update agreement_printers 
                                         set `date_start`=?,
                                             `date_koniec`=?,
                                             `ilosc_start`=?,
                                             `ilosc_koniec`=?,
                                             `ilosckolor_start`=?,
                                             `ilosckolor_koniec`=?,
                                             `iloscskans_start`=?,
                                             `iloscskans_koniec`=?
                                         where `rowid`=?",
                    'ssiiiiiii',
                    array(
                        ($this->datacounterstart == '' || $this->datacounterstart == '0000-00-00') ? "NULL" : $this->datacounterstart,
                        ($this->datacounterend == '' || $this->datacounterend == '0000-00-00') ? "NULL" : $this->datacounterend,
                        str_replace(' ', '', $this->counterstart),
                        str_replace(' ', '', $this->counterend),
                        str_replace(' ', '', $this->countercolorstart),
                        str_replace(' ', '', $this->countercolorend),
                        str_replace(' ', '', $this->counterscansstart),
                        str_replace(' ', '', $this->counterscansend),
                        $this->prtcntrowid
                    )
                );
            }
        }
    }

    function getAgreementPrinterCounters($rowid, $serial)
    {
        $query = "select * from agreement_printers where rowid_agreement={$rowid} and serial='{$serial}'";
        return $this->query($query, null, false);
    }

    function getAgreementTypes()
    {
        $query = "select * from agreement_type";
        return $this->query($query, null, false);
    }

    function getUmowaByRowid($rowid)
    {
        $query = "select * from agreements where rowid={$rowid}";
        return $this->query($query, null, false);
    }

    function getPriceHistoryByAgreementRowid($rowid)
    {
        $rowid = (int)$rowid;
        $query = "SELECT
                    h.id,
                    h.rowid_agreement,
                    h.valid_from,
                    h.valid_to,
                    h.cenazastrone,
                    h.cenazastrone_kolor,
                    h.abonament,
                    h.indexation_percent,
                    h.reason,
                    h.created_at
                  FROM agreements_price_history h
                  WHERE h.rowid_agreement = {$rowid}
                  ORDER BY h.valid_from DESC, h.id DESC";

        return $this->query($query, null, false);
    }

    function getUmowaByClient($rowidClient)
    {
        $query = "select rowid from agreements where rowidclient={$rowidClient} and activity=1";
        return $this->query($query, null, false);
    }

    function getUmowaByPrinter($serial)
    {
        $query = "select rowid from agreements where serial='{$serial}' and activity=1";
        return $this->query($query, null, false);
    }


    function getUmowaCheck($id) {
        $query = "SELECT ac.*, 
            CASE WHEN ac.client_type = 'google' THEN g.nazwa_firmy ELSE c.nazwakrotka END as Najemca,
            CASE WHEN ac.client_type = 'google' THEN g.reprezentant ELSE 'Zgodnie z KRS' END as Reprezentant,
            CASE WHEN ac.client_type = 'google' THEN g.adres_siedziby ELSE CONCAT(c.ulica, ', ', c.kodpocztowy, ' ', c.miasto) END as Adres_Siedziby,
            CASE WHEN ac.client_type = 'google' THEN g.nip ELSE c.nip END as NIP,
            CASE WHEN ac.client_type = 'google' THEN g.krs_pesel ELSE '' END as KRS_PESEL,
            CASE WHEN ac.client_type = 'google' THEN g.email_faktury ELSE '' END as Email_Faktury,
            CASE WHEN ac.client_type = 'google' THEN g.adres_instalacji ELSE '' END as Adres_Instalacji,
            CASE WHEN ac.client_type = 'google' THEN g.osoba_wniesienie ELSE '' END as Pomoc_Wniesienie
            FROM agreements_check ac
            LEFT JOIN clients_google_form g ON ac.client_rowid = g.id AND ac.client_type = 'google'
            LEFT JOIN clients c ON ac.client_rowid = c.rowid AND ac.client_type = 'permanent'
            WHERE ac.id = {$id} LIMIT 1;";
        return $this->query($query, null, false);
    }
}