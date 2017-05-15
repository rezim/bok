<!-- Add/Edit Client Template -->
<script type="text/ng-template" id="addEditClient">
    <table class='tableform' cellpadding='0' cellspacing='0'>
        <tbody>
        <tr id='tr' ng-repeat="data in client">
            <td  class='tdOpis'><span>[[data.title]]</span></td>
            <td class='tdWartosc' ng-switch="data.type">
                <input ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value" />
                <textarea ng-switch-when="textarea" type="text" name='editobj' class="textareaForm" ng-model="data.value"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right">
                <div ng-if="mode=='add'" class="actionbuttonZapisz" ng-click="ctrl.addClient(client, true)">Dodaj i Wybierz</div>
                <div ng-if="mode=='add'" class="actionbuttonZapisz" ng-click="ctrl.addClient(client)">Dodaj</div>
                <div ng-if="mode=='edit'" class="actionbuttonZapisz" ng-click="ctrl.updateClient(client, true)">Zapisz i Wybierz</div>
                <div ng-if="mode=='edit'" class="actionbuttonZapisz" ng-click="ctrl.updateClient(client)">Zapisz</div>
                <div class="buttonDeclin" ng-click="ctrl.cancelAction()" ng-if="ctrl.isCancelAvailable()">Anuluj</div>
            </td>
        </tr>
        </tbody>
    </table>
</script>