{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form id="dataFilter" data-form>
        <div class="form-group">
            <label for="upperDateLimit">Data do (domyślnie dzisiaj - 3 dni)</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='upperDateLimit' class="form-control"
                   aria-describedby="dateFromHelp">
            <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                graniczną dla liczników.</small>
        </div>

        <div class="form-group">
            <label for="serial">drukarka</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='serial' class="form-control"
                   aria-describedby="deviceHelp">
            <small id="deviceHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial
                urządzenia</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button id="applyFilter" class="btn btn-info btn-block" type="button">
                Filtruj
            </button>
        </div>
        <div class="form-group">
            <button id="sendAllEmails" class="btn btn-danger btn-block" type="button">
                Wyślij do wszystkich
            </button>
        </div>
    </form>
</div>