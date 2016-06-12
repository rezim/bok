<div id="divFilterNoti" class='divFilter' style='height:auto;min-height: 80px;'>
     <label for="txtfilterklient" class="labelNormal">klient</label>
     <input type="text" id='txtfilterklient' class='textBoxNormal'>  
     <label for="txtfilternrseryjny" class="labelNormal">nr seryjny</label>
     <input type="text" id='txtfilternrseryjny' class='textBoxNormal'>  
     <label for="txtfilternrzlecenia" class="labelNormal">nr zlecenia</label>
     <input type="text" id='txtfilternrzlecenia' class='textBoxNormal' style='width:80px;'>  
     <label for="txtfilterdataod" class="labelNormal">data od</label>
     <input type="text" id='txtfilterdataod' class='textBoxNormal' style='width:80px;'>  
     <label for="txtfilterdatado" class="labelNormal">data do</label>
     <input type="text" id='txtfilterdatado' class='textBoxNormal' style='width:80px;'>  
     
     
     <br/>
     {foreach from=$statusZgloszenie item=item key=key}
            <input name='txtstatus' type="checkbox" id='txtstatus{$item.rowid}'   class='checkBoxNormal' 
                   {if $item.czydefault=='1'}checked{/if}/>
            <label  class='labelNormal' for='txtstatus{$item.rowid}' >
                  {$item.nazwa}
            </label>
          
     {/foreach}
       <a href="#" class="buttonpokaz" onClick='pokazNotiFi();return false;'>Filtruj</a>
     
     
     
     
    
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class='divRightCenter' id='divRightCenter'>
    
</div>
<script type="text/javascript">
                       $('#txtfilterklient').unbind("keypress");
                       $('#txtfilterklient').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazNotiFi();return false;
                                                 }
                                             });  
                       $('#txtfilternrseryjny').unbind("keypress");
                       $('#txtfilternrseryjny').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazNotiFi();return false;
                                                 }
                                             });  
                       $('#txtfilternrzlecenia').unbind("keypress");
                       $('#txtfilternrzlecenia').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazNotiFi();return false;
                                                 }
                                             });  
                       $('#txtfilterdataod').unbind("keypress");
                       $('#txtfilterdataod').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazNotiFi();return false;
                                                 }
                                             });  
                        $('#txtfilterdatado').unbind("keypress");
                       $('#txtfilterdatado').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazNotiFi();return false;
                                                 }
                                             });  
                     $( "#txtfilterdataod" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,
                        changeYear: true,});
                    $( "#txtfilterdatado" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,
                        changeYear: true,});
    {if isset($queryString) && $queryString[0]=='addeditnoti'}
        $("#divFilterNoti").hide();
        showNewNotiAdd('{$queryString[1]}')
    {else}
        $("#divFilterNoti").show();
        pokazNotiFi();
    {/if}
</script>