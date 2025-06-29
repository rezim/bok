<div class="container-fluid position-relative">
    {include file="$templates/partials/filters/device-counters.tpl"}
    {include file="$templates/partials/main.tpl" mainId="deviceCountersData"}
</div>
<script type="text/javascript">
    const dataContainerId = 'dataFilter';
    const templateId = 'deviceCountersData';
    const actionButtonId = 'applyFilter';
    const fnRenderTemplate = async () => {
        const doneCallback = function () {
            $("#tablePrinter").tablesorter()
        };
        renderTemplateAction("/devicecounters/showdaneklient/todiv", dataContainerId, templateId, null, doneCallback);
    }

    // on enter press (any input in the form)
    $('#' + dataContainerId + ' input').unbind("keypress").keypress((event) => {
        if (event.keyCode === 13) {
            event.preventDefault();
            fnRenderTemplate();
        }
    });

    // on filter button click
    $('#' + actionButtonId).on('click', fnRenderTemplate);

    // first render
    fnRenderTemplate();

</script>