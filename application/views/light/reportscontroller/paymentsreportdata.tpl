<div>
    {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
        <table class='table table-hover table-sm tablesorter'>
            <thead class="thead-dark">
            <tr>
                <th style="width: 40px; min-width: 40px;"></th>
                {foreach $columnNames as $columnName}
                    <th>{$columnName}</th>
                {/foreach}
            </tr>
            </thead>
            <tbody>
            {foreach $data  as $row_index => $rowData}
                <tr>
                    <td style="width: 40px; min-width: 40px;"><b>{$row_index+1}</b></td>
                    {foreach $rowData as $colData}
                        <td>{$colData}</td>
                    {/foreach}
                </tr>
            {/foreach}
            {if $showFooter}
            <tfoot>
            <tr class="table-dark">
                <th style="width: 40px; min-width: 40px;"></th>
                {foreach $columnSummaries as $columnSummary}
                    <th>{if $columnSummary > 0}{$columnSummary}{else}-{/if}</th>
                {/foreach}
            </tr>
            </tfoot>
            </tbody>
            {/if}
        </table>
    {/if}
</div>