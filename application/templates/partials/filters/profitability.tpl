{include file="../filters-button.tpl"}

<div class="otus-filters-panel p-4">
    {include file="../close-button.tpl"}
    <form>
        <div class="form-group">
            <label for="txtfilterserial">okres (od roku)</label>
        </div>
        <div class="form-group">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="First group" aria-describedby="dateRangeHelp">
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from='2013-08-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2013</button>
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from='2015-05-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2015</button>
                    <button type="button" class="btn btn-outline-secondary form-control"
                            ng-click="date_from='2016-06-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2016</button>
                </div>
            </div>
            <small id="dateRangeHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj od którego roku.</small>
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

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.show_devices_view">
            <label for='paidHelp'>
                widok urządzeń
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż widok urządzeń</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="show_inactive" ng-change="ctrl.showInactive(show_inactive)">
            <label for='paidHelp'>
                umowy nieaktywne
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż umowy nieaktywne</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.showLossOnly">
            <label for='paidHelp'>
                tylko strata
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko strate</small>
        </div>

        <div class="form-group mt-4">
            <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.showWithCost">
            <label for='paidHelp'>
                tylko z kosztami
            </label>
            <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko z kosztami</small>
        </div>

        <div class="form-group" ng-if="!ctrl.show_devices_view">
            <label for="txtklient">klient</label>
        </div>
        <div class="form-group" ng-if="!ctrl.show_devices_view">
            <input type="text" id="txtklient" class="form-control"
                   aria-describedby="clientHelp" ng-model="search.name">
            <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                klienta</small>
        </div>

        <div class="border-top my-4 otus-separator"></div>

        <div class="form-group">
            <button class="btn btn-info btn-block" type="submit"
                    ng-click='ctrl.loadData(date_from, date_to, show_inactive)'>
                Pokaż
            </button>
        </div>

    </form>
</div>