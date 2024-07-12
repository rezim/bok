<div>
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
        {foreach $scans as $rowScan}
            <tr>
                {foreach $rowScan as $colScan}
                    <td>{$colScan}</td>
                {/foreach}
            </tr>
        {/foreach}
        <tfoot>
        <tr class="table-dark">
            {foreach $columnSummaries as $columnSummary}
                <th>{if $columnSummary > 0}{$columnSummary}{else}-{/if}</th>
            {/foreach}
        </tr>
        </tfoot>
        </tbody>
    </table>
    {/if}
</div>