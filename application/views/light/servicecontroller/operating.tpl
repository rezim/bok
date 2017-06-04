<div ng-app="app" ng-controller="OperatingServiceCtrl as ctrl" ng-cloak class="service">

    {include file="$templates/service/modifyRequest.tpl"}

    <div ng-if="ctrl.mode == 'view'">
        <table class="table table-condensed table-requests table-striped">
            <thead>
            <tr>
                <th class="col-xs-1">
                    Lp
                </th >

                <th class="col-xs-2">
                    model
                </th>
                <th class="col-xs-2">
                    numer seryjny
                </th>
                <th class="col-xs-2">
                    opis usterki
                </th>
                <th class="col-xs-2">
                    status
                </th>
                <th class="col-xs-2">
                    czas zgłoszenia
                </th>
                <th class="col-xs-1">
                </th>
            </tr>
            </thead>
            <tbody>

                <tr ng-repeat="request in ctrl.getCurrentUserRequests()">
                    <td>[[$index+1]]</td>

                    <td>[[request.modeldrukarki]]</td>
                    <td>[[request.numerseryjny]]</td>
                    <td>[[request.opisusterki]]</td>
                    <td>[[request.status]]</td>
                    <td>[[request.date_insert]]</td>
                    <td>
                        <i class="fa fa-edit fa-2x" ng-click="ctrl.openUpdateRequest(request)" style="color: darkgreen"></i>
                    </td>
                </tr>


            </tbody>

        </table>

        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
    </div>

    <div ng-if="ctrl.mode == 'edit'">

    </div>

</div>

<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/operatingServiceCtrl.js?{$smarty.now}"></script>