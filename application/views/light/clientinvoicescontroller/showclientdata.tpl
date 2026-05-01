<div>

    <p>Rozliczenie szczegółowe dla: <b>{$client['nazwakrotka']}</b>, NIP: <b>{$client['nip']}</b></p>
    {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
    <table class='table table-hover table-sm tablesorter'>
        <thead class="thead-dark">
        <tr>
            {foreach $columnNames as $columnName}
                <th>{$columnName}</th>
            {/foreach}
        </tr>
        </thead>
        <tbody>
        <tr class="table-dark text-dark text-b">
            {foreach $columnSummaries as $columnSummary}
                <th><h5><strong>{if $columnSummary != 0}{$columnSummary}{else}-{/if}</strong></h5></th>
            {/foreach}
        </tr>
        {foreach $accountingSettlements as $rowScan}
            <tr{if isset($rowScan[$rowClassName])} class="{$rowScan[$rowClassName]}"{/if}>
                {foreach $columnNames as $key}
                    <td>
                        {if isset($isGroupedView) && $isGroupedView && ($key === 'treść' || $key === 'data płatności' || $key === 'saldo')}
                            {$rowScan[$key] nofilter}
                        {else}
                            {$rowScan[$key]}
                        {/if}
                    </td>
                {/foreach}
            </tr>
        {/foreach}
        </tbody>
    </table>
    {/if}
</div>