<div>
<div class="divFilter">
    <label class="labelNormal">
        nazwa
        <input type="text" ng-model="clientsFilter.nazwa"></label>
    <label class="labelNormal">
        miasto
        <input type="text" ng-model="clientsFilter.miasto"></label>
    <label class="labelNormal">
        ulica
        <input type="text" ng-model="clientsFilter.ulica"></label>
    <label class="labelNormal">
        nip
        <input type="text" ng-model="clientsFilter.nip"></label>

</div>

<table class='tablesorter displaytable' cellspacing=0 cellpadding=0>
    <thead>
    <tr>
        <th style='min-width: 50px;width:50px;'>
            Lp
        </th >
        <th style='cursor:pointer; min-width: 165px;width:165px;' ng-click="clientsSortBy = 'nazwa'">
            nazwa <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'nazwa'"></i>
        </th >
        <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'miasto'">
            kod/miasto <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'miasto'"></i>
        </th>
        <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'ulica'">
            adres <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'ulica'"></i>
        </th>
        <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'nip'">
            nip <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'nip'"></i>
        </th>

        <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'telefon'">
            telefon <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'telefon'"></i>
        </th>
        <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'mail'">
            mail <i class="fas fa-sort-desc" ng-if="clientsSortBy == 'mail'"></i>
        </th>
        <th style='min-width: 75px;width:75px;' align="center">
            <a ng-click="ctrl.openAddEditClient()"><i class="fas fa-plus fa-2x" style="color: green"></i></a>
        </th>
    </tr>
    </thead>
    <tbody>

    <tr ng-repeat="client in ctrl.getClients() | filter: clientsFilter | orderBy: clientsSortBy" ng-click="ctrl.setData(clientData, client); ctrl.goToRefUrl()" style="cursor: pointer">
        <td>[[$index+1]]</td>
        <td>[[client.nazwa]]</td>
        <td>[[client.kodpocztowy]] [[client.miasto]]</td>
        <td>[[client.ulica]]</td>
        <td>[[client.nip]]</td>
        <td>[[client.telefon]]</td>
        <td>[[client.mail]]</td>
        <td align="center">&nbsp;
            <i class="fas fa-edit fa-2x" ng-click="ctrl.openAddEditClient(client)" style="color: darkgreen"></i>
        </td>
    </tr>
    </tbody>

</table>

<i ng-if="isPending" class="fas fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>

</div>