<?php

class consumable extends Model
{
    protected $rowid = 0, $filtername = '', $filtermodel = '';

    function delete($rowid)
    {
        return $this->update("DELETE FROM `consumables` WHERE rowid = ?", 'd', array($rowid));
    }

    function saveupdate($rowid, $code, $name, $model, $yield, $price)
    {

        if ($rowid == '') {
            $query = "select * from consumables where name='{$name}' and code='{$code}'";

            if (empty($this->query($query, null, false))) {
                $this->_table = 'consumables';
                $result = $this->insert("`code`, `name`, `yield`, `price`", 'ssdd', array($code, $name, $yield, $price));

                if ($result['status'] === 1) {
                    $this->_table = 'consumables_model';
                    foreach ($model as &$mdl) {
                        $this->insert("`rowid_consumables`,`model`", 'ds', array((int) $result['rowid'], $mdl));
                    }
                }
                return $result;
            } else {
                return array('status' => 0, 'info' => 'Taki materiał już istnieje');
            }
        } else {
            $result = $this->update
            (
                "update `consumables` 
                   set
                   `code`=?,
                   `name`=?,
                   `yield`=?,
                   `price`=?
                   where `rowid`=?"
                , 'ssddi',
                array
                (
                    $code == '' ? "NULL" : $code,
                    $name == '' ? "NULL" : $name,
                    $yield == '' ? "NULL" : $yield,
                    $price == '' ? "NULL" : $price,
                    $rowid
                )
            );

            $this->update("DELETE FROM `consumables_model` WHERE rowid_consumables = ?", 'd', array($rowid));
            $this->_table = 'consumables_model';
            foreach ($model as &$mdl) {
                $this->insert("`rowid_consumables`,`model`", 'ds', array($rowid, $mdl));
            }

            return $result;
        }
    }

    function getConsumableByRowid($rowid)
    {
        $query = "SELECT c.*, GROUP_CONCAT(cm.model SEPARATOR ',') AS models
                  FROM `consumables` as c inner join `consumables_model` as cm on c.rowid = cm.rowid_consumables
                  WHERE c.rowid={$rowid}";

        return $this->query($query, null, false);
    }

    function getConsumables()
    {

        $query = "SELECT c.*, GROUP_CONCAT(cm.model SEPARATOR ',') AS models FROM `consumables` as c inner join `consumables_model` as cm on c.rowid = cm.rowid_consumables";

        $where = '';

        if ($this->filtername != '') {
            if ($where !== '') {
                $where .= ' and ';
            }

            $where .= "(c.name like '%{$this->filtername}%')";
        }
        if ($this->filtermodel != '') {
            if ($where !== '') {
                $where .= ' and ';
            }

            $where .= "(cm.model like '%{$this->filtermodel}%')";
        }

        if ($where !== '') {
            $query .= ' where ' . $where;
        }

        $query .= ' group by c.rowid';

        return $this->query($query, null, false);

    }
}