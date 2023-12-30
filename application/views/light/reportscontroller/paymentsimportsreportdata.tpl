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
        {foreach $data as $rowData}
            <tr>
                {foreach $rowData as $colData}
                    <td>{$colData}</td>
                {/foreach}
            </tr>
        {/foreach}
        {if $showFooter}
        <tfoot>
        <tr class="table-dark">
            {foreach $columnSummaries as $columnSummary}
                <th>{if $columnSummary > 0}{$columnSummary}{else}-{/if}</th>
            {/foreach}
        </tr>
        </tfoot>
        {/if}
        </tbody>
    </table>
    {/if}
</div>