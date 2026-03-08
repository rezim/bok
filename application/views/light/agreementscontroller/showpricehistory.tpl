<div class="container-fluid p-3">
    <div class="mb-2">
        <strong>Historia indeksacji umowy:</strong>
        <span>{if isset($agreementNb) && $agreementNb != ''}{$agreementNb|escape:'htmlall'}{else}-{/if}</span>
    </div>

    {if isset($priceHistory) && $priceHistory|@count > 0}
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered mb-0">
                <thead class="thead-dark">
                <tr>
                    <th>Od</th>
                    <th>Do</th>
                    <th>Abonament</th>
                    <th>Cena black</th>
                    <th>Cena kolor</th>
                    <th>Indeksacja [%]</th>
                    <th>Powód</th>
                    <th>Utworzono</th>
                </tr>
                </thead>
                <tbody>
                {foreach from=$priceHistory item=item}
                    <tr>
                        <td>{$item.valid_from|escape:'htmlall'}</td>
                        <td>{if $item.valid_to}{$item.valid_to|escape:'htmlall'}{else}<span class="badge badge-success">aktywna</span>{/if}</td>
                        <td>{if $item.abonament !== null}{$item.abonament|number_format:2:",":" "}{else}-{/if}</td>
                        <td>{if $item.cenazastrone !== null}{$item.cenazastrone|number_format:3:",":" "}{else}-{/if}</td>
                        <td>{if $item.cenazastrone_kolor !== null}{$item.cenazastrone_kolor|number_format:3:",":" "}{else}-{/if}</td>
                        <td>{$item.indexation_percent|number_format:2:",":" "}</td>
                        <td>{$item.reason|escape:'htmlall'}</td>
                        <td>{$item.created_at|escape:'htmlall'}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    {else}
        <div class="alert alert-info mb-0" role="alert">
            Brak historii indeksacji dla tej umowy.
        </div>
    {/if}
</div>
