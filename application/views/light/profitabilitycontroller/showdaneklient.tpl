
<table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
    <thead>
                      <tr>
           <th style='min-width: 50px;width:50px;'>
                                                Lp
                                            </th >

            <th style='min-width: 200px;width:200px;'>
                nazwa pełna
            </th>

            <th style='min-width: 55px;width:55px;'>
                abonament
            </th>

            <th style='min-width: 75px;width:75px;text-align: center;'>
                netto
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                wartość faktura
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

                    <td class='tdLink'  onClick='showNewClientAdd("{$item.rowidclient}")'>{$item.nazwapelna|escape:'htmlall'}</td>

                    <td class='tdNumber' style='padding-right:20px;' >
                               {if !empty($item.wartoscabonament)} {$item.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}
                    </td>

                    <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:blue;' 
                        onClick="showSzczegolyRaportRozwin('tr_{$key}')">
                               {if isset($item.wartosc)} {$item.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}     
                    </td>
                    <td align="center">
                        <span class="invoice-sum {$item.nip}">0</span>
                        <span style="display: none;" class="invoice-details {$item.nip}"></span>
                    </td>
                </tr>
                  <tr class="agreements-list {$item.nip}" stan='0'>
                    <td colspan="9" >
                        
                        <div style="margin-bottom: 30px;">
                             <table class='tablesorter displaytable'  cellspacing=0 cellpadding=0>
                                    <thead>
                                        <tr>

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

                                             <th style='min-width: 70px;width:70px;'>
                                                opłata instalacyjna
                                            </th>
                                             <th style='min-width: 70px;width:70px'>
                                                kwota
                                            </th>
                                            <th style='min-width: 70px;width:70px'>
                                                ilosc_km
                                            </th>
                                            <th style='min-width: 70px;width:70px'>
                                                czas_pracy
                                            </th>
                                             <th style='min-width: 70px;width:70px'>
                                                 wartosc_materialow
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         {foreach from=$dataReports[$key].umowy item=item2 key=key2 name=loopek}

                                                    <td class='tdWartosc'  style='display: none;'>{$key2}</td>

                                                    <td class='tdWartosc agreement-nb' onClick="showNewAgreementAdd('{$item2.rowidumowa}')">
                                                        <span class="fa fa-exclamation-triangle"></span>{$item2.nrumowy}</td>
                                                    
                                                    <td class='tdLink' style='vertical-align: top;' onClick='showNewPrinterAdd("{$item2.serial}")'>
                                                        {$item2.serial|escape:'htmlall'}<br/>
                                                        <font style='color:blue'>{$item2.model|escape:'htmlall'}</font>
                                                    </td>
                                                    <td class='tdWartosc'  >{$item2.rozliczenie}</td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.wartoscabonament)} {$item2.wartoscabonament|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>

                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                {if isset($item2.oplatainstalacyjna)} {$item2.oplatainstalacyjna|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;color:blue;' >
                                                                {if isset($item2.wartosc)} {$item2.wartosc|number_format:2:",":" "|escape:'htmlall'}{/if}     
                                                     </td>
                                                     <td class='tdNumber' style='padding-right:20px;color:blue;' >
                                                         {if isset($item2.ilosc_km)} {$item2.ilosc_km}{/if}
                                                     </td>
                                             <td class='tdNumber' style='padding-right:20px;color:blue;' >
                                                 {if isset($item2.czas_pracy)} {$item2.czas_pracy}{/if}
                                             </td>
                                             <td class='tdNumber' style='padding-right:20px;color:blue;' >
                                                 {if isset($item2.wartosc_materialow)} {$item2.wartosc_materialow}{/if}
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
    </tbody>    
        
</table>
       