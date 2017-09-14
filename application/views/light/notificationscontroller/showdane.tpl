
<table class='tablesorter displaytable' id='tableNotifi' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
            <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 50px;width:50px;'>
                Ticket
            </th >
            <th style='min-width: 165px;width:165px;'>
                Klient
            </th >
            <th style='min-width: 115px;width:115px;'>
                drukarka
            </th>
              <th style='min-width: 90px;width:90px;'>
                czas zgłoszenia
            </th>
            <th style='min-width: 90px;width:90px;'>
                czas zakończenia
            </th>
            <th style='min-width: 40px;width:40px;text-align: center'>
                sla
            </th>
            <th style='min-width: 90px;width:90px;'>
                czas trwania
            </th>
            <th style='min-width: 75px;width:75px;'>
            </th>
        </tr>
    </thead>
    <tbody>

            {foreach from=$dataNoti item=item key=key name=loopek}
                <tr>
                    <td>{$smarty.foreach.loopek.index+1}</td>
                    <td>{$item.rowid}</td>
                    <td
                        {if $item.rowid_client!=''}
                            class='tdLink'
                            onClick='showNewClientAdd("{$item.rowid_client}")'
                        {/if}
                        >{$item.nazwakrotka|escape:'htmlall'}</td>
                     <td {if $item.serial!=''}class='tdLink' onClick='showNewPrinterAdd("{$item.serial}")'{/if}>{$item.serial|escape:'htmlall'}</td>
                     <td>{$item.date_insert}</td>
                     <td>{$item.date_zakonczenia}</td>
                     <td style='text-align:center;'>{$item.sla}</td>
                     <td
                         {if ($item.czas_trwania-$item.sla)>0}
                            style='text-align:center;background-color: red'
                         {else}
                            style='text-align:center;'
                         {/if}


                         >{$item.czas_trwania}</td>
                    <td style='text-align:right;'>

                        <img class='imgAkcja imgedit' onClick='showNewNotiAdd("{$item.rowid}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' alt="Edycja" title='Edycja' />
                        {if $item.serial!=''}
                        <img class='imgAkcja imgNormalLogs' onClick='pokazLogi("{$item.serial}")' src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' title='Pokaż logi' />
                        {/if}
                    </td>
                </tr>
            {/foreach}


    </tbody>

</table>
