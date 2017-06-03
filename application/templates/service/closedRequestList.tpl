<table class="table table-condensed table-requests table-striped">
    <thead>
    <tr>
        <th class="col-xs-1 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('revers', closedRequestsSortBy)">
            revers
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+revers'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-revers'"></i>
        </th >
        <th class="col-xs-3 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('nazwa', closedRequestsSortBy)">
            klient
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+nazwa'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-nazwa'"></i>
        </th >
        <th class="col-xs-1 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('modeldrukarki', closedRequestsSortBy)">
            model
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+modeldrukarki'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-modeldrukarki'"></i>
        </th>
        <th class="col-xs-1 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('numerseryjny', closedRequestsSortBy)">
            numer seryjny
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+numerseryjny'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-numerseryjny'"></i>
        </th>
        <th class="col-xs-3">
            opis usterki
        </th>
        <th class="col-xs-1 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('date_insert', closedRequestsSortBy)">
            czas zgłoszenia
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+date_insert'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-date_insert'"></i>
        </th>
        <th class="col-xs-1 sortable" ng-click="closedRequestsSortBy = ctrl.changeSortOrder('date_closed', closedRequestsSortBy)">
            czas zamknięcia
            <i class="fa fa-sort-asc" ng-if="closedRequestsSortBy == '+date_closed'"></i>
            <i class="fa fa-sort-desc" ng-if="closedRequestsSortBy == '-date_closed'"></i>
        </th>
        <th class="col-xs-1" align="center">
            &nbsp;
            <button class="btn btn-primary btn-xs btn-filter" uib-btn-checkbox ng-model="closedRequestShowFilters">
                <i class="fa fa-filter"></i> filtry
            </button>
        </th>
    </tr>
    </thead>
    <tbody>


    <tr class="filters" ng-if="closedRequestShowFilters">
        <td><input type="text" class="form-control" placeholder="revers" ng-model="closedRequestsFilter.revers_number"></td>
        <td><input type="text" class="form-control" placeholder="nazwa klienta" ng-model="closedRequestsFilter.nazwa"></td>
        <td><input type="text" class="form-control" placeholder="model drukarki" ng-model="closedRequestsFilter.modeldrukarki"></td>
        <td><input type="text" class="form-control" placeholder="numer seryjny" ng-model="closedRequestsFilter.numerseryjny"></td>
        <td><input type="text" class="form-control" placeholder="opis usterki" ng-model="closedRequestsFilter.opisusterki"></td>
        <td><input type="text" class="form-control" placeholder="data utworzenia" ng-model="closedRequestsFilter.date_insert"></td>
        <td><input type="text" class="form-control" placeholder="data zamknięcia" ng-model="closedRequestsFilter.date_closed"></td>
        <td></td>
    </tr>

    <tr ng-repeat="request in ctrl.getClosedRequests() | filter: closedRequestsFilter | orderBy: ctrl.normalizeRequestsSortBy(closedRequestsSortBy)"">
        <td>[[request.revers_number]]</td>
        <td class="text"><span>[[request.nazwa]]</span></td>
        <td>[[request.modeldrukarki]]</td>
        <td>[[request.numerseryjny]]</td>
        <td class="text"><span>[[request.opisusterki]]</span></td>
        <td>[[request.date_insert]]</td>
        <td>[[request.date_closed]]</td>
        <td>
            <i class="fa fa-print fa-2x" ng-click="ctrl.print('print-template', request)"></i>
            <i class="fa fa-edit fa-2x" ng-click="ctrl.setData(deviceData, request); ctrl.setData(clientData, request); ctrl.goTo('editRequest')"></i>
            <i class="fa fa-envelope-o fa-2x" ng-click="ctrl.openEmailList(request);">
                <span class="badge">[[request.unreadEmailsCount]]</span>
            </i>
            <i class="fa fa-list-ul fa-2x" ng-click="ctrl.openStatusHistory(request);">
        </td>
    </tr>


    </tbody>

</table>