
<table width="100%" class="errorMessageWrapper">
    <tr>
        <td id="errorMessage" class="fa fa-exclamation-triangle">
        </td>
    </tr>
</table>

{$turns = 1}

    <table class='tablesorter displaytable'  id="tableCounters" cellspacing=0 cellpadding=0>
                    <thead>
                        <tr>
                             <th style='min-width: 20px;width:20px;'>
                                Lp
                            </th >
                            <th style='min-width: 150px;width:150px;'>
                                Klient
                            </th>
                             <th style='min-width: 130px;width:130px;'>
                                Drukarka
                            </th>
                            <th style='min-width: 130px;width:130px;'>
                                Miasto
                            </th>
                            <th style='min-width: 100px;width:100px;'>
                                Data maila
                            </th>
                            <th style='min-width: 115px;width:115px;'>
                                Czarny-koniec
                            </th>
                            <th style='min-width: 115px;width:115px;'>
                                Kolor-koniec
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach from=$dataReports item=item key=key name=loopek2}
                    {if $key!='suma' && $key!='blad'}
                         {foreach from=$dataReports[$key].umowy item=item2 key=key2 name=loopek}
                                    <tr>

                                    <td>{$turns}</td>
                                        <td class='tdLink'>{$item.nazwakrotka|escape:'htmlall'}</td>
                                    <td class='tdLink' style='vertical-align: top;' onClick='showNewPrinterAdd("{$item2.serial}")'>
                                        {$item2.serial|escape:'htmlall'}<br/>
                                        <font style='color:blue'>{$item2.model|escape:'htmlall'}</font>
                                    </td>
                                        <td>{$item2.lokalizacja_miasto}</td>

                                        <td class='tdLink'>
                                            {$item2.data_wiadomosci_black_koniec}
                                        </td>

                                        <td>
                                            <input id="blackCount_{$item2.serial}"
                                                    type="text"
                                                   class="textBoxForm"
                                                   maxlength="100"
                                                   style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                                   value="{$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}">
                                        </td>

                                        <td>
                                            <input id="colorCount_{$item2.serial}"
                                                   type="text"
                                                   class="textBoxForm"
                                                   maxlength="100"
                                                   style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                                   value="{$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}">
                                        </td>
                                        <td>
                                            <input  type="hidden" id='dateToSave_{$item2.serial}' class='textBoxNormal printerCounterDateTo' style='width:80px;min-width: 80px;'>
                                            <button type="button" onclick="savePrinterCounters('{$item2.serial}')">zapisz</button>
                                        </td>
                                </tr>
                             {$turns = $turns+1}
                         {/foreach}
                    {/if}
                    {/foreach}
                    </tbody>
            </table>

