<div>
    {if isset($isEmptyMessage)}{$isEmptyMessage}{else}
        <table class='table table-hover table-sm tablesorter'>
            <thead class="thead-dark">
            <tr>
                <th>#</th>
                {foreach $columnNames as $columnName}
                    <th>{$columnName}</th>
                {/foreach}
                <th></th> {* action *}
            </tr>
            </thead>
            <tbody>
            {foreach $counters as $row_index => $row}
                <tr>
                    <td><b>{$row_index+1}</b></td>
                    {foreach $row as $col}
                        <td>{$col}</td>
                    {/foreach}
                    <td>
                        <div class="dropdown show">
                            <button class="btn border border-secondary dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                {if isset($row['serial']) && $row['serial'] neq ''}
                                    <a class="dropdown-item" href="#" onClick='showNewPrinterAdd("{$row['serial']}")'><i
                                                class="fas fa-edit"></i>&nbsp;&nbsp;Edycja Lokalizacji</a>
                                    {if isset($row['e-mail']) && $row['e-mail'] neq ''}
                                        <div class="border-top my-1"></div>
                                        <a href="javascript:void(0)" class="dropdown-item"
                                           onClick="sendEmail('{$row['e-mail']}', '{$row['serial']}', '{$row['model']}')"><i
                                                    class="fa fa-envelope"></i>
                                            &nbsp;&nbsp;Wyślij E-maila</a>
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </td>
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