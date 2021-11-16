<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableConsumables'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                nazwa materiału
            </th>
            <th>
                model drukarki
            </th>
            <th>
                cena
            </th>
            <th>
                wydajność
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataConsumables item=item key=key name=consumablesLoop}
            <tr>
                <th scope="row">{$smarty.foreach.consumablesLoop.index+1}</th>
                <td>{$item.name|escape:'htmlall'} </td>
                <td>{$item.model|escape:'htmlall'} </td>
                <td>{if $item.price}{$item.price|escape:'htmlall'}{else}-{/if} </td>
                <td>{if $item.yield}{$item.yield|escape:'htmlall'}{else}n/a{/if} </td>
                <td>

                    <div class="dropdown show">
                        <button class="btn border border-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onClick='showNewConsumablesAdd("{$item.rowid}")'><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                            <a class="dropdown-item" href="#" onClick='deleteConsumable("{$item.rowid}")'><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Usuń</a>
                        </div>
                    </div>
                </td>
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>