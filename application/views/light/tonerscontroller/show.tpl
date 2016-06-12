<div class='divFilter'>
    <label for="txtfilterdrukarka" class="labelNormal">serial drukarka</label>
     <input type="text" id='txtfilterdrukarka' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
     <label for="txtfilterserial" class="labelNormal">serial toner</label>
     <input type="text" id='txtfilterserial' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
          
            <input name='txttonerzakonczone' type="checkbox" id='txttonerzakonczone'   class='checkBoxNormal' />
            <label  class='labelNormal' for='txttonerzakonczone' >
                  Zakończone
            </label>
          
     
     
     
     <a href="#" class="buttonpokaz" onClick='pokazTonery();return false;'>Filtruj</a>
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class='divRightCenter' id='divRightCenter'>
    
</div>
<script type="text/javascript">
                       $('#txtfilterserial').unbind("keypress");
                       $('#txtfilterserial').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazTonery();return false;
                                                 }
                                             });  
                       
    pokazTonery();
</script>