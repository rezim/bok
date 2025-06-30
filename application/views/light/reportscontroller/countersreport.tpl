<div class="container-fluid agreements">
    {include file="$templates/partials/filters/counter-report.tpl"}
    {include file="$templates/partials/main.tpl" mainId="divRightCenter"}
</div>

<script>
    const today = new Date();
    today.setDate(today.getDate() - 3);

    $("#upperDateLimit").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    }).val($.datepicker.formatDate('yy-mm-dd', today));
</script>
<script>
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';
    const applyFilters = () => renderTemplateAction("/reports/countersreportdata/todiv", dataContainerId, templateId);
    const sendEmail = (email, serial, model) => {
        callServiceWithDataAction("/reports/sendmail/notemplate", {
            email,
            serial,
            model
        }, null, applyFilters, (err) => alert(err));
    }
    const sendEmailWithoutReloading = (email, serial, model) => {
        callServiceWithDataAction("/reports/sendmail/notemplate", {
            email,
            serial,
            model
        }, null, null, null);
    }


    const sendAllEmails = () => {
        if (confirm('Czy na pewno chcesz wysłać do wszystkich klientów ?')) {
            const sendAllEmailsData = $('[data-ref][data]')
                .map((_, row) => {
                    const [email, serial, model] = row.getAttribute('data').split(',');
                    return { email, serial, model };
                }).get();

            sendAllEmailsData.forEach(
                ({ email, serial, model }) => sendEmailWithoutReloading(email, serial, model)
            );
            applyFilters();
        }
    }

    $("#applyFilter").on('click', applyFilters);
    $("#sendAllEmails").on('click', sendAllEmails);

    applyFilters();
</script>