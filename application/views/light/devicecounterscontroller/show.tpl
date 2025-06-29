<div class="container-fluid position-relative">

    <div class="otus-filter-iconbar">
        <button class="btn btn-light" id="showFilterPanel" type="button" title="Pokaż filtry" onclick="document.body.classList.add('otus-filters-open')">
            <i class="fa fa-filter"></i>
        </button>
    </div>

    <div class="otus-filters-panel p-4">
        <button class="close-btn btn btn-link"
                aria-label="Zamknij"
                onclick="document.body.classList.remove('otus-filters-open')">
            <i class="fa fa-window-close"></i>
        </button>
        <form id="dataFilter" data-form>
            {show_txt_filter_option label="serial" id="filterserial" help="Podaj numer seryjny urządzenia."}
            {show_txt_filter_option label="model" id="filtermodel" help="Podaj model urządzenia."}
            {show_txt_filter_option label="klient" id="filterklient" help="Podaj nazwę klienta."}
            {show_check_filter_option checked="true" label="drukarki" id="filtershowprinters" help="pokaż urządzenie typu drukarki."}
            {show_check_filter_option checked="true" label="skanery" id="filtershowscanners" help="pokaż urządzenia typu skanery."}

            <input data-ref type="hidden" id="dataod" name="dateFrom" value="{$dateFrom}">
            <input data-ref type="hidden" id="datado" name="dateTo" value="{$dateTo}">

            <button id="applyFilter" class="btn btn-info mt-3" type="button">
                Filtruj
            </button>
        </form>
    </div>

    <div class="otus-table-wrapper">
        <main id='deviceCountersData' class="col-12">

        </main>
    </div>
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