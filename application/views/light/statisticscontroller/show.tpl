<div class="container-fluid">
    {include file="$templates/partials/filters/statistics.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>

<script type="text/javascript">
    $('#txtfilterdataod').unbind("keypress");
    $('#txtfilterdataod').keypress(function (event) {
        if (event.keyCode == 13) {
            showStatistics();
            return false;
        }
    });
    $('#txtfilterdatado').unbind("keypress");
    $('#txtfilterdatado').keypress(function (event) {
        if (event.keyCode == 13) {
            showStatistics();
            return false;
        }
    });
    $("#txtfilterdataod").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });
    $("#txtfilterdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd", changeMonth: true,
        changeYear: true,
    });

    showStatistics();
</script>