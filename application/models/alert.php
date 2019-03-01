<?php
class alert extends Model
{
    function getAlerts()
    {
        $days = 30;
        $toner_left = 10;
        $query =
            "
            Select t.serial, t.toner_type, t.date, t.toner_left, p.model, p.product_number, p.ulica, p.miasto, p.kodpocztowy, p.telefon, p.mail, p.nazwa, p.osobakontaktowa, n.rowid as notification_rowid From 
            (
            SELECT l1.serial as serial, l2.toner as toner_type, l1.dateinsert as date, '" . $toner_left ."' as toner_left from `logs` l1
            INNER JOIN (
                SELECT MAX(dateinsert) as maxdateinsert, serial, eventcode, 
                    IF(INSTR(eventcode, 'Cyan') > 0, 'Cyan', 
                       IF(INSTR(eventcode, 'Magenta') > 0, 'Magenta', 
                          IF(INSTR(eventcode, 'Zolty') > 0, 'Yellow', 'Black'))
                    ) as toner
                FROM `logs`
                WHERE dateinsert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days ." DAY) AND NOW()
                      and eventcode like '%Uzupe%nij toner%' 
                GROUP BY serial, eventcode
            ) l2 
            ON 
            l1.serial = l2.serial and l1.eventcode = l2.eventcode and l1.dateinsert = l2.maxdateinsert
            
            UNION 
            
            select serial, 'Black' as toner_type, date_insert as date, black_toner as toner_left
            from printers
            where black_toner <= " . $toner_left . " and date_insert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND NOW()
            ) t
            
            INNER JOIN printers p on p.serial = t.serial
            
            INNER JOIN agreements a on a.serial = p.serial 
            
            LEFT JOIN 
            
            (SELECT rowid, serial, replace(temat, 'Wymiana tonera ', '') as temattoner FROM `notifications`
			where temat in ('Wymiana tonera Black', 'Wymiana tonera Magenta', 'Wymiana tonera Cyan', 'Wymiana tonera Yellow')
      		AND date_insert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND NOW()) n 
            
            ON p.serial = n.serial and n.temattoner like t.toner_type
            
            WHERE a.activity = 1
            
            order by t.date desc
            ";
        return $this->query($query,null,false);

    }

}