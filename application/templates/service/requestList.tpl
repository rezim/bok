<div class="container table-responsive">
    <div class="divFilter">
        <label class="labelNormal">
            pokaż zamknięte
            <input type="checkbox" ng-model="showClosed" ng-click="ctrl.updateList(showClosed)">
        </label>
    </div>

    <table class="table table-condensed table-requests">
    <thead>
    <tr>
        <th>
            revers
        </th >
        <th>
            klient
        </th >
        <th>
            model
        </th>
        <th>
            numer seryjny
        </th>
        <th>
            opis usterki
        </th>
        <th>
            status
        </th>
        <th>
            czas zgłoszenia
        </th>
        <th>
            wykonuje
        </th>
        <th>
        </th>
    </tr>
    </thead>
    <tbody>

    <tr ng-repeat="request in ctrl.getRequests()" ng-class="{literal}{'warning': request.rowid_status == 3, 'success': request.rowid_status == 10}{/literal}">
        <td>[[request.revers_number]]</td>
        <td>[[request.nazwa]]</td>
        <td>[[request.modeldrukarki]]</td>
        <td>[[request.numerseryjny]]</td>
        <td>[[request.opisusterki]]</td>
        <td>[[request.status]]</td>
        <td>[[request.date_insert]]</td>
        <td align="center" ng-class="'group-' + (request.groupId || 0)">
            <i uib-popover="[[request.userName || 'W PULI']] [[request.userEmail || '']]"
               popover-trigger="'mouseenter'" class="fa fa-2x" ng-class="request.rowid_user == -1 ? 'fa-users' : 'fa-user'">
            </i>
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

<i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
</div>