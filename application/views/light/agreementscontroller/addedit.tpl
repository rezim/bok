<table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
                          <tr>
                               <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                   Nr umowy
                               </td>
                               <td class='tdWartosc' colspan="3">
                                   <input type="text" id='txtnrumowy' autofocus 
                                          class='textBoxForm' maxlength="40" style='width:130px;min-width:130px;' 
                                          {if $rowid!=0}value="{$dataUmowa[0].nrumowy|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Klient
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                    <select id='txtklient' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        {foreach from=$dataClients item=item key=key}
                                        <option value="{$key}" {if $rowid!=0 && $dataUmowa[0].rowidclient==$key}selected{/if}>{$item.nazwakrotka}</option>
                                        {/foreach}
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Drukarka
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                  
                                    <select id='txtdrukarka' class="comboboxForm" style='width:300px;min-width:300px;'>
                                        <option value="" selected></option>
                                        
                                        {foreach from=$dataPrinters item=item key=key}
                                        <option value="{$item.serial}" {if $rowid!=0 && $dataUmowa[0].serial==$item.serial}selected{/if}>{$item.serial} - {$item.model}</option>
                                        {/foreach}
                                    </select>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id='trtxtrozliczenie'>
                               <td class='tdOpis' >
                                   Rozliczenie
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                    <select id='txtrozliczenie' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        <option value="miesięczne" {if $rowid!=0 && $dataUmowa[0].rozliczenie=='miesięczne'}selected{/if}>miesięczne</option>
                                        <option value="roczne" {if $rowid!=0 && $dataUmowa[0].rozliczenie=='roczne'}selected{/if}>roczne</option>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                             <tr id="trtxtabonament">
                               <td class='tdOpis' >
                                   abonament
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtabonament' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0}value="{$dataUmowa[0].abonament|number_format:2:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtdataod">
                               <td class='tdOpis' >
                                   Data od
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtdataod' 
                                          class='textBoxForm' maxlength="10" style='width:100px;min-width:100px;' 
                                          {if $rowid!=0}value="{$dataUmowa[0].dataod|escape:'htmlall'}"{/if}>  
                                          <font style='font-size: 12px;color:gray'>(rok-miesiąc-dzień )np.2007-07-23</font>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtdataod">
                               <td class='tdOpis' >
                                   Data do
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtdatado' 
                                          class='textBoxForm' maxlength="10" style='width:100px;min-width:100px;' 
                                          {if $rowid!=0}value="{$dataUmowa[0].datado|escape:'htmlall'}"{/if}>  
                               <font style='font-size: 12px;color:gray'>(rok-miesiąc-dzień )np.2007-07-23</font>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                        
                           <tr id="trtxtiloscstron">
                               <td class='tdOpis' >
                                   stron black w abonam.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstron' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0}value="{$dataUmowa[0].stronwabonamencie|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                               
                                <td class='tdOpis' >
                                   cena instalacji
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenainstalacji' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].cenainstalacji)}value="{$dataUmowa[0].cenainstalacji|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                               
                               
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtcenazastrone">
                               <td class='tdOpis' >
                                   cena za stronę black
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenazastrone' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0}value="{$dataUmowa[0].cenazastrone|number_format:3:",":" "|escape:'htmlall'}"{/if}>
                               </td>
                                <td class='tdOpis' >
                                   prowizja partn.[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtprowizjapartnerska' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].prowizjapartnerska)}value="{$dataUmowa[0].prowizjapartnerska|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                          
                           
                           
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr id="trtxtiloscstron_kolor">
                               <td class='tdOpis' >
                                   stron kolor w abonam.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstron_kolor' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].iloscstron_color)}value="{$dataUmowa[0].iloscstron_color|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                                 <td class='tdOpis' >
                                   SLA [ h ]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtsla' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].sla)}value="{$dataUmowa[0].sla|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtcenazastrone_kolor">
                               <td class='tdOpis' >
                                   cena za stronę kolor
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenazastrone_kolor' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].cenazastrone_kolor)}value="{$dataUmowa[0].cenazastrone_kolor|number_format:2:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                                <td class='tdOpis' >
                                   wartość urządz.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtwartoscurzadzenia' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].wartoscurzadzenia)}value="{$dataUmowa[0].wartoscurzadzenia|number_format:2:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr id="trtxtrabatdoabonamentu">
                               <td class='tdOpis' >
                                   rabat do abonamentu[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtrabatdoabonamentu' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].rabatdoabonamentu)}value="{$dataUmowa[0].rabatdoabonamentu|number_format:2:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                               
                                <td class='tdOpis' >
                                   wszystko jak czarne
                               </td>
                               <td class='tdWartosc'>
                                     <input type="checkbox" id='checkJakCzarne' class='checkBoxNormal' 
                                            {if $rowid!=0 && !empty($dataUmowa[0].jakczarne) &&  $dataUmowa[0].jakczarne==1}checked{/if}
                                            />
                                        
                                  
                               </td>
                               
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr id="trtxtrabatdowydrukow">
                               <td class='tdOpis' >
                                   rabat do wydruków[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtrabatdowydrukow' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataUmowa[0].rabatdowydrukow)}value="{$dataUmowa[0].rabatdowydrukow|number_format:2:",":" "|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                           
                            <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   krótki opis
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" >{if $rowid!=0}{$dataUmowa[0].opis|escape:'htmlall'}{/if}</textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

<!-- device localization -->
    <tr>
        <td class='tdOpis' colspan="4" >
            Lokalizacja Urządzenia
        </td>
    </tr>
    <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
    <!-- name -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
            nazwa
        </td>
        <td class='tdWartosc' colspan="3">
            <input type="text" id='txtnazwa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $rowid!=0}value="{$dataUmowa[0].nazwa|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

    <!-- street -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    ulica
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="text" id='txtulica'
                                           class='textBoxForm' maxlength="100" style='min-width:130px;'
                                           {if $rowid!=0}value="{$dataUmowa[0].ulica|escape:'htmlall'}"{/if}>
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

    <!-- city -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    miasto
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="text" id='txtmiasto'
                                           class='textBoxForm' maxlength="70" style='min-width:130px;'
                                           {if $rowid!=0}value="{$dataUmowa[0].miasto|escape:'htmlall'}"{/if}>
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

    <!-- postal code -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    kod pocztowy
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="text" id='txtkodpocztowy'
                                           class='textBoxForm' maxlength="10" style='min-width:130px;'
                                           {if $rowid!=0}value="{$dataUmowa[0].kodpocztowy|escape:'htmlall'}"{/if}>
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
    <!-- contact information -->
    <tr>
        <td class='tdOpis' colspan="4" >
            Dane kontaktowe
        </td>
    </tr>
    <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

    <!-- contact person -->
    <tr>
        <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
            osoba kontaktowa
        </td>
        <td class='tdWartosc' colspan="3">
            <input type="text" id='txtosobakontaktowa'
                   class='textBoxForm' maxlength="100" style='min-width:130px;'
                   {if $rowid!=0}value="{$dataUmowa[0].osobakontaktowa|escape:'htmlall'}"{/if}>
        </td>
    </tr>
    <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
    <!-- phone -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    telefon
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="text" id='txttelefon'
                                           class='textBoxForm' maxlength="50" style='min-width:130px;'
                                           {if $rowid!=0}value="{$dataUmowa[0].telefon|escape:'htmlall'}"{/if}>
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

    <!-- mail -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    adres email
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="text" id='txtmail'
                                           class='textBoxForm' maxlength="50" style='min-width:130px;'
                                           {if $rowid!=0}value="{$dataUmowa[0].mail|escape:'htmlall'}"{/if}>
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

                            <tr>
                                <td style='text-align: right;' colspan="4">
                                    <div class='divSave' id="divSaveUmowa">
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                           <div id='actionbuttonclick2' class="buttonDeclin" onmousedown='usunUmowe("{$rowid}");return false;'>

                                            <span >X Zamknij</span>
                                        </div>
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown='zapiszUmowe("{$rowid}");return false;'>
                                            <span >Zapisz >></span>
                                        </div>
                                        <div id='actionloader' class="actionloader">
                                            <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                </td>
                            </tr>
                            <tr>
                                <td style='text-align: center;' colspan="4">    
                                    
                                      {if isset($rowid) && $rowid!=0}
                                            <div class="dropzone" id="divdropzone3">

                                            </div>
                                           <script type="text/javascript">
                                               createDropZone('div#divdropzone3','{$rowid}','agreements','{$smarty.const.ADRESHTTPS}/public_html','{$smarty.const.SCIEZKA}');
                                           </script>     
                                     {/if}
                                </td>
                            </tr>
                        </table>
                    <script type="text/javascript">
                                          $( "#txtdataod" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,
                        changeYear: true,});
                                            $( "#txtdatado" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd", changeMonth: true,
                        changeYear: true, });
                    </script>
    
</table>
