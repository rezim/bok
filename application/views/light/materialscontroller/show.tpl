<div class="container-fluid">
    {include file="$templates/partials/filters/materials.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>

<!-- this should be replaced by angular based solution -->
<script type="text/javascript">
    $("#txtfilterdataod").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $("#txtfilterdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    const threeMonthPriorToToday = new Date();
    threeMonthPriorToToday.setMonth(threeMonthPriorToToday.getMonth()-3);
    threeMonthPriorToToday.setDate(1);
    $('#txtfilterdataod').val($.datepicker.formatDate('yy-mm-dd', threeMonthPriorToToday));
    $('#txtfilterdatado').val($.datepicker.formatDate('yy-mm-dd', new Date()));

    showMaterials();
</script>