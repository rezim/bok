<?php
class alert extends Model
{
    function getAlerts()
    {
        $days = 30;
        $toner_left = 10;
        $query =
            "
            Select t.serial, t.toner_type, t.date, t.toner_left, p.model, p.product_number, c.ulica, c.miasto, c.kodpocztowy, c.telefon, c.mail, c.nazwakrotka as nazwa, c.zamowieniaimienazwisko as osobakontaktowa, n.rowid as notification_rowid From 
            (
            SELECT l1.serial as serial, l2.toner as toner_type, l1.timestamp as date, '" . $toner_left ."' as toner_left from `logs` l1
            INNER JOIN (
                SELECT MAX(timestamp) as maxtimestamp, serial, eventcode, 
                    IF(INSTR(eventcode, 'Cyan') > 0, 'Cyan', 
                       IF(INSTR(eventcode, 'Magenta') > 0, 'Magenta', 
                          IF(INSTR(eventcode, 'Zolty') > 0, 'Yellow',
                           IF(INSTR(eventcode, 'Wymie') > 0, 'Wymiana pojemnika', 'Black')))
                    ) as toner
                FROM `logs`
                WHERE dateinsert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days ." DAY) AND NOW()
                      and (eventcode like '%Uzupe%nij toner%' or eventcode like 'Wymie%pojemnik na%toner.')
                GROUP BY serial, eventcode
            ) l2 
            ON 
            l1.serial = l2.serial and l1.eventcode = l2.eventcode and l1.timestamp = l2.maxtimestamp
            
            UNION 
            
            select serial, 'Black' as toner_type, date_insert as date, black_toner as toner_left
            from printers
            where black_toner <= " . $toner_left . " and date_insert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND NOW()            
            ) t
            
            INNER JOIN printers p on p.serial = t.serial
            
            INNER JOIN agreements a on a.serial = p.serial 
            
            INNER JOIN clients c on a.rowidclient = c.rowid
            
            LEFT JOIN 
            
            (SELECT rowid, serial, replace(replace(temat, 'Wymiana tonera ', ''), ' na toner', '')  as temattoner FROM `notifications`
			where temat in ('Wymiana tonera Black', 'Wymiana tonera Magenta', 'Wymiana tonera Cyan', 'Wymiana tonera Yellow', 'Wymiana pojemnika na toner')
      		AND date_insert BETWEEN DATE_SUB(NOW(), INTERVAL " . $days . " DAY) AND NOW()) n 
            
            ON p.serial = n.serial and n.temattoner like t.toner_type
            
            WHERE a.activity = 1
            
            order by t.date desc
            ";
        return $this->query($query,null,false);

    }

}