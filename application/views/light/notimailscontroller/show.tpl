<fieldset class="fieldsetPowiazane">
                <legend>
                     <img wymaganylevel='w' wymaganyzrobiony='0' src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/add.png" alt="Dodaj nowy" title="Dodaj nowy" class='imgLink' style='margin-left:10px;margin-right: 10px;' 
                            onClick="newEditMail('0','0');"
                     />
                     
                    Maile powiązane
                     
                </legend>
                <div id="divPowiazaneZawartosc" class="divPowiazane">
                    
                            {if !empty($dateEmail )}
                                <table class='tableDane' cellpadding='0' cellspacing='0' style='width:98%;max-width: 98%;'>
                                    <thead>
                                       <tr>
                                         <th class='klasaTh klasaThTekst' style="width:20px;max-width: 20px;min-width: 20px;">
                                              
                                          </th>
                                          <th class='klasaTh klasaThTekst' style="width:70px;max-width: 70px;">
                                              data
                                          </th>
                                          <th class='klasaTh klasaThTekst' style="width:300px;max-width: 250px;min-width: 250px;">
                                              temat
                                          </th>
                                            <th class='klasaTh klasaThTekst' style="width:20px;max-width: 20px;min-width: 20px;">
                                              
                                          </th>
                                       </tr> 
                                       
                                    </thead>

                                    <tbody>
                                        {foreach from=$dateEmail item=item key=key}
                                            <tr class='trDane2' >
                                               <td class='klasaTd klasaTdTekst' onClick="newEditMail('{$item.rowid}','1');">
                                                   {if $item.czywyslany==0}
                                                        <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/mail_przychodzacy.png" style='height:20px;max-height: 20px;'/>
                                                    {else}
                                                        <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/mail_wychodzacy.png"  style='height:20px;max-height: 20px;'/>
                                                    {/if}
                                                </td>
                                                <td class='klasaTd klasaTdTekst' onClick="newEditMail('{$item.rowid}','1');">
                                                    {$item.date_email|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
                                                </td>
                                                <td class='klasaTd klasaTdTekst' onClick="newEditMail('{$item.rowid}','1');">
                                                    {$item.temat|escape:'htmlall'}
                                                </td>
                                                 <td class='klasaTd klasaTdTekst' >
                                                   
                                                        {if $item.czywyslany==0}
                                                        <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/reply.png" style='height:20px;max-height: 20px;' class="imglink" title="odpowiedz"
                                                              onClick="newEditMail('{$item.rowid}','0');"/>
                                                        {/if}
                                                </td>
                                          {/foreach}
                                          
                                        
                                       


                                    </tbody>
                                </table>
                             {/if}

                    
                    
                </div>    
            </fieldset>