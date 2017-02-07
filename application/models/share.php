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

    function updatePermission($permission, $rowid) {
        return $this->update
        (
            "UPDATE roles_shares SET `permission` = ? WHERE `rowid_share` = ?"
            ,'si',
            array
            (
                $permission,
                (int)$rowid
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

        $this->_table = 'shares';
        $result = $this->insert($sharesColumnList, 'ssssi', array($id, $controller, $action, $description, $activity));

        if ($result['status']) {
            $this->_table = 'roles_shares';

            $result = $this->insert($rolesSharesColumnList, 'iis', array($rolerowid, $result['keyval'], $permission));
        }

        return $result;
    }


    function removeShare($rowid) {

    }
}