<div class="container-fluid">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form id="dataFilter" data-form>
                {if
                !$czycolorbox &&
                isset($smarty.session.przypisanemenu['but_addprinter']) &&
                $smarty.session.przypisanemenu['but_addprinter']['permission'] === 'rw'
                }
                    <div class="form-group otus-addnew otus-section">
                        <button type="button" class="btn btn-block btn-outline-secondary otus-action-btn"
                                onclick="showNewPrinterAdd(&quot;&quot;);return false;"><i class="fas fa-plus"></i>&nbsp;Nowe
                            Urządzenie
                        </button>
                    </div>
                    <div class="border-top mt-4 mb-2 otus-separator"></div>
                {/if}

{*                {show_txt_filter_option label="serial" id="filterserial" help="Podaj numer seryjny urządzenia."}*}
{*                {show_txt_filter_option label="model" id="filtermodel" help="Podaj model urządzenia."}*}
{*                {show_txt_filter_option label="klient" id="filterklient" help="Podaj nazwę klienta."}*}
{*                {show_txt_filter_option label="lokalizacja" id="filterlocation" help="Podaj lokalizację urządzenia."}*}
{*                {show_check_filter_option label="pokaż wszystkie" id="filtershowalsowithoutagreement" help="Pokaż również nie aktywne urządzenia."}*}
{*                {show_check_filter_option checked="true" label="nie raportujące" id="showoutdatedonly" help="Pokaż tylko nie raportujące {$OUTDATED_COUNTERS_IN_DAYS_LIMIT} dni."}*}

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button id="applyFilter" class="btn btn-info btn-block" type="button">
                        Filtruj
                    </button>
                </div>
            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl"></main>
    </div>
</div>
<script type="text/javascript">
    const dataContainerId = 'dataFilter';
    const templateId = 'divRightCenter';
    const actionButtonId = 'applyFilter';
    const fnRenderTemplate = () => renderTemplateAction("/printers/showdane/todiv", dataContainerId, templateId);

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