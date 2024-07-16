<div class="table-responsive-sm">
    <table class="table table-striped table-sm fs-9 mb-0" id="tableClient">
        <thead>
        <tr>
            <th>#</th>
            <th class="sort ps-3">nazwa krótka</th>
            <th class="sort">kod/miasto</th>
            <th class="sort">adres</th>
            <th class="sort">nip</th>
            <th class="sort">telefon</th>
            {if $czycolorbox==''}
                <th class="text-end align-middle pe-0" scope="col">ACTION</th>
            {/if}
        </tr>
        </thead>
        <tbody class="list">
        {foreach from=$dataClient item=item key=key name=loopek}
            <tr {if $czycolorbox}
                class="selectable-row"
                data-source="clients"
                data-modalselector="{$czycolorbox}"
                data-clientid="{$item.rowid}"
                data-clientname="{$item.nazwakrotka|replace:'"':'&quot;'}"
                data-clientemail="{{$item.mail}}"
                onclick="dataRowSelectedHandler(this); return false;"
                    {/if}>
                <th scope="row">{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td>{$item.kodpocztowy|escape:'htmlall'} {$item.miasto|escape:'htmlall'}</td>
                <td>{$item.ulica|escape:'htmlall'}</td>
                <td>{$item.nip|escape:'htmlall'}</td>
                <td>{$item.telefon|escape:'htmlall'}</td>
                {if $czycolorbox==''}
                    <td class="text-end pe-0">
                        <div class="btn-reveal-trigger position-static">
                            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                <i class="fas fa-ellipsis"></i>
                                <span class="badge badge-pill {if ($item.drukumowy|escape:'htmlall') > 0}badge-success{else}badge-danger{/if}" title="Umowy aktywne">{$item.drukumowy|escape:'htmlall'}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end py-2">
                                <a class="dropdown-item" href="#" onClick='showNewClientAdd("{$item.rowid}")'><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                <div class="border-top my-1"></div>
                                <a href="javascript:void(0)" class="dropdown-item" onClick="showClientMessages('{$item.nip}', '{$item.nazwakrotka}')"><i class="fas fa-comment-dots"></i>&nbsp;&nbsp;Notatki</a>
                                <a class="dropdown-item" href="#" onClick='showDrukarkiDoKlienta("{$item.rowid}")'><i class="fas fa-print"></i>&nbsp;&nbsp;&nbsp;Urządzenia klienta</a>
                                <a class="dropdown-item" href="#" onClick='showUmowyDoKlienta("{$item.rowid}")'><i class="far fa-handshake"></i>&nbsp;&nbsp;Umowy klienta</a>
                                <div class="border-top my-1"></div>
                                <a class="dropdown-item text-danger" href="#" onClick='usunKlienta("{$item.rowid}")'><i class="fas fa-user-times"></i>&nbsp;&nbsp;Usuń Klienta</a>
                            </div>
                        </div>
                    </td>
                {/if}
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
