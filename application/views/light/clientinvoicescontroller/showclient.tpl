<div class="container-fluid position-relative">
    {include file="$templates/partials/filters/debit-credit.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>
<script>
    const startAndEndDate = {
        startDate: new Date('2019-12-31'),
        endDate: new Date()
    };

    // startAndEndDate.startDate.setMonth(0,1);

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

    const renderTemplate = () => renderTemplateAction("/clientinvoices/showclientdata/todiv", dataContainerId, templateId);

    $("#applyFilter").on('click', renderTemplate);
    renderTemplate();
</script>

<script>
    const clientChannel = new BroadcastChannel("client-channel");

    clientChannel.onmessage = function (event) {

        if (!event || !event.data) return;

        const type = event.data.type;
        const nip = event.data.nip;

        if (type !== "CLIENT_INVOICES_OPENED" || !nip) return;

        const url = new URL(window.location.href);
        const pathParts = url.pathname.split("/").filter(Boolean);

        const basePath = "/bok/clientinvoices/showclient";

        const currentNip = pathParts[pathParts.length - 1];
        if (currentNip === nip) return;

        url.pathname = basePath + "/" + encodeURIComponent(nip);
        window.location.href = url.toString();
    };
</script>