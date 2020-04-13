<div class='divFilter container'>
     <label for="txtfilternrumowy{$czycolorbox}" class="labelNormal">nr umowy</label>
     <input type="text" id='txtfilternrumowy{$czycolorbox}' class='textBoxNormal'>  
     <label for="txtfilterserial{$czycolorbox}" class="labelNormal">drukarka</label>
     <input type="text" id='txtfilterserial{$czycolorbox}' class='textBoxNormal'
              {if isset($serial)}
                value='{$serial}'
            {/if}
            
            >  
     <label for="txtfilternazwaklient{$czycolorbox}" class="labelNormal"
            
            >klient</label>
     <input type="text" id='txtfilternazwaklient{$czycolorbox}' class='textBoxNormal'   {if isset($clientnazwakrotka)}
                value='{$clientnazwakrotka}'
            {/if}>  
     <input type="checkbox" id='checkPokazZakonczone{$czycolorbox}'   class='checkBoxNormal' />
                                        <label class='labelNormal' for='checkPokazZakonczone' >
                                            Zakończone
                                        </label>
     <a href="#" class="buttonpokaz" onClick="pokazUmowy('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;">Filtruj</a>
</div>
<div class='divLoader' id='divLoader{$czycolorbox}'>
</div>
<div class='divRightCenter container' id='divRightCenter{$czycolorbox}'>
    
</div>
<script type="text/javascript">
                       $('#txtfilternrumowy{$czycolorbox}').unbind("keypress");
                       $('#txtfilternrumowy{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilterserial{$czycolorbox}').unbind("keypress");
                       $('#txtfilterserial{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilternazwaklient{$czycolorbox}').unbind("keypress");
                       $('#txtfilternazwaklient{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
    pokazUmowy('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');
</script>