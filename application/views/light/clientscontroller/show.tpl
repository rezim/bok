<div class="container-fluid position-relative">
    {include file="$templates/partials/filters/clients.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter{$czycolorbox}"}
</div>
<script type="text/javascript">
                       $('#txtfilternazwa').unbind("keypress");
                       $('#txtfilternazwa').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     showClients('{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfilternip').unbind("keypress");
                       $('#txtfilternip').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    showClients('{$czycolorbox}');return false;
                                                 }
                                             });  
                       $('#txtfiltermiasto').unbind("keypress");
                       $('#txtfiltermiasto').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     showClients('{$czycolorbox}');return false;
                                                 }
                                             });

    showClients('{$czycolorbox}');
</script>