{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
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

        {show_txt_filter_option label="serial" id="filterserial" help="Podaj numer seryjny urządzenia."}
        {show_txt_filter_option label="model" id="filtermodel" help="Podaj model urządzenia."}
        {show_txt_filter_option label="klient" id="filterklient" help="Podaj nazwę klienta."}
        {show_txt_filter_option label="lokalizacja" id="filterlocation" help="Podaj lokalizację urządzenia."}
        {if $czycolorbox == ''}
            {show_check_filter_option checked="true" label="pokaż wszystkie" id="filtershowalsowithoutagreement" help="Pokaż również nie aktywne urządzenia."}
            {show_check_filter_option label="nie raportujące" id="showoutdatedonly" help="Pokaż tylko nie raportujące {$OUTDATED_COUNTERS_IN_DAYS_LIMIT} dni."}
        {/if}

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button id="applyFilter" class="btn btn-info btn-block" type="button">
                Filtruj
            </button>
        </div>
        <input type="hidden" id="czycolorbox" data-ref value="{$czycolorbox}">
    </form>
</div>