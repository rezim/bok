<table width="100%" class="errorMessageWrapper">
    <tr>
        <td id="errorMessage" class="fas fa-exclamation-triangle">
        </td>
    </tr>
</table>

<div class='divSave'>
    <div id='actionerror' class="alert alert-danger actionerror" role="alert">
        Błąd zapisu danych!
    </div>

    <div id='actionerrorwrongvalue' class="alert alert-danger actionerror" role="alert">
        Wartość nie może być mniejsza niż wartość poprzednia!
    </div>

    <div id='actionok' class="alert alert-success actionok" role="alert">
        Dane zapisane poprawnie!
    </div>


    <div style='clear:both'></div>
</div>

{$turns = 1}
<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id="tableCounters">
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                Klient
            </th>
            <th>
                Drukarka
            </th>
            <th>
                Miasto
            </th>
            <th>
                Data maila
            </th>
            <th>
                Czarny-koniec
            </th>
            <th>
                Kolor-koniec
            </th>
            <th>
                Skany-koniec
            </th>
            <th>

            </th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$dataReports item=item key=key name=loopek2}
            {if $key!='suma' && $key!='blad'}
                {foreach from=$dataReports[$key].umowy item=item2 key=key2 name=loopek}
                    <tr>
                        <th scope="row">{$turns}</th>
                        <td>{$item.nazwakrotka|escape:'htmlall'}</td>
                        <td onClick='showNewPrinterAdd("{$item2.serial}")'>
                            {$item2.serial|escape:'htmlall'}<br/>
                            <font style='color:blue'>{$item2.model|escape:'htmlall'}</font>
                        </td>
                        <td>{$item2.lokalizacja_miasto}</td>

                        <td>
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
                            {if $item2.type_color}
                                <input id="colorCount_{$item2.serial}"
                                       type="text"
                                       class="textBoxForm"
                                       maxlength="100"
                                       style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                       value="{$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}">
                            {/if}
                        </td>
                        <td>
                            <input id="scansCount_{$item2.serial}"
                                   type="text"
                                   class="textBoxForm"
                                   maxlength="100"
                                   style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                   value="{$item2.skany_koniec|number_format:0:",":" "|escape:'htmlall'}">
                        </td>
                        <td>
                            <div class="dropdown show">
                                <button class="btn border border-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="#" onClick="savePrinterCounters('{$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}',
                                                    {if $item2.type_color}'{$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}'{else}'0'{/if},
                                                    '{$item2.skany_koniec|number_format:0:",":" "|escape:'htmlall'}',
                                                    '{$item2.serial}')"><i class="fas fa-save"></i>&nbsp;&nbsp;Zapisz</a>
                                </div>
                            </div>
                            <input type="hidden" id='dateToSave_{$item2.serial}'
                                   class='textBoxNormal printerCounterDateTo' style='width:80px;min-width: 80px;'>
                        </td>
                    </tr>
                    {$turns = $turns+1}
                {/foreach}
            {/if}
        {/foreach}

        {if $turns == 1}
            <tr>
                <td colspan="8">Aktualnie wszystkie liczniki drukarek są poprawne.</td>
            </tr>
        {/if}
        </tbody>
    </table>
</div>


