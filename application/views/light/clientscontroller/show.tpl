<div class='divFilter'>
     <label for="txtfilternazwa" class="labelNormal">nazwa</label>
     <input type="text" id='txtfilternazwa' class='textBoxNormal'>  
     <label for="txtfiltermiasto" class="labelNormal">miasto</label>
     <input type="text" id='txtfiltermiasto' class='textBoxNormal'>  
     <label for="txtfilternip" class="labelNormal">nip</label>
     <input type="text" id='txtfilternip' class='textBoxNormal'>  
      <label for="txtfilterserial" class="labelNormal">serial</label>
     <input type="text" id='txtfilterserial' class='textBoxNormal'
              {if isset($serial)}
                value='{$serial}'
            {/if}
            >  
    
     <a href="#" class="buttonpokaz" onClick="pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;">Filtruj</a>
</div>
<div class='divLoader' id='divLoader{$czycolorbox}'>
</div>
<div class='divRightCenter' id='divRightCenter{$czycolorbox}'>
    
</div>
<script type="text/javascript">
                       $('#txtfilternazwa').unbind("keypress");
                       $('#txtfilternazwa').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilternip').unbind("keypress");
                       $('#txtfilternip').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfiltermiasto').unbind("keypress");
                       $('#txtfiltermiasto').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
    pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');
</script>