{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form id="dataFilter" data-form>
        {show_txt_filter_option label="klient" id="filterklient" help="Podaj nazwę klienta." value=$clientnazwakrotka|default:''}
        {show_txt_filter_option label="nip" id="filternip" help="Podaj NIP klienta."}
        {show_txt_filter_option label="numer FV" id="filtervat" help="Podaj numer Faktury VAT."}

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group mb-3">
            <div class="form-check">
                <input data-ref type="checkbox" class="form-check-input" id="filterOnlyUncollectible">
                <label class="form-check-label" for="filterOnlyUncollectible">
                    Pokaż tylko klientów nieściągalnych
                </label>
            </div>
            <small class="form-text text-muted">
                Domyślnie klienci nieściągalni są ukryci na liście dłużników.
            </small>
        </div>

        <div class="form-group mb-3">
            <div class="form-check">
                <input data-ref type="checkbox" class="form-check-input" id="filterIncludeNotOverdue">
                <label class="form-check-label" for="filterIncludeNotOverdue">
                    Pokaż również nieprzeterminowane nieopłacone faktury
                </label>
            </div>
            <small class="form-text text-muted">
                Domyślnie widoczne są tylko faktury przeterminowane.
            </small>
        </div>

        <div class="form-group">
            <button id="applyFilter" class="btn btn-info btn-block" type="button">
                Filtruj
            </button>
        </div>
    </form>
</div>