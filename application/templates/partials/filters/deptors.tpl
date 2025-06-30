{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form>
        <div class="form-group">
            <label for="txtfilterserial">okres (miesięcy)</label>
        </div>
        <div class="form-group">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group"
                     aria-describedby="dateRangeHelp">
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from=ctrl.getLastMonths(24); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true, null, true)">
                        24
                    </button>
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from=ctrl.getLastMonths(12); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true, null, true)">
                        12
                    </button>
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from=ctrl.getLastMonths(6); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true, null, true)">
                        &nbsp;6
                    </button>
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from=ctrl.getLastMonths(3); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true, null, true)">
                        &nbsp;3
                    </button>
                </div>
            </div>
            <small id="dateRangeHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                okres w miesiącach.</small>
        </div>

        <div class="form-group">
            <label for="txtdataod">data od</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtdataod' class="form-control"
                   aria-describedby="dateFromHelp" ng-model="date_from" datepicker required>
            <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                początkową.</small>
        </div>

        <div class="form-group">
            <label for="txtdatado">data do</label>
        </div>
        <div class="form-group">
            <input type="text" id='txtdatado' class="form-control"
                   aria-describedby="dateToHelp" ng-model="date_to" datepicker required>
            <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                końcową.</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="w-100"></div>

        <div class="form-group">
            <label for="txtklient">klient</label>
        </div>

        <div class="form-group">
            <input type="text" id="txtklient" class="form-control"
                   aria-describedby="clientHelp" ng-model="search.name">
            <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                klienta</small>
        </div>

        <div class="form-group">
            <label for="txtclientnip">nip</label>
        </div>
        <div class="form-group">
            <input type="text" id="txtclientnip" class="form-control"
                   aria-describedby="clienNiptHelp" ng-model="search.nip">
            <small id="clienNiptHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj NIP
                klienta</small>
        </div>

        <div class="form-group">
            <label for="txtInvoiceNb">numer FV</label>
        </div>
        <div class="form-group">
            <input type="text" id="txtInvoiceNb" class="form-control"
                   aria-describedby="txtInvoiceNbHelp" ng-model="ctrl.filters.invoiceNb">
            <small id="txtInvoiceNbHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                numer Faktury VAT</small>
        </div>

        <div class="w-100"></div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    ng-click='ctrl.loadData(date_from, date_to, true, null, true)'>
                Pokaż
            </button>
        </div>

    </form>
</div>