<?php

class client extends Model
{
    protected $rowid = 0,
        $nazwakrotka = null, $nazwapelna = null, $ulica = null, $miasto = null, $kodpocztowy = null,
        $nip = null, $terminplatnosci = null, $bank = null, $numerrachunku = null, $opis = null,
        $opiekunklienta = null, $branza = null, $pokaznumerseryjny = null, $pokazstanlicznika = null, $fakturadlakazdejumowy = null,
        $umowazbiorcza = null, $telefon = null, $mail = null, $stanowisko = null, $zamowieniatelefon = null,
        $zamowieniaemail = null, $zamowieniastanowisko = null, $fakturyimienazwisko = null, $mailfaktury = null, $fakturykomorka = null,
        $fakturytelefon = null, $fakturystanowisko = null, $fakturyuwagi = null, $monitoringplatnosci = null, $naliczacodsetki = null,
        $imienazwisko = null, $zamowieniaimienazwisko = null, $fakturyemail = null, $client_id = null;

    protected $filternazwa = '', $filternip = '', $filtermiasto = '', $filterserial = '';

    function delete($rowid)
    {
        return $this->update
        (
            "update clients set activity=0
                                     
                                     where `rowid`=?"
            , 'i',
            array
            (
                $rowid
            )
        );
    }

