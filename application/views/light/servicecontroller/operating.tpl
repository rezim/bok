<div ng-app="app" ng-controller="OperatingServiceCtrl as ctrl" ng-cloak class="service">

    <div ng-if="ctrl.mode == 'view'">
        <table class='tablesorter displaytable' cellspacing=0 cellpadding=0>
            <thead>
            <tr>
                <th style='min-width: 50px;width:50px;'>
                    Lp
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
                <th style='min-width: 75px;width:75px;'>
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
                    <td></td>
                    <td>
                        <i class="fa fa-edit fa-2x" ng-click="ctrl.edit(request)" style="color: darkgreen"></i>
                    </td>
                </tr>


            </tbody>

        </table>

        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
    </div>

    <div ng-if="ctrl.mode == 'edit'">
        <table class='tableform' cellpadding='0' cellspacing='0'>
            <tr>
                <td style="vertical-align: top">
                    <table class='tableform' cellpadding='0' cellspacing='0'>
                        <tbody>
                        <tr id='tr' ng-repeat="data in deviceData" ng-if="data.title && (!data.hide || !data.hide())">
                            <td  class='tdOpis'><span>[[data.title]]</span></td>
                            <td class='tdWartosc' ng-switch="data.type">
                                <input ng-disabled="data.readonly" ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value"/>
                                <textarea ng-disabled="data.readonly" ng-switch-when="textarea" type="text" class="textareaForm" ng-model="data.value"></textarea>
                                <select ng-disabled="data.readonly" ng-switch-when="select" ng-model="data.value" class="comboboxForm" ng-options="option.id as option.name for option in data.availableOptions()">
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">
                    <div class="actionbuttonZapisz" ng-click="ctrl.updateRequest()">Zapisz</div>
                    <div class="buttonDeclin" ng-click="ctrl.goTo('view', '')">Anuluj</div>
                </td>
            </tr>
        </table>
    </div>

</div>

<script type="text/javascript" src="{$smarty.const.SCIEZKA}/js/angular/ctrl/operatingServiceCtrl.js?{$smarty.now}"></script>