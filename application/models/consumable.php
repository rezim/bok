<?php

class consumable extends Model
{
    protected $rowid = 0, $filtername = '', $filtermodel = '';

    function delete($rowid)
    {
        return $this->update("DELETE FROM `notifications_consumables` WHERE rowid = ?", 'd', array($rowid));
    }

    function saveupdate($rowid, $name, $model, $yield, $price)
    {

        if ($rowid == '0') {
            $query = "select * from notifications_consumables where name='{$name}' and model='{$model}'";

            if (empty($this->query($query, null, false))) {
                $this->_table = 'notifications_consumables';
                return $this->insert("`name`, `model`, `yield`, `price`", 'ssdd', array($name, $model, $yield, $price));
            } else {
                return array('status' => 0, 'info' => 'Taki materiał już istnieje');
            }
        } else {
            return $this->update
            (
                "update `notifications_consumables` 
                   set 
                   `name`=?, 
                   `model`=?,
                   `yield`=?,
                   `price`=?
                   where `rowid`=?"
                ,'ssddi',
                array
                (
                    $name=='' ? "NULL":$name,
                    $model=='' ? "NULL":$model,
                    $yield=='' ? "NULL":$yield,
                    $price=='' ? "NULL":$price,
                    $rowid
                )
            );
        }
    }

    function getConsumableByRowid($rowid)
    {
        $query = "select *
            from notifications_consumables
            where rowid={$rowid}";
        return $this->query($query, null, false);
    }

    function getConsumables()
    {
        $query = "select * from notifications_consumables";

        $where = '';

        if ($this->filtername != '') {
            if ($where !== '') {
                $where .= ' and ';
            }

            $where .= "(name like '%{$this->filtername}%')";
        }
        if ($this->filtermodel != '') {
            if ($where !== '') {
                $where .= ' and ';
            }

            $where .= "(model like '%{$this->filtermodel}%')";
        }

        if ($where !== '') {
            $query .= ' where ' . $where;
        }

        return $this->query($query, null, false);

    }
}