    function saveupdate()
    {
        $columnList = array();

        if ($this->nazwakrotka !== null)
            array_push($columnList, array('name' => '`nazwakrotka`', 'type' => 's', 'value' => $this->nazwakrotka));
        if ($this->nazwapelna !== null)
            array_push($columnList, array('name' => '`nazwapelna`', 'type' => 's', 'value' => $this->nazwapelna));
        if ($this->ulica !== null)
            array_push($columnList, array('name' => '`ulica`', 'type' => 's', 'value' => $this->ulica));
        if ($this->miasto !== null)
            array_push($columnList, array('name' => '`miasto`', 'type' => 's', 'value' => $this->miasto));
        if ($this->kodpocztowy !== null)
            array_push($columnList, array('name' => '`kodpocztowy`', 'type' => 's', 'value' => $this->kodpocztowy));

        if ($this->nip !== null)
            array_push($columnList, array('name' => '`nip`', 'type' => 's', 'value' => $this->nip));
        if ($this->terminplatnosci !== null)
            array_push($columnList, array('name' => '`terminplatnosci`', 'type' => 'd', 'value' => $this->terminplatnosci));
        if ($this->bank !== null) {
            array_push($columnList, array('name' => '`bank`', 'type' => 's', 'value' => $this->bank));
        } else if ($this->nip !== null && $this->nip !== '0000000000') {
            array_push($columnList, array('name' => '`bank`', 'type' => 's', 'value' => BANK_NAME));
        }
        if ($this->numerrachunku !== null && $this->numerrachunku !== '') {
            array_push($columnList, array('name' => '`numerrachunku`', 'type' => 's', 'value' => $this->numerrachunku));
        } else if ($this->nip !== null && $this->nip !== '0000000000') {
            try {
                $clientIBAN = $this->calculateIBAN( IBAN_PL, IBAN_NUMER_ROZLICZENIOWY_BANKU, IBAN_NUMER_KLIENTA_BANKU, $this->nip);
                array_push($columnList, array('name' => '`numerrachunku`', 'type' => 's', 'value' => $clientIBAN));
            } catch (Exception $e) {
                // nop
            }
        }
        if ($this->opis !== null)
            array_push($columnList, array('name' => '`opis`', 'type' => 's', 'value' => $this->opis));

        if ($this->opiekunklienta !== null)
            array_push($columnList, array('name' => '`opiekunklienta`', 'type' => 's', 'value' => $this->opiekunklienta));
        if ($this->branza !== null)
            array_push($columnList, array('name' => '`branza`', 'type' => 's', 'value' => $this->branza));
        if ($this->pokaznumerseryjny !== null)
            array_push($columnList, array('name' => '`pokaznumerseryjny`', 'type' => 'i', 'value' => $this->pokaznumerseryjny));
        if ($this->pokazstanlicznika !== null)
            array_push($columnList, array('name' => '`pokazstanlicznika`', 'type' => 'i', 'value' => $this->pokazstanlicznika));
        if ($this->fakturadlakazdejumowy !== null)
            array_push($columnList, array('name' => '`fakturadlakazdejumowy`', 'type' => 'i', 'value' => $this->fakturadlakazdejumowy));

        if ($this->umowazbiorcza !== null)
            array_push($columnList, array('name' => '`umowazbiorcza`', 'type' => 'i', 'value' => $this->umowazbiorcza));
        if ($this->telefon !== null)
            array_push($columnList, array('name' => '`telefon`', 'type' => 's', 'value' => $this->telefon));
        if ($this->mail !== null)
            array_push($columnList, array('name' => '`mail`', 'type' => 's', 'value' => $this->mail));
        if ($this->stanowisko !== null)
            array_push($columnList, array('name' => '`stanowisko`', 'type' => 's', 'value' => $this->stanowisko));
        if ($this->zamowieniatelefon !== null)
            array_push($columnList, array('name' => '`zamowieniatelefon`', 'type' => 's', 'value' => $this->zamowieniatelefon));

        if ($this->zamowieniaemail !== null)
            array_push($columnList, array('name' => '`zamowieniaemail`', 'type' => 's', 'value' => $this->zamowieniaemail));
        if ($this->zamowieniastanowisko !== null)
            array_push($columnList, array('name' => '`zamowieniastanowisko`', 'type' => 's', 'value' => $this->zamowieniastanowisko));
        if ($this->fakturyimienazwisko !== null)
            array_push($columnList, array('name' => '`fakturyimienazwisko`', 'type' => 's', 'value' => $this->fakturyimienazwisko));
        if ($this->mailfaktury !== null)
            array_push($columnList, array('name' => '`mailfaktury`', 'type' => 's', 'value' => $this->mailfaktury));
        if ($this->fakturykomorka !== null)
            array_push($columnList, array('name' => '`fakturykomorka`', 'type' => 's', 'value' => $this->fakturykomorka));

        if ($this->fakturytelefon !== null)
            array_push($columnList, array('name' => '`fakturytelefon`', 'type' => 's', 'value' => $this->fakturytelefon));
        if ($this->fakturystanowisko !== null)
            array_push($columnList, array('name' => '`fakturystanowisko`', 'type' => 's', 'value' => $this->fakturystanowisko));
        if ($this->fakturyuwagi !== null)
            array_push($columnList, array('name' => '`fakturyuwagi`', 'type' => 's', 'value' => $this->fakturyuwagi));
        if ($this->monitoringplatnosci !== null)
            array_push($columnList, array('name' => '`monitoringplatnosci`', 'type' => 'i', 'value' => $this->monitoringplatnosci));
        if ($this->naliczacodsetki !== null)
            array_push($columnList, array('name' => '`naliczacodsetki`', 'type' => 'i', 'value' => $this->naliczacodsetki));
        if ($this->imienazwisko !== null)
            array_push($columnList, array('name' => '`imienazwisko`', 'type' => 's', 'value' => $this->imienazwisko));
        if ($this->zamowieniaimienazwisko !== null)
            array_push($columnList, array('name' => '`zamowieniaimienazwisko`', 'type' => 's', 'value' => $this->zamowieniaimienazwisko));
        if ($this->fakturyemail !== null)
            array_push($columnList, array('name' => '`fakturyemail`', 'type' => 's', 'value' => $this->fakturyemail));
        if ($this->client_id !== null) {
            array_push($columnList, array('name' => '`client_id`', 'type' => 's', 'value' => $this->client_id));
        }

        if ($this->rowid == 0) {
            $names = implode(',', array_column($columnList, 'name'));
            $types = implode('', array_column($columnList, 'type'));
            $values = array_column($columnList, 'value');

            return $this->insert($names, $types, $values);
        } else {
            $names = implode(',', array_map(function ($name) {
                return $name . '=?';
            }, array_column($columnList, 'name')));
            // additional element for rowid, used in where phrase
            array_push($columnList, array('type' => 'i', 'value' => $this->rowid));
            $types = implode('', array_column($columnList, 'type'));
            $values = array_column($columnList, 'value');

            return $this->update("update clients set " . $names . "  where `rowid`=?", $types, $values);
        }
    }

