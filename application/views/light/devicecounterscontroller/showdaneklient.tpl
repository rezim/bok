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

<div class="info-period">
    <strong>Liczniki urządzeń wyświetlane są za okres:</strong>
    <span class="period-range">od {$dateFrom} do {$dateTo}</span>
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
                Typ urządzenia
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
                        <td class="printer-cell" onClick='showNewPrinterAdd("{$item2.serial}")' style="cursor:pointer;">
                            <div style="display:flex; align-items:center;">
                                <span class="printer-type-icon" style="font-size:1.5em; margin-right:8px;">
                                    {if $item2.isPrinter && $item2.isScanner}
                                        <span title="Urządzenie wielofunkcyjne">🖨️📠</span>
                                    {elseif $item2.isPrinter}
                                        <span title="Drukarka">🖨️</span>
                                    {elseif $item2.isScanner}
                                        <span title="Skaner">📠</span>
                                    {else}
                                        <span title="Inny typ">❓</span>
                                    {/if}
                                </span>
                                <div style="display:flex; flex-direction:column;">
                                    <span class="printer-serial" style="font-weight:bold;">{$item2.serial|escape:'htmlall'}</span>
                                    <span class="printer-model" style="color:#2062b8; font-size:0.92em;">{$item2.model|escape:'htmlall'}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            {if $item2.isPrinter && $item2.isScanner}
                                Urządzenie wielofunkcyjne
                            {elseif $item2.isPrinter}
                                Drukarka
                            {elseif $item2.isScanner}
                                Skaner
                            {else}
                                Inny typ
                            {/if}
                        </td>
                        <td>{$item2.lokalizacja_miasto}</td>

                        <td>
                            {if $item2.isPrinter}
                                <span class="mail-label">Start:</span> {$item2.data_wiadomosci_black_start}<br />
                                <span class="mail-label">Koniec:</span> {$item2.data_wiadomosci_black_koniec}
                            {else}
                                <span class="mail-label">Start:</span> {$item2.data_wiadomosci_scans_start}<br />
                                <span class="mail-label">Koniec:</span> {$item2.data_wiadomosci_scans_koniec}
                            {/if}
                        </td>

                        <td>
                            {if $item2.isPrinter}
                            <input id="blackCount_{$item2.serial}"
                                   type="text"
                                   class="textBoxForm longTextInput"
                                   maxlength="100"
                                   style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                   value="{$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}">
                            {/if}
                        </td>

                        <td>
                            {if $item2.type_color && $item2.isPrinter}
                                <input id="colorCount_{$item2.serial}"
                                       type="text"
                                       class="textBoxForm longTextInput"
                                       maxlength="100"
                                       style="width:55px;min-width:55px;text-align: right;padding-right: 5px;"
                                       value="{$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}">
                            {/if}
                        </td>
                        <td>
                            <input id="scansCount_{$item2.serial}"
                                   type="text"
                                   class="textBoxForm longTextInput"
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
                                    {assign var="black" value=$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}
                                    {if $item2.type_color}
                                        {assign var="color" value=$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}
                                    {else}
                                        {assign var="color" value='0'}
                                    {/if}
                                    {assign var="scan" value=$item2.skany_koniec|number_format:0:",":" "|escape:'htmlall'}
                                    {assign var="serial" value=$item2.serial}
                                    {assign var="isScanner" value=$item2.isScanner}
                                    <a class="dropdown-item" href="#"
                                       onClick="savePrinterCounters('{$black}', '{$color}', '{$scan}', '{$serial}', '{$isScanner}')">
                                        <i class="fas fa-save"></i>&nbsp;&nbsp;Zapisz
                                    </a>
                                </div>
                            </div>
                            {assign var="dateTo" value="first day of this month"|strtotime|date_format:"%Y-%m-%d"}
                            <input type="hidden" id='dateToSave_{$item2.serial}'
                                   class='textBoxNormal printerCounterDateTo' style='width:80px;min-width: 80px;' value="{$dateTo}">
                        </td>
                    </tr>
                    {$turns = $turns+1}
                {/foreach}
            {/if}
        {/foreach}

        {if $turns == 1}
            <tr>
                <td colspan="8">Dla podanych filtrów wszystkie liczniki urządzeń są poprawne.</td>
            </tr>
        {/if}
        </tbody>
    </table>
</div>


