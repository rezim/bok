
<table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
    
                            <tr>
                               <td class='tdOpis' >
                                  Drukarka
                               </td>
                               <td class='tdWartosc'>
                                    <select id='txtdrukarka' class="comboboxForm" style='width:300px;min-width:300px;'>
                                        <option value="" selected></option>
                                        {foreach from=$dataPrinters item=item key=key}
                                        <option value="{$item.serial}" {if isset($rowid) && $rowid!=0 && $dataToner[0].serialdrukarka==$item.serial}selected{/if}>
                                            {$item.serial}---{$item.model}---{$item.nazwaklient}
                                        </option>
                                        {/foreach}
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
    
    
                          <tr>
                               <td class='tdOpis' >
                                   Serial
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtserial'
                                          class='textBoxForm' maxlength="50" style='width:120px;min-width:120px;' 
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].serial|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                        
                           <tr>
                               <td class='tdOpis' >
                                  Typ
                               </td>
                               <td class='tdWartosc'>
                                    <select id='txttyp' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        
                                        <option value="black" {if isset($rowid) && $rowid!=0 && $dataToner[0].typ=='black'}selected{/if}>
                                            black
                                        </option>
                                        <option value="cyan" {if isset($rowid) && $rowid!=0 && $dataToner[0].typ=='cyan'}selected{/if}>
                                            cyan
                                        </option>
                                        <option value="magenta" {if isset($rowid) && $rowid!=0 && $dataToner[0].typ=='magenta'}selected{/if}>
                                            magenta
                                        </option>
                                        <option value="yellow" {if isset($rowid) && $rowid!=0 && $dataToner[0].typ=='yellow'}selected{/if}>
                                            yellow
                                        </option>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Number
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtnumber'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].number|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Opis
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtopis'
                                          class='textBoxForm' maxlength="100" style='width:250px;min-width:250px;' 
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].description|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Data instalacji
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtdatainstalacji'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].datainstalacji|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Stron max.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstronmax'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].stronmax|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Stron pozostało
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstronpozostalo'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].stronpozostalo|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Ostatnie użycie
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtostatnieuzycie'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].ostatnieuzycie|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Licznik start
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtlicznikstart'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if isset($rowid) && $rowid!=0}value="{$dataToner[0].licznikstart|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Licznik koniec
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtlicznikkoniec'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if isset($rowid) && $rowid!=0 && !empty($dataToner[0].licznikkoniec)}value="{$dataToner[0].licznikkoniec|number_format:0:",":" "|replace:',00':''|escape:'htmlall'}"{/if}> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                            <tr>
                                <td style='text-align: right;' colspan="2">
                                    <div class='divSave'>
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" 
                                                 {if isset($rowid) && $rowid!=0}onmousedown='zapiszToner("{$rowid}");return false;'
                                                 {else}onmousedown='zapiszToner("0");return false;'
                                                 {/if}
                                                 >
                                            <span >Zapisz >></span>
                                        </div>
                                        <div id='actionloader' class="actionloader">
                                            <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                </td>
                            </tr>
                        </table>
                    <script type="text/javascript">     
                           $( "#txtdatainstalacji" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" });
                           $( "#txtostatnieuzycie" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" });
                    </script>
    
</table>