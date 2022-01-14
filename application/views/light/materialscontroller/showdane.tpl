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
                numer umowy
            </th>
            <th>
                typ
            </th>
            <th>
                ilość urządzeń
            </th>
            <th>
                czarny
            </th>
            <th>
                cyan
            </th>
            <th>
                magenta
            </th>
            <th>
                yellow
            </th>
            <th>

            </th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataMaterials item=item key=key name=loopek}
            <tr>
                <th scope="row">
                {$smarty.foreach.loopek.index+1}</td>
                <td>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td>{$item.agreementId|escape:'htmlall'}</td>
                <td>{$item.type|escape:'htmlall'}</td>
                <td>{$item.deviceCount|escape:'htmlall'}</td>
                <td>{$item.black|escape:'htmlall'}</td>
                <td>{$item.cyan|escape:'htmlall'}</td>
                <td>{$item.magenta|escape:'htmlall'}</td>
                <td>{$item.yellow|escape:'htmlall'}</td>

                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#" onClick='showNewClientAdd("{$item.rowid}")'><i
                                            class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                                <div class="border-top my-1"></div>
                                <a class="dropdown-item" href="#" onClick='showDrukarkiDoKlienta("{$item.rowid}")'><i
                                            class="fas fa-print"></i>&nbsp;&nbsp;&nbsp;Urządzenia klienta</a>
                                <a class="dropdown-item" href="#" onClick='showUmowyDoKlienta("{$item.rowid}")'><i
                                            class="far fa-handshake"></i>&nbsp;&nbsp;Umowy klienta</a>
                                <div class="border-top my-1"></div>
                                <a class="dropdown-item text-danger" href="#" onClick='usunKlienta("{$item.rowid}")'>
                                    <i class="fas fa-user-times"></i>&nbsp;&nbsp;Usuń Klienta</a>
                            </div>
                        </div>
                    </td>

            </tr>
        {/foreach}
        </tbody>

    </table>
</div>
           