<?php
class message extends Model
{
    protected $message='', $rowid='', $date, $type, $foreignkey = null;

    function getMessages() {

        $where = "WHERE active = 1 and type = $this->type";
        if ($this->foreignkey !== null && $this->foreignkey !== '') {
            $where .=  " and foreign_key = '" . $this->foreignkey ."'";
        } else {
            $where .=  " and foreign_key is NULL";
        }

        $query = "
                SELECT m.*, u.imie, u.nazwisko FROM `messages` m inner join `users` u on m.owner = u.id 
                " . $where . " 
                ORDER BY created desc
              ";
        return $this->query($query,null,false);
    }

    function saveupdate() {
        $columnList = "`message`,`owner`, `type`, `message_date`, `foreign_key`";
        return $this->insert($columnList,'ssdss',array($this->message, $_SESSION['user']['id'], $this->type, $this->date, $this->foreignkey));
    }

    function remove() {
        return $this->update
        (
            "update `messages` 
                   set `active`=0
                   where `rowid`=?"
            ,'i',
            array
            (
                $this->rowid
            )
        );
    }
}