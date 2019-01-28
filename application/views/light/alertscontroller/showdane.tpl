
<table class='tablesorter displaytable' id='tableAlerts' cellspacing=0 cellpadding=0>
    <thead>
    <tr>
        <th width="120px">
            serial
        </th>
        <th width="180px" style="text-align: center">
            toner
        </th>

        <th width="240px">
            drukarka
        </th>
        <th width="160px">klient</th>
        <th width="230px">
            lokalizacja
        </th>
        <th width="230px">
            kontakt
        </th>
        <th>
            data
        </th>
        <th width="50px">

        </th>
    </tr>
    </thead>
    <tbody>


    {foreach from=$dataAlerts item=item key=key name=loopek}
        {if empty($item.notification_rowid)}
        <tr>
            <td>{$item.serial|escape:'htmlall'}</td>
            <td style="text-align: center">
                    {$item.toner_left} %
                <img class='{if $item.toner_type !== 'Black'}imgColor{else}imgBlack{/if}'
                     src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png' />
                {$item.toner_type|escape:'htmlall'}
            </td>
            <td>{$item.product_number|escape:'htmlall'}&nbsp;{$item.model|escape:'htmlall'}</td>
            <td>{$item.nazwa|escape:'htmlall'}</td>
            <td>
                {$item.ulica|escape:'htmlall'}<br />{$item.kodpocztowy|escape:'htmlall'}&nbsp;{$item.miasto|escape:'htmlall'}
            </td>
            <td>
                {$item.telefon|escape:'htmlall'}<br />{$item.mail|escape:'htmlall'}<br />{$item.osobakontaktowa|escape:'htmlall'}
            </td>
            <td align="left">
                {if !empty($item.date)} {$item.date|date_format:"%Y-%m-%d"}{/if}
            </td>
            <td style="text-align: right">
                    <img class="imgAkcja imgedit"
                         onClick='showNewNotiAdd("0", "{$item.serial}", "{$item.toner_type}")'
                         src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png'
                         alt="Nowe Zgłoszenie" title='Nowe Zgłoszenie' />
            </td>
        </tr>
        {/if}
    {/foreach}

    </tbody>

</table>
