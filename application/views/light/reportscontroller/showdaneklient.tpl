<script>
    invMgr.setReportData({$dataReports|json_encode nofilter});
</script>

<table width="100%" class="errorMessageWrapper">
    <tr>
        <td id="errorMessage" class="fas fa-exclamation-triangle">
        </td>
    </tr>
</table>

<div class="table-responsive-sm">
    <table class='table table-hover table-sm' id='tableReport'>
        <thead class="thead-dark">
        <tr>
            <th>
                #
            </th>
            <th>
                klient
            </th>
            <th>
                nazwa pełna
            </th>
            <th>
                umowy
            </th>
            <th>
                drukarki
            </th>
            <th>
                abonament
            </th>
            <th>
                wart. black
            </th>
            <th>
                wart. kolor
            </th>
            <th>
                netto
            </th>
            <th>
                faktura
            </th>
        </tr>
        </thead>
        <tbody>
        {$turns = 1}
        {foreach from=$dataReports item=item key=key name=loopek2}
            {if $key!='suma' && $key!='blad'}
                {if isset($item.blad) && $item.blad=='1'}
                    <tr class="tr_{$key} clientRow"
                        style='border-bottom:none;border-top:1px solid lightgrey;color:red; background-color: lightyellow; font-weight: bold'>
                        {else}
                    <tr class="tr_{$key} clientRow" style='border-bottom:none;border-top:1px solid lightgrey'>
                {/if}
                <td>{$turns}</td>
                <td class='tdLink' onClick='showNewClientAdd("{$item.rowidclient}")'><span
                            class="fas fa-exclamation-triangle"></span>{$item.nazwakrotka|escape:'htmlall'}</td>
                <td class='tdLink'
                    onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwapelna|escape:'htmlall'}</td>
                <td class='tdLink' style='text-align:center;'
                    onClick='showUmowyDoKlienta("{$item.rowidclient}")'>{$item.drukumowy|escape:'htmlall'}</td>
                <td class='tdLink' style='text-align:center;'
                    onClick='showDrukarkiDoKlienta("{$item.rowidclient}")'>{$item.drukumowy|escape:'htmlall'}</td>
                <td class='tdNumber' style='padding-right:20px;'>
                    {if !empty($item.wartoscabonament)} {$item.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}
                </td>
                <td class='tdNumber' style='padding-right:20px;white-space: nowrap'>
                    {if isset($item.wartoscblack)} {$item.wartoscblack|number_format:2:",":" "|escape:'htmlall'}{/if}
                </td>
                <td class='tdNumber' style='padding-right:20px;white-space: nowrap'>
                    {if isset($item.wartosckolor)} {$item.wartosckolor|number_format:2:",":" "|escape:'htmlall'}{/if}
                </td>
                <td class='tdNumber tdLink' title='Pokaż szczegóły'
                    style='padding-right:20px;font-weight: bold;color:blue;white-space: nowrap'
                    onClick="showSzczegolyRaportRozwin('tr_{$key}')">
                    {if isset($item.wartosc)} {$item.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}
                </td>
                <td>

                    <div class="dropdown show">
                        <button class="btn border border-secondary dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fas fa-cog"></i>
                            <span class="badge badge-pill badge-danger invoice-count {$item.nip}"
                                  title="Wystawione Faktury">0</span>
                            <span class="badge invoice-loading"><i class='fas fa-spinner fa-spin'></i></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#"
                               onClick='invMgr.add("{$key}"); return false;'>
                                <i class="far {if $item.fakturadlakazdejumowy}fa-copy{else}fa-file{/if}"></i>&nbsp;&nbsp;Wystaw Fakturę Vat</a>
                        </div>
                    </div>
                    <span style="display: none;" class="invoice-details {$item.nip}"></span>
                </td>
                </tr>
                <tr id='tr_{$key}' class="agreements-list {$item.nip}" stan='0' style='display:none'>
                    <td colspan="10">

                        <div class="divRep">
                            <table class='tablesorter displaytable' cellspacing=0 cellpadding=0>
                                <thead>
                                <tr>
                                    <th style='min-width: 50px;width:50px;'>
                                        Lp
                                    </th>
                                    <th style='min-width: 70px;width:70px;display:none;'>
                                        rowid
                                    </th>
                                    <th style='min-width: 80px;width:80px;'>
                                        nr umowy
                                    </th>
                                    <th style='min-width: 115px;width:115px;'>
                                        drukarka
                                    </th>

                                    <th style='min-width: 70px;width:70px;'>
                                        rozliczenie
                                    </th>
                                    <th style='min-width: 90px;width:90px;'>
                                        abonament
                                    </th>
                                    <th style='min-width: 55px;width:55px;'>
                                        stron black w abonam.
                                    </th>
                                    <th style='min-width: 55px;width:55px;'>
                                        cena za strone black
                                    </th>
                                    <th style='min-width: 55px;width:55px;'>
                                        stron kolor w abonam.
                                    </th>
                                    <th style='min-width: 55px;width:55px;'>
                                        cena za strone kolor
                                    </th>
                                    <th style='min-width: 70px;width:70px;'>
                                        black powyżej
                                    </th>
                                    <th style='min-width: 70px;width:70px;'>
                                        wartość black
                                    </th>
                                    <th style='min-width: 70px;width:70px;'>
                                        kolor powyżej
                                    </th>
                                    <th style='min-width: 70px;width:70px;'>
                                        wartość kolor
                                    </th>
                                    <th style='min-width: 70px;width:70px;'>
                                        opłata instalacyjna
                                    </th>
                                    <th style='min-width: 70px;width:70px'>
                                        kwota
                                    </th>
                                    <th style='min-width: 70px;width:70px'>
                                        wybierz do faktury
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {foreach from=$dataReports[$key].umowy item=item2 key=key2 name=loopek}
                                    {if isset($item2.blad) && $item2.blad=='1'}
                                        <tr style='color: red; font-weight: bold; background-color: lightyellow;'
                                            class="{$item2.nrumowy|replace:'/':'-'}">
                                            {else}
                                        <tr class="{$item2.nrumowy|replace:'/':'-'}">
                                    {/if}
                                    <td style="text-align: center">{$smarty.foreach.loopek.index+1}</td>
                                    <td class='tdWartosc' style='display: none;'>{$key2}</td>
                                    <td class='tdWartosc agreement-nb'
                                        onClick="showNewAgreementAdd('{if isset($item2.rowidumowa)}{$item2.rowidumowa}{/if}')">
                                        <span class="fas fa-exclamation-triangle"></span>{$item2.nrumowy}
                                    </td>
                                    <td class='tdLink' style='vertical-align: top;'
                                        onClick='showNewPrinterAdd("{$item2.serial}")'>
                                        {$item2.serial|escape:'htmlall'}<br/>
                                        <font style='color:blue'>{$item2.model|escape:'htmlall'}</font>
                                    </td>
                                    <td class='tdWartosc'>{$item2.rozliczenie}</td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.wartoscabonament)} {$item2.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.stronwabonamencie)} {$item2.stronwabonamencie|number_format:0:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.cenazastrone)} {$item2.cenazastrone|number_format:3:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.iloscstron_kolor)} {$item2.iloscstron_kolor|number_format:0:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.cenazastrone_kolor)} {$item2.cenazastrone_kolor|number_format:3:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.stronblackpowyzej)} {$item2.stronblackpowyzej|number_format:0:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;white-space: nowrap'>
                                        {if isset($item2.wartoscblack)} {$item2.wartoscblack|number_format:3:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.stronkolorpowyzej)} {$item2.stronkolorpowyzej|number_format:0:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;white-space: nowrap'>
                                        {if isset($item2.wartosckolor)} {$item2.wartosckolor|number_format:3:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;'>
                                        {if isset($item2.oplatainstalacyjna)} {$item2.oplatainstalacyjna|number_format:2:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td class='tdNumber' style='padding-right:20px;color:blue;white-space: nowrap'
                                            {if !($item2.rozliczenie === 'roczne')}{* no need to show counters for by year agreements*}
                                                onclick='showPrinterCounters({$item2.data_wiadomosci_black_start|json_encode},
                                                {$item2.data_wiadomosci_black_koniec|json_encode}, {$item2.data_wiadomosci_kolor_start|json_encode},
                                                {$item2.data_wiadomosci_kolor_koniec|json_encode}, {$item2.strony_black_start|json_encode},
                                                {$item2.strony_black_koniec|json_encode}, {$item2.strony_kolor_start|json_encode},
                                                {$item2.strony_kolor_koniec|json_encode}, {$item2.strony_black_sum},
                                                {$item2.strony_kolor_sum}, {$item2.serials|json_encode})'
                                            {/if}
                                    >
                                        {if isset($item2.wartosc)} {$item2.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="to_invoice_agreement" checked="true"
                                               value="{$item2.nrumowy}"/>
                                    </td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </div>


                    </td>

                </tr>
                {$turns = $turns+1}
            {/if}



        {/foreach}
        <tr>
            <td class='tdLink'></td>
            <td class='tdLink'></td>
            <td class='tdLink'></td>
            <td class='tdLink' style='text-align:center;'></td>
            <td class='tdLink' style='text-align:center;'></td>
            <td class='tdNumber' style='padding-right:20px;'>

            </td>
            <td class='tdNumber' style='padding-right:20px;'>

            </td>
            <td class='tdNumber tdLink' title='Pokaż szczegóły'
                style='padding-right:20px;font-weight: bold;color:brown;'>
                Suma:
            </td>
            <td class='tdNumber tdLink' title='Pokaż szczegóły'
                style='padding-right:20px;font-weight: bold;color:brown;white-space: nowrap'>
                {if isset($dataReports.suma)} {$dataReports.suma|number_format:2:",":" "|escape:'htmlall'}{/if}
            </td>
        </tr>
        </tbody>

    </table>
</div>
       