<div class="container-fluid">

    <div class="row">
        <main id='divRightCenter' class="col-12">

        </main>
    </div>

</div>
<script type="text/javascript">
    $('#txtfilterserial{$czycolorbox}').unbind("keypress");
    $('#txtfilterserial{$czycolorbox}').keypress(function(event) {
        if (event.keyCode == 13) {
            showAlerts('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
        }
    });
    $('#txtfiltermodel{$czycolorbox}').unbind("keypress");
    $('#txtfiltermodel{$czycolorbox}').keypress(function(event) {
        if (event.keyCode == 13) {
            showAlerts('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
        }
    });
    $('#txtfilterklient{$czycolorbox}').unbind("keypress");
    $('#txtfilterklient{$czycolorbox}').keypress(function(event) {
        if (event.keyCode == 13) {
            showAlerts('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');return false;
        }
    });

    showAlerts('divRightCenter{$czycolorbox}','divLoader{$czycolorbox}','{$czycolorbox}');
</script>