
<table class='displaytable'  cellspacing=0 cellpadding=0 style='margin-top:10px;'>
    <thead>
        <tr>
            <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 60px;width:60px;'>
                Akcja
            </th>
            <th style='min-width: 130px;width:130px;'>
                Serial (Stara)
            </th>
            <th style='min-width: 130px;width:130px;'>
                Serial (Nowa)
            </th>
            <th style='min-width: 80px;width:80px;'>
                Czarne Koniec
            </th>
            <th style='min-width: 80px;width:80px;'>
                Czarne Start
            </th>

            <th style='min-width: 80px;width:80px;'>
                Kolor Koniec
            </th>
            <th style='min-width: 80px;width:80px;'>
                Kolor Start
            </th>
            <th style='min-width: 80px;width:80px;'>
                Data Serwisu
            </th>
            <th style='min-width: 50px;width:50px;'></th>
        </tr>
    </thead>
    <tbody>
            {$iterator=1}
            {foreach from=$dataService item=item key=key}
                <tr>
                    <td>{$iterator}</td>
                    <td>wymiana {if $item.serial != $item.new_serial}drukarki{else}formatera{/if}</td>
                    <td {if $item.serial == $item.new_serial}colspan="2"{/if}>{$item.serial}</td>
                    {if $item.serial != $item.new_serial}
                    <td>{$item.new_serial}</td>
                    {/if}
                    <td>{$item.ilosc_koniec}</td>
                    <td>{$item.ilosc_start}</td>

                    <td>{$item.ilosckolor_koniec}</td>
                    <td>{$item.ilosckolor_start}</td>

                    <td>{$item.date}</td>

                    <td style="text-align: right; "><i style="color: red" class="fas fa-remove fa-2x" onclick="removePrinterService({$item.rowid}, '{$item.serial}')"></i></td>
                </tr>
                {$iterator = $iterator + 1}
            {/foreach}
    </tbody>
</table>