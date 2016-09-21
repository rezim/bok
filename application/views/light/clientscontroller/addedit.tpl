<table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
                          <tr>
                               <td class='tdOpis' >
                                   Nazwa krótka
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtnazwakrotka' autofocus 
                                          class='textBoxForm' maxlength="40" style='width:250px;min-width:250px;' 
                                          {if $rowid!=0}value="{$dataClient[0].nazwakrotka|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   Nazwa pełna
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtnazwapelna" class="textareaForm" style='height:50px;min-height: 50px;'  maxlength="200" >{if $rowid!=0}{$dataClient[0].nazwapelna}{/if}</textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr>
                               <td class='tdOpis' >
                                   adres
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtulica'
                                          class='textBoxForm' maxlength="100" style='width:300px;min-width:300px;'
                                          {if $rowid!=0}value="{$dataClient[0].ulica|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                             <tr>
                               <td class='tdOpis' >
                                   Miasto
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmiasto'
                                          class='textBoxForm' maxlength="70" style='width:200px;min-width:200px;'
                                          {if $rowid!=0}value="{$dataClient[0].miasto|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                             <tr>
                               <td class='tdOpis' >
                                   Kod pocztowy
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtkodpocztowy'
                                          class='textBoxForm' maxlength="10" style='width:90px;min-width:90px;'
                                          {if $rowid!=0}value="{$dataClient[0].kodpocztowy|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   NIP
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtknip'
                                          class='textBoxForm' maxlength="20" style='width:150px;min-width:150px;'
                                          {if $rowid!=0}value="{$dataClient[0].nip|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                          <tr>
                               <td class='tdOpis' >
                                   telefon
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txttelefon'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          {if $rowid!=0}value="{$dataClient[0].telefon|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   mail
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmail'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          {if $rowid!=0}value="{$dataClient[0].mail|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                             <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr>
                               <td class='tdOpis' >
                                   mail faktury
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmailfaktury'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          {if $rowid!=0}value="{$dataClient[0].mailfaktury|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                             <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr>
                               <td class='tdOpis' >
                                   termin płatności
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtterminplatnosci' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          {if $rowid!=0 && !empty($dataClient[0].terminplatnosci)}value="{$dataClient[0].terminplatnosci|number_format:0:",":" "|escape:'htmlall'}"{/if}>  
                                   dni
                               </td>
                           </tr>
                           
                           
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   krótki opis
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" >{if $rowid!=0}{$dataClient[0].opis|escape:'htmlall'}{/if}</textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr>
                               <td class='tdOpis' >
                                   REGON
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtregon'
                                          class='textBoxForm' maxlength="20" style='width:150px;min-width:150px;'
                                          {if $rowid!=0}value="{$dataClient[0].regon|escape:'htmlall'}"{/if}>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>

                            <!-- invoice options -->
                            <tr>
                                <td class='tdOpis' colspan="4" >
                                    Opcje Faktury
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <!-- show serial number -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    pokaż numer seryjny
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="checkbox" id='checkPokazNumerSeryjny' class='checkBoxNormal'
                                           {if $rowid!=0 && !empty($dataClient[0].pokaznumerseryjny) &&  $dataClient[0].pokaznumerseryjny==1}checked{/if}
                                    />
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <!-- show device counter state -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    pokaż stan licznika
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="checkbox" id='checkPokazStanLicznika' class='checkBoxNormal'
                                           {if $rowid!=0 && !empty($dataClient[0].pokazstanlicznika) &&  $dataClient[0].pokazstanlicznika==1}checked{/if}
                                    />
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <!-- separate invoice for each agreement -->
                            <tr>
                                <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                    faktura dla każdej umowy
                                </td>
                                <td class='tdWartosc' colspan="3">
                                    <input type="checkbox" id='checkFakturaDlaKazdejUmowy' class='checkBoxNormal'
                                           {if $rowid!=0 && !empty($dataClient[0].fakturadlakazdejumowy) &&  $dataClient[0].fakturadlakazdejumowy==1}checked{/if}
                                    />
                                </td>
                            </tr>
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <!-- end -->
                           
                            <tr>
                                <td style='text-align: right;' colspan="2">
                                    <div class='divSave'>
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                         <div id='actionbuttonclick2' class="buttonDeclin" onmousedown='usunKlienta("{$rowid}");return false;'>

                                            <span >X Usuń</span>
                                        </div>
                                         
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown='zapiszKlienta("{$rowid}");return false;'>
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
                      
                    </script>
    
</table>