<?php
class messagesinvoice extends Model
{
    protected $message='', $rowid='';

    function getMessages() {
        $query = "
                SELECT * FROM `messages`
                WHERE active = 1 and type = 1
                ORDER BY created desc
              ";
        return $this->query($query,null,false);
    }

    function saveupdate() {
        $columnList = "`message`,`owner`, `type`";
        return $this->insert($columnList,'ssd',array($this->message, $_SESSION['user']['id'], 1));
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