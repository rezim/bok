
<table width="100%" class="errorMessageWrapper">
    <tr>
        <td id="errorMessage" class="fa fa-exclamation-triangle">
        </td>
    </tr>
</table>
<table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
    <thead>
                      <tr>
           <th style='min-width: 50px;width:50px;'>
                                                Lp
                                            </th >
            <th style='min-width: 115px;width:115px;'>
                klient
            </th>
            <th style='min-width: 200px;width:200px;'>
                nazwa pełna
            </th>
             <th style='min-width: 55px;width:55px;'>
                umowy
            </th>
            <th style='min-width: 55px;width:55px;'>
                drukarki
            </th>
            <th style='min-width: 55px;width:55px;'>
                abonament
            </th>
             <th style='min-width: 70px;width:70px;'>
                wart. black
            </th>
              <th style='min-width: 70px;width:70px;'>
                wart. kolor
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                netto
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                faktura
            </th>
        </tr>
    </thead>
    <tbody>
         {$turns = 1} 
            {foreach from=$dataReports item=item key=key name=loopek2}
                {if $key!='suma' && $key!='blad'}
                {if isset($item.blad) && $item.blad=='1'}
                        <tr class="tr_{$key}" style='border-bottom:none;border-top:1px solid lightgrey;background-color: red;'>
                {else}
                        <tr class="tr_{$key}" style='border-bottom:none;border-top:1px solid lightgrey'>
                {/if}
                    <td>{$turns}</td>
                    <td class='tdLink'  onClick='showNewClientAdd("{$item.rowidclient}")'><span class="fa fa-exclamation-triangle"></span>{$item.nazwakrotka|escape:'htmlall'}</td>
                    <td class='tdLink'  onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwapelna|escape:'htmlall'}</td>
                    <td class='tdLink' style='text-align:center;' onClick='showUmowyDoKlienta("{$item.rowidclient}")'>{$item.drukumowy|escape:'htmlall'}</td>
                    <td class='tdLink' style='text-align:center;' onClick='showDrukarkiDoKlienta("{$item.rowidclient}")'>{$item.drukumowy|escape:'htmlall'}</td>
                    <td class='tdNumber' style='padding-right:20px;' >
                               {if !empty($item.wartoscabonament)} {$item.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}
                    </td>
                    <td class='tdNumber' style='padding-right:20px;white-space: nowrap' >
                               {if isset($item.wartoscblack)} {$item.wartoscblack|number_format:2:",":" "|escape:'htmlall'}{/if}     
                    </td>
                      <td class='tdNumber' style='padding-right:20px;white-space: nowrap' >
                               {if isset($item.wartosckolor)} {$item.wartosckolor|number_format:2:",":" "|escape:'htmlall'}{/if}     
                    </td>
                    <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:blue;white-space: nowrap'
                        onClick="showSzczegolyRaportRozwin('tr_{$key}')">
                               {if isset($item.wartosc)} {$item.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}     
                    </td>
                    <td align="center">
                        <i class="fa fa-plus invoice-add" onClick='invMgr.add({($item)|json_encode nofilter}, invMgr.getSelectedAgreementIds("#tr_{$key}", ".to_invoice_agreement:checked"))'></i>
                        <i class="fa fa-file{if $item.fakturadlakazdejumowy}s{/if}-o invoice-add" onClick='invMgr.add({($item)|json_encode nofilter}, invMgr.getSelectedAgreementIds("#tr_{$key}", ".to_invoice_agreement:checked"))'></i>
                        <i class='fa fa-spinner fa-spin invoice-loading'></i>
                        <span class="invoice-count {$item.nip}">0</span>
                        <span style="display: none;" class="invoice-details {$item.nip}"></span>
                    </td>
                </tr>
                  <tr id='tr_{$key}' class="agreements-list {$item.nip}" stan='0' style='display:none'>
                    <td colspan="10">
                        
                        <div class="divRep">
                             <table class='tablesorter displaytable'  cellspacing=0 cellpadding=0>
                                    <thead>
                                        <tr>
                                             <th style='min-width: 50px;width:50px;'>
                                                Lp
                                            </th >
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
                                                        <tr style='background-color: #FFCCCC;' class="{$item2.nrumowy|replace:'/':'-'}">
                                                {else}
                                                        <tr class="{$item2.nrumowy|replace:'/':'-'}">
                                                {/if}
                                                
                                                    <td style="text-align: center">{$smarty.foreach.loopek.index+1}</td>
                                                    <td class='tdWartosc'  style='display: none;'>{$key2}</td>

                                                    <td class='tdWartosc agreement-nb' onClick="showNewAgreementAdd('{if isset($item2.rowidumowa)}{$item2.rowidumowa}{/if}')"
                                                    blackStartDate="{$item2.data_wiadomosci_black_start}"
                                                    blackEndDate="{$item2.data_wiadomosci_black_koniec}"
                                                    colorStartDate="{$item2.data_wiadomosci_kolor_start}"
                                                    colorEndDate="{$item2.data_wiadomosci_kolor_koniec}"
                                                        blackStart="{$item2.strony_black_start|number_format:0:",":" "|escape:'htmlall'}"
                                                        blackEnd="{$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}"
                                                        colorStart="{$item2.strony_kolor_start|number_format:0:",":" "|escape:'htmlall'}"
                                                        colorEnd="{$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}"
                                                    title="
