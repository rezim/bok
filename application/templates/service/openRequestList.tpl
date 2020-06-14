<table class="table table-condensed table-requests table-striped" data-search="true"
       data-filter-control="true" >
    <thead>
    <tr>
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('revers', requestsSortBy)">
            revers
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+revers'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-revers'"></i>
        </th >
        <th class="col-xs-2 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('nazwa', requestsSortBy)"
            data-filter-control="input" data-sortable="true">
            klient
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+nazwa'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-nazwa'"></i>
        </th >
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('modeldrukarki', requestsSortBy)">
            model
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+modeldrukarki'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-modeldrukarki'"></i>
        </th>
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('numerseryjny', requestsSortBy)">
            numer seryjny
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+numerseryjny'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-numerseryjny'"></i>
        </th>
        <th class="col-xs-3">
            opis usterki
        </th>
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('status', requestsSortBy)">
            status
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+status'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-status'"></i>
        </th>
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('date_insert', requestsSortBy)">
            czas zgłoszenia
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+date_insert'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-date_insert'"></i>
        </th>
        <th class="col-xs-1 sortable" ng-click="requestsSortBy = ctrl.changeSortOrder('userName', requestsSortBy)">
            wykonuje
            <i class="fas fa-sort-asc" ng-if="requestsSortBy == '+userName'"></i>
            <i class="fas fa-sort-desc" ng-if="requestsSortBy == '-userName'"></i>
        </th>
        <th class="col-xs-1" align="center">
            &nbsp;
            <button class="btn btn-primary btn-xs btn-filter" uib-btn-checkbox ng-model="requestShowFilters">
                <i class="fas fa-filter"></i> filtry
            </button>
        </th>
    </tr>
    </thead>
    <tbody>

    <tr class="filters" ng-if="requestShowFilters">
        <td><input type="text" class="form-control" placeholder="revers" ng-model="requestsFilter.revers_number"></td>
        <td><input type="text" class="form-control" placeholder="nazwa klienta" ng-model="requestsFilter.nazwa"></td>
        <td><input type="text" class="form-control" placeholder="model drukarki" ng-model="requestsFilter.modeldrukarki"></td>
        <td><input type="text" class="form-control" placeholder="numer seryjny" ng-model="requestsFilter.numerseryjny"></td>
        <td><input type="text" class="form-control" placeholder="opis usterki" ng-model="requestsFilter.opisusterki"></td>
        <td><input type="text" class="form-control" placeholder="status" ng-model="requestsFilter.status"></td>
        <td><input type="text" class="form-control" placeholder="data utworzenia" ng-model="requestsFilter.date_insert"></td>
        <td><input type="text" class="form-control" placeholder="wykonuje" ng-model="requestsFilter.userName"></td>
        <td></td>
    </tr>

    <tr ng-repeat="request in ctrl.getRequests() | filter: requestsFilter | orderBy: ctrl.normalizeRequestsSortBy(requestsSortBy)"
        ng-class="{literal}{'warning': request.rowid_status == -1, 'success': request.rowid_status == -1}{/literal}">
        <td>[[request.revers_number]]</td>
        <td class="text"><span title="[[request.nazwa]]">[[request.nazwa]]</span></td>
        <td>[[request.modeldrukarki]]</td>
        <td>[[request.numerseryjny]]</td>
        <td class="text"><span title="[[request.opisusterki]]">[[request.opisusterki]]</span></td>
        <td>[[request.status]]</td>
        <td>[[request.date_insert]]</td>
        <td align="center" ng-class="'group-' + (request.groupId || 0)">
            <i uib-popover="[[request.userName || 'W PULI']] [[request.userEmail || '']]"
               popover-trigger="'mouseenter'" class="fas fa-2x" ng-class="request.rowid_user == -1 ? 'fa-users' : 'fa-user'">
            </i>
        </td>
        <td>
            <i class="fas fa-print fa-2x" ng-click="ctrl.print('print-template', request)"></i>
            <i class="fas fa-edit fa-2x" ng-click="ctrl.setData(deviceData, request); ctrl.setData(clientData, request); ctrl.goTo('editRequest')"></i>
            <i class="fas fa-envelope-o fa-2x" ng-click="ctrl.openEmailList(request);">
                <span class="badge">[[request.unreadEmailsCount]]</span>
            </i>
            <i class="fas fa-list-ul fa-2x" ng-click="ctrl.openStatusHistory(request);">
        </td>
    </tr>


    </tbody>

</table>