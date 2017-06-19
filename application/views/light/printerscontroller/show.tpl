<div class='panel panel-success'>
     <div class="panel-body">
          <div class='divFilter row'>
               <div class="col-sm-10">
                    <label for="txtfilterserial{$czycolorbox}" class="labelNormal">serial</label>
                    <input type="text" id='txtfilterserial{$czycolorbox}' class='textBoxNormal' style='width:100px;min-width: 100px;'>
                    <label for="txtfiltermodel{$czycolorbox}" class="labelNormal">model</label>
                    <input type="text" id='txtfiltermodel{$czycolorbox}' class='textBoxNormal' style='width:100px;min-width: 100px;'>
                    <label for="txtfilterklient{$czycolorbox}" class="labelNormal">klient</label>
                    <input type="text" id='txtfilterklient{$czycolorbox}' class='textBoxNormal' style='width:100px;min-width: 100px;'
                           {if isset($clientnazwakrotka)}
                               value='{$clientnazwakrotka}'
                           {/if}
                           >
                    <button class="btn btn-success" onClick="pokazDrukarki('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;">Filtruj</button>
               </div>
               <div class="col-sm-2 text-right">
                   {if isset($smarty.session.przypisanemenu['but_addprinter']) && $currentPage==='printers'}
                        <button type="button" class="btn btn-success" onclick='showNewPrinterAdd("");return false;'><i class="fa fa-plus" aria-hidden="true"></i> Nowa drukarka</button>
                   {/if}
               </div>
          </div>
     </div>
</div>

<div class='divLoader' id='divLoader{$czycolorbox}'>
</div>
<div class='divRightCenter' id='divRightCenter{$czycolorbox}'>
    
</div>
<script type="text/javascript">
                       $('#txtfilterserial{$czycolorbox}').unbind("keypress");
                       $('#txtfilterserial{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfiltermodel{$czycolorbox}').unbind("keypress");
                       $('#txtfiltermodel{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilterklient{$czycolorbox}').unbind("keypress");
                       $('#txtfilterklient{$czycolorbox}').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
                                                 }
                                             });  
                    
    pokazDrukarki('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');
</script>