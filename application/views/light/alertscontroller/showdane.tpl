<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableAlerts'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                serial
            </th>
            <th>
                zdarzenie
            </th>

            <th>
                drukarka
            </th>
            <th>klient</th>
            <th>
                lokalizacja
            </th>
            <th>
                kontakt
            </th>
            <th>
                zdarzenie urządzenia
            </th>
            <th>
                data
            </th>
            <th>
            </th>
        </tr>
        </thead>
        <tbody>


        {foreach from=$dataAlerts item=item key=key name=loopek}
            {if empty($item.notification_rowid)}
                <tr>
                    <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                    <td>{$item.serial|escape:'htmlall'}</td>
                    <td>

                        {if ($item.toner_type !== 'Wymiana pojemnika' && $item.toner_type !== '?')}
                            {$item.toner_left} %
                            <img class='{if $item.toner_type !== 'Black'}imgColor{else}imgBlack{/if}'
                                 src='{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/fake.png'/>
                            {$item.toner_type|escape:'htmlall'}
                        {else}
                            {if $item.toner_type == '?'}
                                {$item.eventcode|escape:'htmlall'}
                            {else}
                                {$item.toner_type|escape:'htmlall'}
                            {/if}
                        {/if}
                    </td>
                    <td>{$item.product_number|escape:'htmlall'}&nbsp;{$item.model|escape:'htmlall'}</td>
                    <td>{$item.nazwa|escape:'htmlall'}</td>
                    <td>
                        {$item.ulica|escape:'htmlall'}<br/>{$item.kodpocztowy|escape:'htmlall'}
                        &nbsp;{$item.miasto|escape:'htmlall'}
                    </td>
                    <td>
                        {$item.telefon|escape:'htmlall'}<br/>{$item.mail|escape:'htmlall'}
                        <br/>{$item.osobakontaktowa|escape:'htmlall'}
                    </td>
                    <td>
                        {if !empty($item.description) && $item.description|strpos:'https://' === 0}
                            <a href="{$item.description}" target="_blank">link do zdarzenia</a>
                        {/if}
                    </td>
                    <td>
                        {if !empty($item.date)} {$item.date|date_format:"%Y-%m-%d"}{/if}
                    </td>
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#"
                                   onClick='showNewNotiAdd("0", "{$item.serial}", "{$item.toner_type}")'><i
                                            class="fas fa-plus"></i>&nbsp;&nbsp;Dodaj Zgłoszenie</a>
                            </div>
                        </div>
                    </td>
                </tr>
            {/if}
        {/foreach}

        </tbody>

    </table>
</div>