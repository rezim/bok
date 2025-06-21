<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>

                {show_txt_filter_option label="serial" id="filterserial" help="Podaj numer seryjny urządzenia."}
                {show_txt_filter_option label="model" id="filtermodel" help="Podaj model urządzenia."}
                {show_txt_filter_option label="klient" id="filterklient" help="Podaj nazwę klienta."}
                {show_check_filter_option checked="true" label="drukarki" id="filtershowprinters" help="pokaż urządzenie typu drukarki."}
                {show_check_filter_option checked="true" label="skanery" id="filtershowscanners" help="pokaż urządzenia typu skanery."}


                <div class="border-top my-4 otus-separator"></div>

                {assign var="dateFrom" value="first day of last month"|strtotime|date_format:"%Y-%m-%d"}
                {assign var="dateTo" value="first day of this month"|strtotime|date_format:"%Y-%m-%d"}
                <input data-ref type="hidden" id="dataod" name="dateFrom" value="{$dateFrom}">
                <input data-ref type="hidden" id="datado" name="dateTo" value="{$dateTo}">

                <div class="form-group">
                    <button id="applyFilter" class="btn btn-info btn-block" type="button">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>
        <main id='deviceCountersData' class="col-12 col-md-12 col-xl">

        </main>
    </div>

</div>
<script type="text/javascript">
    // $(function() {
    //  showPrintersCounters();
    // });

    var dateFrom = new Date();
    dateFrom.setDate(1);
    dateFrom.setMonth(dateFrom.getMonth() - 1);

    var dateTo = new Date(dateFrom);
    dateTo.setMonth(dateFrom.getMonth() + 1, 1);
    dateTo.setDate(1, 1);

    var params = {
        dateFrom: $.datepicker.formatDate('yy-mm-dd', dateFrom),
        dateTo: $.datepicker.formatDate('yy-mm-dd', dateTo)
    };

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