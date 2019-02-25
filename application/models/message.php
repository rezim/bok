<?php
class message extends Model
{
    protected $message='', $rowid='';

    function getMessages() {
        $query = "
                SELECT * FROM `messages`
                WHERE active = 1 
                ORDER BY created desc
              ";
        return $this->query($query,null,false);
    }

    function saveupdate() {
        $columnList = "`message`,`owner`";
        return $this->insert($columnList,'ss',array($this->message, $_SESSION['user']['id']));
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