    function getClientByRowid($rowid)
    {
        $query = "select * from clients where rowid={$rowid}";
        return $this->query($query, null, false);
    }

    function getClientByNip($clientNip)
    {
        $query = "select * from clients where nip={$clientNip}";
        return $this->query($query, null, false);
    }

    function getRowidByEmail($email)
    {
        $query = "select rowid from clients where mail='{$email}'";
        return $this->query($query, null, false);
    }

    function getRowidByEmailCase($email)
    {
        $query = "select rowid from clients where mail='{$email}' and activity=1";
        return $this->query($query, null, false);
    }

    function getNameByRowid($rowid)
    {
        $query = "select nazwapelna as 'nazwapelna' from clients where rowid='{$rowid}'";
        return $this->query($query, null, false);
    }

    function updateIBANForAllClients($force)
    {
        $query = "select rowid, nip from clients where activity = 1";
        if (!$force) {
            $query .= " and (numerrachunku is null or numerrachunku = '')";
        }
        $clients = $this->query($query, null, false);

        $updatedClients = array();

        foreach ($clients as $client) {
            try {
                $clientIBAN = $this->calculateIBAN(IBAN_PL, IBAN_NUMER_ROZLICZENIOWY_BANKU, IBAN_NUMER_KLIENTA_BANKU, $client['nip']);
                $this->update("update clients set `numerrachunku`=?, `bank`=? where `rowid`=?", 'ssi', array($clientIBAN, BANK_NAME, $client['rowid']));

                $updatedClients[$client['nip']] = BANK_NAME . ' ' . $clientIBAN;
            } catch (Exception $e) {
                return $e;
            }
        }

        return $updatedClients;
    }

    function getClients()
    {

        $where = " where a.rowid!=0 and a.activity=1";

        if ($this->filternazwa != '') {
            $where .= " and ( a.nazwakrotka like '%{$this->filternazwa}%' or a.nazwapelna like '%$this->filternazwa%' )   ";
        }
        if ($this->filtermiasto != '') {
            $where .= " and ( a.miasto like '%{$this->filtermiasto}%')";
        }
        if ($this->filternip != '') {
            $where .= " and ( a.nip like '%{$this->filternip}%')";
        }
        if ($this->filterserial != '') {
            $where .= " and ( b.serial like '%{$this->filterserial}%')";
        }


        $query = "
            select 
            a.*,b.serial,
            (select count(d.rowid) from agreements d where d.rowidclient=a.rowid and d.activity=1) as 'drukumowy',
            (select d.rowid from logs d where d.serial=b.serial and d.przeczytany=0 limit 1) as `blad`
            from 
            (clients a left outer join agreements b on a.rowid=b.rowidclient and b.activity=1)
            {$where} order by a.nazwakrotka";
        return $this->query($query, 'rowid', false);
    }

    function calculateIBAN($countryCode, $bankAccountId, $ownerAccountId, $clientId)
    {
        if (strlen($bankAccountId) !== 8) {
            throw new Exception("Błędny numer rozliczeniowy banku");
        }
        if (strlen($ownerAccountId) !== 4) {
            throw new Exception("Błędny numer identyfikujący firmę");
        }
        $clientId = sprintf("%012s", $clientId);

        $controlNumber = "00";

        $bankAccountIdMod97 = strval(intval($bankAccountId) % 97);

        $ownerAccountIdMod97 = strval(intval($bankAccountIdMod97 . $ownerAccountId) % 97);

        $clientIdMod97 = strval(intval($ownerAccountIdMod97 . $clientId) % 97);

        $IBANMod97 = strval(intval($clientIdMod97 . $countryCode . $controlNumber) % 97);

        $controlNumber = strval(98 - intval($IBANMod97));

        $strIBAN = sprintf("%02s", $controlNumber) . $bankAccountId . $ownerAccountId . $clientId;

        return "{$this->formatIBAN($strIBAN)}";
    }

    function formatIBAN($iban)
    {
        $controlNb = substr($iban, 0, 2);

        $arrAccountNb = str_split(substr($iban, 2, 6 * 4), 4);

        return implode(' ', array($controlNb, implode(' ', $arrAccountNb)));
    }

}