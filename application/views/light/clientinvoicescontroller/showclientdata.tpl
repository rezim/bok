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
        <tr class="table-dark">
            {foreach $columnSummaries as $columnSummary}
                <th>{if $columnSummary != 0}{$columnSummary}{else}-{/if}</th>
            {/foreach}
        </tr>
        {foreach $accountingSettlements as $rowScan}
            <tr{if isset($rowScan[$rowClassName])} class="{$rowScan[$rowClassName]}"{/if}>
                {foreach $rowScan as $key=>$colScan}
                    {if $key !== $rowClassName}
                    <td>{$colScan}</td>
                    {/if}
                {/foreach}
            </tr>
        {/foreach}
        </tbody>
    </table>
    {/if}
</div>