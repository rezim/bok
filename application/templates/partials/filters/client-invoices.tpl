{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form>
        <div class="form-group">
            <label for="txtfilterserial">okres (miesięcy)</label>
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


        <div class="form-group">
            <label for="txtDaysLate">Ilość dni spóźnienia</label>
        </div>
        <div class="form-group">
            <input type="text" id="txtDaysLate" class="form-control"
                   aria-describedby="txtDaysLateHelp" ng-model="ctrl.filters.days_late">
            <small id="txtDaysLateHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                ilość dni opóźnienia w płatności</small>
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

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.filters.show_paid_invoices">
            <label for='paidHelp'>
                opłacone
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż faktury
                opłacone</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.filters.show_overpaid_invoices">
            <label for='paidHelp'>
                z nadpłatą
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż klientów z
                nadpłatą</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.filters.show_non_deptors">
            <label for='paidHelp'>
                bez zadłużenia
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż klientów
                bez zadłużenia</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    ng-click='ctrl.loadData(date_from, date_to, !ctrl.filters.show_paid_invoices)'>
                Pokaż
            </button>
        </div>

    </form>
</div>