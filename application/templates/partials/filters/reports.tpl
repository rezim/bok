{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form id="dataFilter" data-form>
        <div class="form-group">
            <label for="txtdataod">data od</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtdataod' class="form-control"
                   aria-describedby="dateFromHelp">
            <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                początkową.</small>
        </div>

        <div class="form-group">
            <label for="txtdatado">data do</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtdatado' class="form-control"
                   aria-describedby="dateToHelp">
            <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                końcową.</small>
        </div>

        <div class="form-group">
            <label for="txtdatado">miesiąc</label>
        </div>
        <div class="form-group">
            <select id='txtmiesiac' class="form-control"
                    onchange="changeMiesiac(this);" aria-describedby="monthHelp">
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
            <label for="txtklient">klient</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='filterklient' class="form-control"
                   aria-describedby="clientHelp">
            <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                klienta</small>
        </div>

        <div class="form-group">
            <label for="txtserial">drukarka</label>
        </div>
        <div class="form-group">
            <input data-ref type="text" id='filterserial' class="form-control"
                   aria-describedby="deviceHelp">
            <small id="deviceHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj serial
                urządzenia</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" id='checkShowClientWithAllIssuedInvoices'
                   aria-describedby="showClientWithAllIssuedInvoices"
                   onclick="invMgr.showClientWithAllIssuedInvoices(!this.checked)"/>
            <label for="checkShowClientWithAllIssuedInvoices">Ukryj klientów z wystawionymi fakturami</label>
            <small id="closedAgreementsHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i>
                Ukryj klientów z wystawionymi fakturami.</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    onClick='startReportGeneration();return false;'>
                Generuj
            </button>
        </div>
        <div class="form-group">
            <button class="btn btn-success btn-block" type="button" data-toggle="modal"
                    data-target="#exampleModal">
                Wystaw faktury
            </button>
        </div>

        <div class="form-group">
            <button class="btn btn-danger btn-block" type="button"
                    onclick="fixDeviceCounters(invMgr.getReportData())">
                Popraw Liczniki Urządzeń
            </button>
        </div>
    </form>
</div>