{if $czyedit==0 && $daneNoti[0]['email']==''}
    Nie możesz wysyłąć maili - brak maila w zgłoszeniu
{else}
    
     <table class='tableform' cellpadding='0' cellspacing='0'>
            <tbody>
                          <tr>
                          <td  class='tdOpis'><span >Do</span></td>
                          <td class='tdWartosc' >
                                <input type="text" id='txtmail' class='textBoxForm' style='width:400px;min-width: 400px;max-width: 400px;'
                                           value="{$daneNoti[0]['email']}"
                                           disabled="true"
                                       />
                         </td>
                          <tr>
                          <td  class='tdOpis'><span >Temat</span></td>
                          <td class='tdWartosc' >
                                <input type="text" id='txttemat' class='textBoxForm' style='width:700px;min-width: 700px;max-width: 700px;' autofocus
                                       {if isset($daneReply) && $czyedit==0}
                                           value="Re: {$daneReply[0].temat|escape:'htmlall'}"
                                           disabled="true"
                                       {/if}
                                       {if isset($daneReply) && $czyedit==1}
                                           value="{$daneReply[0].temat|escape:'htmlall'}"
                                           disabled="true"
                                       {/if}
                                       />
                         </td>
                          </tr>
                          <tr>
                          <td  class='tdOpis'><span >Treść</span></td>
                          <td class='tdWartosc' >
<textarea id='txttresc' class='textareaForm' style='width:700px;min-width: 700px;max-width: 700px;height:450px;min-height: 450px;max-height: 450px;'
          {if isset($daneReply) && $czyedit==1}disabled="true"{/if}
          >
{if isset($daneReply) && $czyedit==0}
&#10;
----------------------------------------
{$daneReply[0].tresc_wiadomosci|escape:'htmlall'}
{/if}
{if isset($daneReply) && $czyedit==1}
{$daneReply[0].tresc_wiadomosci|escape:'htmlall'}
{/if}
</textarea>
                         </td>
                          </tr>
                          {if $czyedit==1}
                              <tr>
                                  <td colspan="2">
                                    {if isset($replyrowid) && $replyrowid!=0}
                                            <div class="dropzone" id="divdropzone2">

                                            </div>
                                           <script type="text/javascript">
                                               createDropZone('div#divdropzone2','{$replyrowid}','mails','{$smarty.const.ADRESHTTPS}/public_html','{$smarty.const.SCIEZKA}');
                                           </script>     
                                     {/if}
                                  </td>
                              </tr>
                          {/if}
                           {if $czyedit==0}
                             
                              
                               <tr>
                                <td style='text-align: right;' colspan='2'>
                                    <div class='divSave2' style="text-align:right;margin-right:50px;"  wymaganylevel='w' wymaganyzrobiony='0' >
                                        <div id='actionerror2' class='actionerror'><span>Błąd wysłania maila.</span></div>
                                        <div id='actionok2' class='actionok' ><span style='margin-top:6px;'>Mail wysłany poprawnie</span></div>
                                
                                         
                                            <div id='actionbuttonclick2' class="actionbuttonZapisz" onmousedown="sendMail('{$noti_rowid}','{$replyrowid}','{$uniqueid}');return false;">
                                            <span >Wyślij >></span>
                                        </div>
                                        <div id='actionloader2' class="actionloader">
                                            <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                </td>
                               </tr>
                               <tr>
                                  <td colspan="2">
                                
                                            <div class="dropzone" id="divdropzone2">

                                            </div>
                                           <script type="text/javascript">
                                               createDropZone('div#divdropzone2','{$uniqueid}','mails','{$smarty.const.ADRESHTTPS}/public_html','{$smarty.const.SCIEZKA}');
                                           </script>     
                                  </td>
                              </tr>
                        {/if}
            </tbody>
     </table>
                        <Br/><Br/><Br/>
{/if}