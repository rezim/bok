<?php

class config extends Model
{

    protected $stawkakilometrowa = null, $stawkagodzinowa = null, $czassesjiminut = null, $emailraportuplatnosci = null;

    function getConfiguration()
    {
        $query = "select * from config";
        return $this->query($query, null, false);
    }


    function clearPaymentsMonitoring()
    {
        return $this->update
        (
            "update `clients` 
                   set `monitoringplatnosci`=?", 'i',
            array
            (
                0
            ));
    }


    function saveConfiguration() {
        $columnList = array();

        if ($this->stawkakilometrowa !== null) {
            array_push($columnList, array('name' => '`stawka_kilometrowa`', 'type' => 'd', 'value' => $this->stawkakilometrowa));
        }
        if ($this->stawkagodzinowa !== null) {
            array_push($columnList, array('name' => '`stawka_godzinowa`', 'type' => 'd', 'value' => $this->stawkagodzinowa));
        }

        if ($this->czassesjiminut !== null) {
            array_push($columnList, array('name' => '`czas_sesji_minut`', 'type' => 'd', 'value' => $this->czassesjiminut));
        }

        if ($this->emailraportuplatnosci !== null) {
            array_push($columnList, array('name' => '`email_raportu_platnosci`', 'type' => 's', 'value' => $this->emailraportuplatnosci));
        }

        $names = implode(',', array_map(function ($name) {
            return $name . '=?';
        }, array_column($columnList, 'name')));

        $types = implode('', array_column($columnList, 'type'));
        $values = array_column($columnList, 'value');

        return $this->update("update config set " . $names, $types, $values);
    }
}