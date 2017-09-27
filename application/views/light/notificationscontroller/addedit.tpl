<div id='actionbuttonclick3' class="buttonDeclin" style='text-align: left;margin-left: 0px;float:left;' onmousedown="wsteczNoti();return false;">
    <span style='display:inline-block;margin-left: 20px;'> << Wstecz </span>
</div>
<div style='clear:both'></div>
<span id="keyval"  style='display:none;'>{$keyVal}</span>

<div id="divNotiGlowne" style="float:left;width:50%;min-width: 50%;max-height: 50%">
        <table class='tableform' cellpadding='0' cellspacing='0'>
            <tbody>
               
                 {foreach from=$filedsToEdit item=item key=key}
                        {if $item.activity=='1' && $item.divek=='divNotiGlowne' }
                             <tr id='tr{$key}'>
                          <td  class='tdOpis' {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}><span >{$item.label}</span></td>
                          <td class='tdWartosc' {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                              {if $item.type=='link' || $item.type=='text'} 
                                  <input type="text" id='{$key}' baza='{$item.baza}' name='editobj' 
                                         {if isset($item.maxlength) && $item.maxlength!=''}maxlength='{$item.maxlength}'{/if}
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if $item.type=='link'}
                                             disabled='true'
                                         {/if}
                                         {if isset($item.value) && (string)$item.value!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                               value='{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                               value='{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                         {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                         {else}
                                                             value='{$item.value|escape:'htmlall'}'
                                                         {/if}
                                          {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                              value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                              value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                        {else}
                                                            value='{$dane[0][$item.sqldanebaza]|escape:'htmlall'}'
                                                        {/if}
                                          {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                               value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                               value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                         {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                         {else}
                                                             value='{$dane[0][$item.baza]|escape:'htmlall'}'
                                                         {/if}
                                          
                                          {/if}
                                  />
                                  
                                   {if isset($item.js)}
                                    <script type="text/javascript">
                                    
                                     
                                    </script>
                                  {/if}
                              {/if}
                              {if $item.type=='combobox'}
                                  
                                    <select name='editobj' id='{$key}' baza='{$item.baza}' 
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                          >
                                        <option value="" selected></option>
                                        {if isset($item.arr) && $item.arr!=''}
                                                {foreach from=${$item.arr} item=item2 key=key2}
                                                    <option value="{$key2}" 
                                                         {if isset($item.value)  && $item.value!=''}
                                                                {if $key2==  $item.value}selected{/if}>{$item.value}</option> 
                                                         {elseif !isset($dane)}
                                                                {if isset($item.wart_domyslna) && $item.wart_domyslna==$key2}selected{/if}>{$item2.dane}</option> 
                                                         {else}
                                                             {if isset($dane) && $key2==  $dane[0][$item.baza]}selected{/if}>{$item2.dane}</option> 
                                                          {/if}
                                                {/foreach}
                                        {/if}
                                    </select>
                                  
                                  
                                  
                              {/if}
                              {if $item.type=='textarea'}
                                  
                                     <textarea id='{$key}' baza='{$item.baza}' name='editobj'
                                         {if isset($item.maxlength) && $item.maxlength!=''}maxlength='{$item.maxlength}'{/if}
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan !=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         >{if isset($item.value)  && $item.value!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$item.value|escape:'htmlall'}
{/if}
{else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$dane[0][$item.sqldanebaza]|escape:'htmlall'}
{/if}
{else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$dane[0][$item.baza]|escape:'htmlall'}
{/if}  
{/if}
</textarea>                
                                  
                              {/if}
                              
                              
                              {if $item.type=='link' && $item.readonly=='0'}
                                  <span id='{$item.idzewnetrznespan}' style="display:none;">{if isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}{$dane[0][$item.baza]}{/if}</span>
                                  <img {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if} src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/find.png" style='display:inline;margin-left: 5px;cursor:hand;cursor:pointer;' title='Wybierz'
                                    onclick="openDataShow('{$smarty.const.SCIEZKA}/{$item.link}','{$item.idzewnetrznespan}')"
                   />
                     
                              {/if}
                                {if isset($item.opis) && $item.opis!=''}
                           <span >{$item.opis}</span>
                       {/if}
                          </td>
                          <td style='width:20px;min-width: 20px;'></span></td>
                        </tr>
                         {/if}
                    {/foreach}

                 {if isset($dane) }

                 <tr><td colspan="2">&nbsp;</td></tr>
                 <tr id='tr{$key}'>
                     <td class='tdOpis' colspan="2">Wymiana {if $dane[0]['serial'] != $agreementSerial}Drukarki{else}Formatera{/if}</td>
                 </tr>
                 <tr>
                     <td  class='tdOpis'><span >Data:</span></td>
                     <td class='tdWartosc'><input id="replacementDate" class="textBoxForm" type="text" /></td>
                 </tr>
                 <tr>
                     <td  class='tdOpis'><span >Serial (stara)</span></td>
                     <td class='tdWartosc'><input class="textBoxForm" type="text" disabled value="{$dane[0]['serial']}"/></td>
                 </tr>
                 {if $dane[0]['serial'] != $agreementSerial}
                 <tr>
                     <td  class='tdOpis'><span >Serial (nowa)</span></td>
                     <td class='tdWartosc'><input class="textBoxForm" type="text" disabled value="{$agreementSerial}"/></td>
                 </tr>
                 {/if}
                 <tr>
                     <td  class='tdOpis'><span >Czarno/Białe Koniec:</span></td>
                     <td class='tdWartosc'><input id="counterEnd" class="textBoxForm" type="text" /></td>
                 </tr>
                 <tr>
                     <td  class='tdOpis'><span >Czarno/Białe Start:</span></td>
                     <td class='tdWartosc'><input id="counterStart" class="textBoxForm" type="text" /></td>
                 </tr>
                 <tr>
                     <td  class='tdOpis'><span >Kolor Koniec:</span></td>
                     <td class='tdWartosc'><input id="counterColorEnd" class="textBoxForm" type="text" /></td>
                 </tr>
                 <tr>
                     <td  class='tdOpis'><span >Kolor Start:</span></td>
                     <td class='tdWartosc'><input id="counterColorStart" class="textBoxForm" type="text" /></td>
                 </tr>
                <tr>
                    <td colspan="2" style="text-align: right">
                        <input type="button" class="btn btn-primary" value="zapisz" onclick='replacePrinter("{$dane[0]['serial']}", "{$agreementSerial}", {$dane[0]['rowid_agreements']})'>
                        <input type="button" class="btn btn-warning" value="historia" onclick='showPrinterService("{$dane[0]['umowadane']}", "{$dane[0]['rowid_agreements']}")'>
                    </td>
                </tr>


                 {/if}
            </tbody>
         </table>

</div>   
<div id="divNotiWykonanie" style="float:left;width:50%;min-width: 50%;max-height: 50%">
        <table class='tableform' cellpadding='0' cellspacing='0'>
            <tbody>
               
                 {foreach from=$filedsToEdit item=item key=key}
                        {if $item.activity=='1' && $item.divek=='divNotiWykonanie'}
                             <tr id='tr{$key}'>
                          <td class='tdOpis' {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}><span >{$item.label}</span></td>
                          <td class='tdWartosc' {if isset($item.ishide) && $item.ishide=='1'}style="display:none;"{/if}>
                              {if $item.type=='link' || $item.type=='text'}
                                  <input type="text" id='{$key}' baza='{$item.baza}' name='editobj' 
                                         {if isset($item.maxlength) && $item.maxlength!=''}maxlength='{$item.maxlength}'{/if}
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if $item.type=='link'}
                                             disabled='true'
                                         {/if}
                                         {if isset($item.value) && $item.value!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                               value='{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                               value='{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                         {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                         {else}
                                                             value='{$item.value|escape:'htmlall'}'
                                                         {/if}
                                          {else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                              value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                              value='{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                        {else}
                                                            value='{$dane[0][$item.sqldanebaza]|escape:'htmlall'}'
                                                        {/if}
                                          {else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
                                                        {if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
                                                               value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}'
                                                        {else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
                                                               value='{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}'
                                                         {else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
                                                              value='{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}'
                                                         {else}
                                                             value='{$dane[0][$item.baza]|escape:'htmlall'}'
                                                         {/if}
                                          
                                          {/if}
                                  />
                                  
                                   {if isset($item.js)}
                                    <script type="text/javascript">
                                     alert('s');
                                     
                                    </script>
                                  {/if}
                              {/if}
                              {if $item.type=='combobox'}
                                  
                                    <select name='editobj' id='{$key}' baza='{$item.baza}' 
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan!=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                          >
                                        <option value="" selected></option>
                                        {if isset($item.arr) && $item.arr!=''}
                                                {foreach from=${$item.arr} item=item2 key=key2}
                                                    <option value="{$key2}" 
                                                         {if isset($item.value)  && $item.value!=''}
                                                                {if $key2==  $item.value}selected{/if}>{$item.value}</option> 
                                                         {elseif !isset($dane)}
                                                                {if isset($item.wart_domyslna) && $item.wart_domyslna==$key2}selected{/if}>{$item2.dane}</option> 
                                                         {else}
                                                             {if isset($dane) && $key2==  $dane[0][$item.baza]}selected{/if}>{$item2.dane}</option> 
                                                          {/if}
                                                {/foreach}
                                        {/if}
                                    </select>
                                  
                                  
                                  
                              {/if}
                              {if $item.type=='textarea'}
                                  
                                     <textarea id='{$key}' baza='{$item.baza}' name='editobj'
                                         {if isset($item.maxlength) && $item.maxlength!=''}maxlength='{$item.maxlength}'{/if}
                                         {if isset($item.class) && $item.class!=''}class='{$item.class}'{/if}
                                         {if isset($item.style) && $item.style!=''}style='{$item.style}'{/if}
                                         {if isset($item.focus) && $item.focus=='1'}autofocus="true"{/if}
                                         {if isset($item.wymagane) && $item.wymagane=='1'}wymagane="{$item.wymagane}"{/if}
                                         {if isset($item.readonly) && $item.readonly=='1'}disabled='true'{/if}
                                         {if isset($item.iskey) && $item.iskey=='1'}iskey='1'{/if}
                                         {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if}
                                         {if isset($item.idzewnetrznespan) && $item.idzewnetrznespan !=''}zewnetrznyspan='{$item.idzewnetrznespan}'{/if}
                                         >{if isset($item.value)  && $item.value!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$item.value|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$item.value|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$item.value|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$item.value|escape:'htmlall'}
{/if}
{else if isset($item.sqldanebaza) && isset($dane[0][$item.sqldanebaza]) && (string)$dane[0][$item.sqldanebaza]!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$dane[0][$item.sqldanebaza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$dane[0][$item.sqldanebaza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$dane[0][$item.sqldanebaza]|escape:'htmlall'}
{/if}
{else if isset($item.baza) && isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}
{if isset($item.datatypeshow) && $item.datatypeshow=='datetime'}
{$dane[0][$item.baza]|date_format:"%Y-%m-%d %H:%M"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='date'}
{$dane[0][$item.baza]|date_format:"%Y-%m-%d"|escape:'htmlall'}
{else if isset($item.datatypeshow) && $item.datatypeshow=='decimal'}
{$dane[0][$item.baza]|number_format:2:",":" "|replace:",00":""|escape:'htmlall'}
{else}
{$dane[0][$item.baza]|escape:'htmlall'}
{/if}  
{/if}
</textarea>
                         
                                  
                              {/if}
                              
                              
                              {if $item.type=='link' && $item.readonly=='0'}
                                  <span id='{$item.idzewnetrznespan}' style="display:none;">{if isset($dane[0][$item.baza]) && (string)$dane[0][$item.baza]!=''}{$dane[0][$item.baza]}{/if}</span>
                                  <img {if isset($item.wymaganylevel) && $item.wymaganylevel!=''}wymaganylevel='{$item.wymaganylevel}' wymaganyzrobiony='0' {/if} src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/find.png" style='display:inline;margin-left: 5px;cursor:hand;cursor:pointer;' title='Wybierz'
                                    onclick="openDataShow('{$smarty.const.SCIEZKA}/{$item.link}','{$item.idzewnetrznespan}')"    
                                       
                                       
                                       />
                              {/if}
                          </td>
                          <td style='width:20px;min-width: 20px;'></span></td>
                        </tr>
                         {/if}
                    {/foreach}    
                
            </tbody>
         </table>   

</div>   
                        <div style="clear:both"></div>
  {if isset($keyVal) && $keyVal!=0}
                <div class="dropzone" id="divdropzone">

                </div>
               <script type="text/javascript">
                   createDropZone('div#divdropzone','{$keyVal}','notifications','{$smarty.const.ADRESHTTPS}/public_html','{$smarty.const.SCIEZKA}');
               </script>     
         {/if}
                        <br/><br/>
                        {if isset($dane) && $dane[0]['status']=='3'}
                        {else}
                                <div class='divSave' style="text-align:right;margin-right:150px;"  wymaganylevel='w' wymaganyzrobiony='0' >
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                         <!--<div id='actionbuttonclick2' class="buttonDeclin" onmousedown="zapiszNoti('1','{$smarty.const.SCIEZKA}/notifications/save/notemplate');return false;">

                                            <span >X Usuń</span>
                                        </div>-->
                                         
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown="zapiszNoti('0','{$smarty.const.SCIEZKA}/notifications/save/notemplate');return false;">
                                            <span >Zapisz >></span>
                                        </div>
                                        <div id='actionloader' class="actionloader">
                                            <img src="{$smarty.const.SCIEZKA}/{$smarty.const.SMARTVERSION}/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                        <br/><br/>
                        {/if}

<div id="divMailePowiazane">
    
</div>
    
<div style='clear:both'></div>                                   
  <br/><br/>  
<script type="text/javascript">
    showMaile();
    $( "#replacementDate" ).datetimepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,timeFormat: 'HH:mm',stepMinute: 10,
        changeYear: true});
     $( "#data_planowana" ).datetimepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,timeFormat: 'HH:mm',stepMinute: 10,
                        changeYear: true});
</script>