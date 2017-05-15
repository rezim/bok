<!-- Add/Edit Request Template -->
<script type="text/ng-template" id="addEditRequest">
    <table width="100%">
        <tr>
            <td valign="top">
                <table class='tableform' cellpadding='0' cellspacing='0'>
                    <tbody>
                    <tr>
                        <td colspan="2" class='tdSection'><span>Dane klienta</span></td>
                    </tr>
                    <tr id='tr' ng-repeat="data in client" ng-if="$index == 0">
                        <td  class='tdOpis'><span>[[data.title]]</span></td>
                        <td class='tdWartosc' ng-switch="data.type">
                            <input disabled="true" ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value" />
                            <textarea disabled="true" ng-switch-when="textarea" type="text" name='editobj' class="textareaForm" ng-model="data.value"></textarea>
                            <img ng-if="$index == 0" src="/bok/light/img/find.png" style="display:inline;margin-left: 5px;cursor:hand;cursor:pointer;" title="Wybierz" ng-click="mode=='add' ? ctrl.goTo('clients', 'addRequest') : ctrl.goTo('clients', 'editRequest')">
                        </td>
                    </tr>
                    <tr id='tr' ng-repeat="data in request" ng-if="data.title && $index < (breakIdx || 1000)">
                        <td  class='tdOpis' ng-if="data.type != 'section'"><span>[[data.title]]</span></td>
                        <td class='tdWartosc' ng-if="data.type != 'section'" ng-switch="data.type">
                            <input ng-disabled="data.readonly" ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value"/>
                            <textarea ng-disabled="data.readonly" ng-switch-when="textarea" type="text" class="textareaForm" ng-model="data.value"></textarea>
                            <select ng-disabled="data.readonly" ng-switch-when="select" ng-model="data.value" class="comboboxForm" ng-options="option.id as option.name for option in data.availableOptions()">
                            </select>
                        </td>
                        <td ng-if="data.type == 'section'" colspan="2" class='tdSection'>
                            <span>[[data.title]]</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td valign="top">
                <table class='tableform' cellpadding='0' cellspacing='0'>
                    <tbody>
                    <tr id='tr' ng-repeat="data in request" ng-if="data.title && $index >= (breakIdx || 1000)">
                        <td  class='tdOpis' ng-if="data.type != 'section'"><span>[[data.title]]</span></td>
                        <td class='tdWartosc' ng-if="data.type != 'section'" ng-switch="data.type">
                            <input ng-disabled="data.readonly" ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value"/>
                            <textarea ng-disabled="data.readonly" ng-switch-when="textarea" type="text" class="textareaForm" ng-model="data.value"></textarea>
                            <select ng-disabled="data.readonly" ng-switch-when="select" ng-model="data.value" class="comboboxForm" ng-options="option.id as option.name for option in data.availableOptions()">
                            </select>
                        </td>
                        <td ng-if="data.type == 'section'" colspan="2" class='tdSection'>
                            <div>[[data.title]]</div>
                            <div ng-if="data.title == 'Dane kontaktowe'" style="float: right;">
                                takie same jak klienta
                                <input type="checkbox" ng-model="contactSameAsClient" ng-disabled="!client[0].value" ng-change="ctrl.sameAsClientContact(contactSameAsClient, request)">
                            </div>
                            <div ng-if="data.title == 'Adres dostawy'" style="float: right;">
                                taki sam jak adres klienta
                                <input type="checkbox" ng-model="addressSameAsClient" ng-disabled="!client[0].value" ng-change="ctrl.sameAsClientAddress(addressSameAsClient, request)">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">
                <div ng-if="mode=='add'" class="actionbuttonZapisz" ng-click="ctrl.addNewRequest(request, client)">Dodaj</div>
                <div ng-if="mode=='edit'" class="actionbuttonZapisz" ng-click="ctrl.updateRequest(request, client)">Zapisz</div>
                <div class="buttonDeclin" ng-click="ctrl.goTo('view', '')">Anuluj</div>
            </td>
        </tr>
    </table>
</script>