<?php
class messagesinvoice extends Model
{
    protected $message='', $rowid='';

    function getMessages() {
        $query = "
                SELECT m.*, u.imie as imie, u.nazwisko as nazwisko FROM `messages` m inner join `users` u on m.owner = u.id 
                WHERE active = 1 and type = 1
                ORDER BY created desc
              ";
        return $this->query($query,null,false);
    }

    function saveupdate() {
        $columnList = "`message`,`owner`, `type`";
        $this->_table = 'messages';
        return $this->insert($columnList,'ssd',array($this->message, $_SESSION['user']['id'], "1"));
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