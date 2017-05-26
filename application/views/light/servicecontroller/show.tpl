<div ng-app="app" ng-controller="ServiceCtrl as ctrl" ng-cloak class="service">

    {include file="$templates/service/modalEmail.tpl"}
    {include file="$templates/service/emailList.tpl"}
    {include file="$templates/service/statusHistory.tpl"}
    {include file="$templates/service/addEditClient.tpl"}
    {include file="$templates/service/addEditRequest.tpl"}

    <!-- Add new client -->
    <div ng-if="ctrl.mode == 'addClient'">
        <div ng-include src="'addEditClient'" ng-init="client=ctrl.getCleanData(clientData); mode='add'">
        </div>
    </div>

    <!-- Edit Client -->
    <div ng-if="ctrl.mode == 'editClient'">
        <div ng-include src="'addEditClient'" ng-init="client=selectedClient; mode='edit'">
        </div>
    </div>

    <!-- List of clients -->
    <div ng-if="ctrl.mode == 'clients'">
        {include file="$templates/service/clientList.tpl"}
    </div>

    <!-- Add new request -->
    <div ng-if="ctrl.mode == 'addRequest'">
        <div ng-include src="'addEditRequest'" ng-init="breakIdx=8; client=clientData; request=ctrl.getCleanData(deviceData); mode='add'">
        </div>
    </div>

    <!-- Edit request -->
    <div ng-if="ctrl.mode == 'editRequest'">
        <div ng-include src="'addEditRequest'" ng-init="breakIdx=8; client=clientData; request=deviceData; mode='edit'">
        </div>
    </div>

    <!-- List of requests -->
    <div ng-if="ctrl.mode == 'view'">
        {include file="$templates/service/requestList.tpl"}
    </div>

    <!-- Print -->
    <div ng-show="false">
        {include file="$templates/service/print.tpl"}
    </div>
</div>
