<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableToner'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                serial drukarka
            </th>
            <th>
                serial
            </th>
            <th>
                typ
            </th>
            <th>
                number
            </th>
            <th>
                opis
            </th>
            <th>
                data instalacji
            </th>
            <th>
                pozostało
            </th>
            <th>
                strona max / stron pozos.
            </th>
            <th>
                ostatnie użycie
            </th>
            {if isset($czyhistoria) && $czyhistoria==1}
                <th>
                    licznik start<br/>licznikkoniec
                </th>
            {/if}
            <th>

            </th>
        </tr>
        </thead>
        <tbody>

        {foreach from=$dataToners item=item key=key name=tonnersLoop}
            <tr>
                <th scope="row">{$smarty.foreach.tonnersLoop.index+1}</th>
                <td title='{$item.model}--{$item.nazwakrotka}'>{$item.serialdrukarka|escape:'htmlall'}</td>
                <td>{$item.serial|escape:'htmlall'} </td>
                <td>{$item.typ|escape:'htmlall'} </td>
                <td>{$item.number|escape:'htmlall'}</td>
                <td>{$item.description|escape:'htmlall'}</td>
                <td>{$item.datainstalacji|escape:'htmlall'}</td>
                <td class='tdNumber'>
                    {$item.procentpozostalo|number_format:2:",":" "|replace:',00':''|escape:'htmlall'} %
                </td>
                <td class='tdNumber'>
                    {$item.stronmax|escape:'htmlall'}<br/>{$item.stronpozostalo|escape:'htmlall'}
                </td>

                <td>{$item.ostatnieuzycie|escape:'htmlall'}</td>
                {if isset($czyhistoria) && $czyhistoria==1}
                    <td class='tdNumber'>
                        {$item.licznikstart|number_format:0:",":" "|escape:'htmlall'}<br/>
                        {$item.licznikkoniec|number_format:0:",":" "|escape:'htmlall'}
                    </td>
                {/if}
                <td>

                    <div class="dropdown show">
                        <button class="btn border border-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#" onClick='showNewTonerAdd("{$item.rowid}","{$item.typ}")'><i class="fas fa-edit"></i>&nbsp;&nbsp;Edycja</a>
                            <a class="dropdown-item" href="#" onClick='usunToner("{$item.rowid}","{$item.typ}")'><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Usuń</a>
                        </div>
                    </div>
                </td>
            </tr>
        {/foreach}
        </tbody>

    </table>
</div>