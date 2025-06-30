{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form id="dataFilter" data-form>
        <div class="form-group">
            <label for="startDate">data od</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='startDate' class="form-control"
                   aria-describedby="dateFromHelp">
            <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                początkową.</small>
        </div>

        <div class="form-group">
            <label for="endDate">data do</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='endDate' class="form-control"
                   aria-describedby="dateToHelp">
            <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                końcową.</small>
        </div>

        <div class="form-group">
            <label for="endDate">miesiąc</label>
        </div>
        <div class="form-group">
            <select data-ref id='month' class="form-control" aria-describedby="monthHelp">
                <option value="" selected></option>
                {foreach from=$months item=item key=key}
                    <option value="{$rok}-{$key}-01">{$item}</option>
                {/foreach}
            </select>
            <small id="monthHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Wybierz
                miesiąc.</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="w-100"></div>

        <div class="form-group">
            <label for="clientName">klient</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='clientName' class="form-control"
                   aria-describedby="clientHelp">
            <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                klienta</small>
        </div>

        <div class="form-group">
            <label for="serial">nip</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='clientNip' class="form-control"
                   aria-describedby="deviceHelp">
            <small id="deviceHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nip
                klienta</small>
        </div>

        <div class="form-group mt-4">
            <input data-ref type="checkbox" aria-describedby="paidHelp" id='notProcessed'>
            <label for='paidHelp'>
                tylko nie przeprocesowane
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> tylko nie dodane do Fakturowni</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button id="applyFilter" class="btn btn-info btn-block" type="button">
                Filtruj
            </button>
        </div>
    </form>
</div>