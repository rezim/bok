<?php
class share extends Model
{
    function getUserShares() {
        $query =
            "
              SELECT s.*, rs.permission, rs.rowid_role, r.nazwa as roleName
              FROM `roles_shares` as rs 
                inner join `shares` as s on rs.rowid_share = s.rowid 
                inner join `roles` as r on rs.rowid_role = r.rowid 
              ORDER BY `rs`.`rowid_role` ASC
           ";
        return json_encode($this->query($query,null,false));
    }

    function updatePermission($permission, $rowid, $roleid) {
        return $this->update
        (
            "UPDATE roles_shares SET `permission` = ?  WHERE `rowid_share` = ? AND `rowid_role` = ?"
            ,'sii',
            array
            (
                $permission,
                (int)$rowid,
                (int)$roleid
            )
        );
    }

    function getRoles() {
        return json_encode($this->query("SELECT * FROM `roles`",null,false));
    }

    function addPermission($id, $controller, $action, $description, $activity, $rolerowid, $permission) {
        $sharesColumnList = "`id`,
                       `controller`,
                       `action`,
                       `nazwa`,
                       `activity`";

        $rolesSharesColumnList = "`rowid_role`,
                                  `rowid_share`,
                                  `permission`";


        $shareExists = $this->query("SELECT rowid FROM `shares` WHERE id = '{$id}'", null, false);
        $rowid = null;
        if (count($shareExists) > 0) {
            $rowid = $shareExists[0]['rowid'];
        } else {
            $this->_table = 'shares';
            $result = $this->insert($sharesColumnList, 'ssssi', array($id, $controller, $action, $description, $activity));
            $rowid = $result['status'] ? $result['keyval'] : null;
        }
        if ($rowid) {
            $this->_table = 'roles_shares';

            $roleExists = $this->query("SELECT $rolerowid, $rowid FROM `roles_shares` WHERE rowid_role = '{$rolerowid}' AND rowid_share = '{$rowid}'", null, false);

            if (count($roleExists) == 0) {
                $result = $this->insert($rolesSharesColumnList, 'iis', array($rolerowid, $rowid, $permission));
            } else {
                $result = Array('info' => 'Rola już istnieje');
            }
        }

        return $result;
    }


    function removePermission($rowid, $role) {
        $result = $this->update("DELETE FROM `roles_shares` WHERE rowid_share = ? AND rowid_role = ?", 'ss', array($rowid, $role));
        if ($result['status']) {

            $remainingRoleShares = $this->query("SELECT * FROM `roles_shares` WHERE rowid_share = '{$rowid}'", null, false);

            if (count($remainingRoleShares) == 0) {
                $result = $this->update("DELETE FROM `shares` WHERE rowid = ?", 's', array($rowid));
            }
        }

        if ($result['status']) {
            $result['info'] = 'Dane usunięte poprawnie';
        }

        return $result;
    }
}