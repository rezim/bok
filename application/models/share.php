<?php
class share extends Model
{
    function getUserShares() {
        $query =
            "
              SELECT s.*, rs.permission, rs.rowid_role, r.nazwa 
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

    function removeShare($rowid) {

    }
}