Strony czarne start - Licznik: {$item2.strony_black_start|number_format:0:",":" "|escape:'htmlall'}, Data: {$item2.data_wiadomosci_black_start}
Strony czarne koniec - Licznik: {$item2.strony_black_koniec|number_format:0:",":" "|escape:'htmlall'}, Data: {$item2.data_wiadomosci_black_koniec}                                                    
Strony kolorowe start - Licznik: {$item2.strony_kolor_start|number_format:0:",":" "|escape:'htmlall'}, Data: {$item2.data_wiadomosci_kolor_start}
Strony kolorowe koniec - Licznik: {$item2.strony_kolor_koniec|number_format:0:",":" "|escape:'htmlall'}, Data: {$item2.data_wiadomosci_kolor_koniec}                                                     
                                                    "    
                                                        
                                                        
                                                        
                                                        ><span class="fa fa-exclamation-triangle"></span>{$item2.nrumowy}</td>
                                                    
                                                    <td class='tdLink' style='vertical-align: top;' onClick='showNewPrinterAdd("{$item2.serial}")'>
                                                        {$item2.serial|escape:'htmlall'}<br/>
                                                        <font style='color:blue'>{$item2.model|escape:'htmlall'}</font>
                                                    </td>
                                                    <td class='tdWartosc'  >{$item2.rozliczenie}</td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.wartoscabonament)} {$item2.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.stronwabonamencie)} {$item2.stronwabonamencie|number_format:0:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.cenazastrone)} {$item2.cenazastrone|number_format:3:",":" "|escape:'htmlall'}{/if}
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.iloscstron_kolor)} {$item2.iloscstron_kolor|number_format:0:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.cenazastrone_kolor)} {$item2.cenazastrone_kolor|number_format:3:",":" "|escape:'htmlall'}{/if}
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.stronblackpowyzej)} {$item2.stronblackpowyzej|number_format:0:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;white-space: nowrap' >
                                                                {if isset($item2.wartoscblack)} {$item2.wartoscblack|number_format:3:",":" "|escape:'htmlall'}{/if}
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.stronkolorpowyzej)} {$item2.stronkolorpowyzej|number_format:0:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;white-space: nowrap' >
                                                                {if isset($item2.wartosckolor)} {$item2.wartosckolor|number_format:3:",":" "|escape:'htmlall'}{/if}
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.oplatainstalacyjna)} {$item2.oplatainstalacyjna|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                     <td class='tdNumber' style='padding-right:20px;color:blue;white-space: nowrap' >
                                                                {if isset($item2.wartosc)} {$item2.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                     <td>
                                                         <input type="checkbox" class="to_invoice_agreement" checked="true" value="{$item2.nrumowy}" />
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
                <tr >
                    <td class='tdLink'  ></td>
                    <td class='tdLink'  ></td>
                    <td class='tdLink'  ></td>
                    <td class='tdLink' style='text-align:center;' ></td>
                    <td class='tdLink' style='text-align:center;' ></td>
                    <td class='tdNumber' style='padding-right:20px;' >
                     
                    </td>
                    <td class='tdNumber' style='padding-right:20px;' >
                     
                    </td>
                      <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:brown;' >
                     Suma:
                    </td>
                    <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:brown;white-space: nowrap' >
                               {if isset($dataReports.suma)} {$dataReports.suma|number_format:2:",":" "|escape:'htmlall'}{/if}     
                    </td>
                </tr>
    </tbody>    
        
</table>
       