<div class="container-fluid">
    {include file="$templates/partials/filters/payments-report.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>


<script>
    const startAndEndDate = getStartAndEndDate();

    $("#startDate").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
    $("#endDate").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));

    $("#month").on('change', (event) => {
        const selectedDate = $(event.target).val();
        const startAndEndDate = getStartAndEndDate(selectedDate);
        $("#startDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.startDate));
        $("#endDate").val($.datepicker.formatDate('yy-mm-dd', startAndEndDate.endDate));
    });
</script>

<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';

    $("#applyFilter").on('click', () => renderTemplateAction("/reports/paymentsreportdata/todiv", dataContainerId, templateId));
    renderTemplateAction("/reports/paymentsreportdata/todiv", dataContainerId, templateId);
</script>