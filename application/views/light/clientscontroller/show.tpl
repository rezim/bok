<div class='panel panel-primary'>
<div class="panel-body">
<div class='divFilter row'>
    <div class="col-sm-10">
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
    <button class="btn btn-primary" onClick="pokazKlientow('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;">Filtruj</button>
    {*<a href="#" class="buttonpokaz" >Filtruj</a>*}
    </div>
    <div class="col-sm-2 text-right">
    {if isset($smarty.session.przypisanemenu['but_addclient']) && $currentPage==='clients'}
        <button type="button" class="btn btn-primary" onclick='showNewClientAdd("0");return false;'><i class="fa fa-plus" aria-hidden="true"></i> Nowy klient</button>
        {*<a id='but_addclient' href="#" onclick='showNewClientAdd("0");return false;' class="butaddclient" >Nowy klient</a>*}
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