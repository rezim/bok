<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableNotifi'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                Ticket
            </th>
            <th>
                Klient
            </th>
            <th>
                drukarka
            </th>
            <th>
                czas zgłoszenia
            </th>
            <th>
                czas zakończenia
            </th>
            <th>
                sla
            </th>
            <th>
                czas trwania
            </th>
            <th>
            </th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataNoti item=item key=key name=loopek}
            <tr>
                <th>{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.rowid}</td>
                <td {if $item.rowid_client!=''}onClick='showNewClientAdd("{$item.rowid_client}")'{/if}>
                    {$item.nazwakrotka|escape:'htmlall'}
                </td>
                <td {if $item.serial!=''}onClick='showNewPrinterAdd("{$item.serial}")'{/if}>
                    {$item.serial|escape:'htmlall'}
                </td>
                <td>{$item.date_insert}</td>
                <td>{$item.date_zakonczenia}</td>
                <td>{$item.sla}</td>
                <td>{$item.czas_trwania}</td>
                <td>
                    <div class="dropdown show">
                        <button class="btn border border-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fa fa-gear"></i>
                            {if ($item.czas_trwania-$item.sla)>0}
                                <span class="badge badge-pill badge-danger" title="Przekroczony czas trwania!"><i class="fa fa-bell-o"></i></span>
                            {/if}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onClick='showNewNotiAdd("{$item.rowid}")'><i class="fa fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                            {if $item.serial!=''}
                                <div class="border-top my-1"></div>
                                <a class="dropdown-item" href="#" onClick='pokazLogi("{$item.serial}")'><i class="fa fa-history"></i>&nbsp;&nbsp;Pokaż logi</a>
                            {/if}
                        </div>
                    </div>
                </td>
            </tr>
        {/foreach}


        </tbody>

    </table>
</div>