<div>
    <div class="divFilter">
        <label class="labelNormal">
            pokaż zamknięte
            <input type="checkbox" ng-model="showClosed" ng-click="ctrl.updateList(showClosed)">
        </label>
    </div>
<table class='tablesorter displaytable' cellspacing=0 cellpadding=0>
    <thead>
    <tr>
        <th style='min-width: 50px;width:50px;'>
            Lp
        </th >
        <th style='min-width: 75px;width:75px;'>
            Revers
        </th >
        <th style='min-width: 165px;width:165px;'>
            Klient
        </th >
        <th style='min-width: 115px;width:115px;'>
            model drukarki
        </th>
        <th style='min-width: 115px;width:115px;'>
            numer seryjny
        </th>
        <th style='min-width: 115px;width:115px;'>
            opis usterki
        </th>
        <th style='min-width: 115px;width:115px;'>
            status
        </th>
        <th style='min-width: 160px;width:160px;'>
            czas zgłoszenia
        </th>
        <th style='min-width: 160px;width:160px;'>
            czas zakończenia
        </th>
        <th style='min-width: 95px;width:95px;'>
        </th>
    </tr>
    </thead>
    <tbody>

    <tr ng-repeat="request in ctrl.getRequests()">
        <td>[[$index+1]]</td>
        <td>[[request.revers_number]]</td>
        <td>[[request.nazwa]]</td>
        <td>[[request.modeldrukarki]]</td>
        <td>[[request.numerseryjny]]</td>
        <td>[[request.opisusterki]]</td>
        <td>[[request.status]]</td>
        <td>[[request.date_insert]]</td>
        <td></td>
        <td>
            <i class="fa fa-print fa-2x" ng-click="ctrl.print('print-template', request)"></i>
            <i class="fa fa-edit fa-2x" ng-click="ctrl.setData(deviceData, request); ctrl.setData(clientData, request); ctrl.goTo('editRequest')"></i>
            <i class="fa fa-envelope-o fa-2x" ng-click="ctrl.openEmailList(request);">
                <span class="badge">[[request.unreadEmailsCount]]</span>
            </i>
        </td>
    </tr>


    </tbody>

</table>

<i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
</div>