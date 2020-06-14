<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableClient'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                nazwa krótka
            </th>
            <th>
                kod/miasto
            </th>
            <th>
                adres
            </th>
            <th>
                nip
            </th>
            <th>
                telefon
            </th>
            {if $czycolorbox==''}
                <th>
                </th>
            {/if}
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataClient item=item key=key name=loopek}
            <tr
            {if $czycolorbox}
                class="selectable-row"
                data-source="clients"
                data-modalselector="{$czycolorbox}"
                data-clientid="{$item.rowid}"
                data-clientname="{$item.nazwakrotka|replace:'"':'&quot;'}"
                data-clientemail="{{$item.mail}}"
                onclick="dataRowSelectedHandler(this); return false;"
            {/if}
            >
                <th scope="row">
                {$smarty.foreach.loopek.index+1}</td>
                <td>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td>{$item.kodpocztowy|escape:'htmlall'} {$item.miasto|escape:'htmlall'}</td>
                <td>{$item.ulica|escape:'htmlall'}</td>
                <td>{$item.nip|escape:'htmlall'}</td>
                <td>{$item.telefon|escape:'htmlall'}</td>
                {if $czycolorbox==''}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                                <span class="badge badge-pill
                                 {if ($item.drukumowy|escape:'htmlall') > 0}badge-success{else}badge-danger{/if}"
                                      title="Umowy aktywne">{$item.drukumowy|escape:'htmlall'}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#" onClick='showNewClientAdd("{$item.rowid}")'><i
                                            class="fas fa-edit"></i> Edycja</a>
                                <div class="border-top my-1"></div>
                                <a class="dropdown-item" href="#" onClick='showDrukarkiDoKlienta("{$item.rowid}")'><i
                                            class="fas fa-print"></i>&nbsp;&nbsp;Urządzenia klienta</a>
                                <a class="dropdown-item" href="#" onClick='showUmowyDoKlienta("{$item.rowid}")'><i
                                            class="fas fa-file-text-o"></i>&nbsp;&nbsp;Umowy klienta</a>
                            </div>
                        </div>
                    </td>
                {/if}
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>
           