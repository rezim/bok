<div class="table-responsive-sm">
    <table id="tableStatistics" class='table table-hover table-sm' id='tableNotifi'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                Status
            </th>
            <th>
                Imię
            </th>
            <th>
                Nazwisko
            </th>
            <th>
                Ilość zleceń
            </th>
            <th>
            </th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataStatistics item=item key=key name=loopek}
            <tr>
                <th>{$smarty.foreach.loopek.index+1}</th>
                <td>{$item.status|escape:'htmlall'}</td>
                <td>
                    {$item.imie|escape:'htmlall'}
                </td>
                <td>
                    {$item.nazwisko|escape:'htmlall'}
                </td>
                <td>
                    {$item.count|escape:'htmlall'}
                </td>
                <td></td>
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>