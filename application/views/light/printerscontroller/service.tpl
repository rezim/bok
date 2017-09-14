
<table class='displaytable'  cellspacing=0 cellpadding=0 style='margin-top:10px;'>
    <thead>
        <tr>
            <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 100px;width:100px;'>
                Czarne Koniec
            </th>
            <th style='min-width: 100px;width:100px;'>
                Czarne Start
            </th>

            <th style='min-width: 100px;width:100px;'>
                Kolor Koniec
            </th>
            <th style='min-width: 100px;width:100px;'>
                Kolor Start
            </th>
            <th>
                Data Serwisu
            </th>
            <th style='min-width: 150px;width:150px;'></th>
        </tr>
    </thead>
    <tbody>
            {$iterator=1}
            {foreach from=$dataService item=item key=key}
                <tr>
                    <td>{$iterator}</td>
                    <td>{$item.ilosc_koniec}</td>
                    <td>{$item.ilosc_start}</td>

                    <td>{$item.ilosckolor_koniec}</td>
                    <td>{$item.ilosckolor_start}</td>

                    <td>{$item.date}</td>

                    <td style="text-align: right; "><i style="color: red" class="fa fa-remove fa-2x" onclick="removePrinterService({$item.rowid}, '{$item.serial}')"></i></td>
                </tr>
                {$iterator = $iterator + 1}
            {/foreach}
    </tbody>
</table>