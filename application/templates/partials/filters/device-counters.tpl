{include file="../filters-button.tpl"}
<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
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