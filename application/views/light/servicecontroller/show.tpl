<div ng-app="app" ng-controller="ServiceCtrl as ctrl" ng-cloak class="service">

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
                    nazwa <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'nazwa'"></i>
                </th >
                <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'miasto'">
                    kod/miasto <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'miasto'"></i>
                </th>
                <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'ulica'">
                    adres <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'ulica'"></i>
                </th>
                <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'nip'">
                    nip <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'nip'"></i>
                </th>

                <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'telefon'">
                    telefon <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'telefon'"></i>
                </th>
                <th style='cursor:pointer; min-width: 115px;width:115px;' ng-click="clientsSortBy = 'mail'">
                    mail <i class="fa fa-sort-desc" ng-if="clientsSortBy == 'mail'"></i>
                </th>
                <th style='min-width: 75px;width:75px;' align="center">
                    <a ng-click="ctrl.goTo('addClient')"><i class="fa fa-plus fa-2x" style="color: green"></i></a>
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
                    <i class="fa fa-edit fa-2x" ng-click="ctrl.setSelectedClient(client); ctrl.goTo('editClient')" style="color: darkgreen"></i>
                </td>
            </tr>
            </tbody>

        </table>

        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
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
                <th style='min-width: 75px;width:75px;'>
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
                    <i class="fa fa-edit fa-2x" ng-click="ctrl.setData(deviceData, request); ctrl.setData(clientData, request); ctrl.goTo('editRequest')""></i>
                </td>
            </tr>


            </tbody>

        </table>

        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
    </div>

    <!-- Print -->
    <div ng-show="false">
        <div id="print-template">
            <table class="printTable">
            <tr>
                <td align="left">
                    <div>
                        <img src="http://www.otus.pl/templates/otus/images/obraz/logo.png" alt="Otus" title="Otus" border="0" height="82" width="150">
                    </div>
                    <div>
                        {$smarty.const.BOK_OTUS_ADRES}, {$smarty.const.BOK_OTUS_ADRES2}
                    </div>
                    <div>
                        tel.: {$smarty.const.BOK_OTUS_TELEFON}, {$smarty.const.BOK_OTUS_WWW}
                    </div>
                    <div>
                        {$smarty.const.BOK_OTUS_KONTO_BANKOWE}
                    </div>
                </td>
                <td width="50%" class="positionRight">
                    <div align="center" class="printSubHeader">Rewers przyjęcia do serwisu </div>
                    <div align="right" class="text-uppercase">[[toPrint.revers_number]]</div>
                    <div align="center" class="printSubHeader">Data sporządzenia wydruku</div>
                    <div align="right">[[toPrint.date | date:'dd.MM.yyyy']]</div>
                </td>
            </tr>
            <tr>
                <td width="50%" class="positionLeft">
                    <div class="printSubHeader" style="margin-top: 20px">Sprzedawca:</div>
                    <div>{$smarty.const.BOK_OTUS}</div>
                    <div>{$smarty.const.BOK_OTUS_ADRES}</div>
                    <div>{$smarty.const.BOK_OTUS_ADRES2}</div>
                    <div>NIP: {$smarty.const.BOK_OTUS_NIP}</div>
                </td>
                <td width="50%" align="center" class="positionRight">
                    <div class="printSubHeader">Klient:</div>
                    <div>[[toPrint.nazwa]]</div>
                    <div>[[toPrint.ulica]]</div>
                    <div>[[toPrint.kodpocztowy]] [[toPrint.miasto]]</div>
                    <div>Tel. [[toPrint.telefon]]</div>
                    <div>NIP: [[toPrint.nip]]</div>
                    <div>E-mail: [[toPrint.mail]]</div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                </td>
                <td width="50%" align="center" class="positionRight">
                    <div class="printSubHeader">Adres dostawy:</div>
                    <div>[[toPrint.imieinazwisko]]</div>
                    <div>[[toPrint.dostawa_ulica]]</div>
                    <div>[[toPrint.dostawa_kodpocztowy]] [[toPrint.miasto]]</div>
                    <div>Tel. [[toPrint.kontakt_telefon]]</div>
                    <div>E-mail: [[toPrint.kontakt_mail]]</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="requestDescription">
                        <div><span><strong>Model Drukarki:</strong></span><span>[[toPrint.modeldrukarki]]</span></div>
                        <div><span><strong>Numer Seryjny:</strong></span><span>[[toPrint.numerseryjny]]</span></div>
                        <div><div><strong>Opis Usterki:</strong></div><div>[[toPrint.opisusterki]]</div></div>
                        <div><div><strong>Uwagi Klienta:</strong></div><div>[[toPrint.uwagiklienta]]</div></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <ol>
                        <li>Sprzęt przyjęty do serwisu jest diagnozowany tylko pod kątem usterki zgłoszonej przez klienta. Koszt diagnozy wynosi 35 zł  netto + 23 % VAT. Kwota ta nie jest pobierana w przypadku naprawy sprzętu w naszym serwisie.</li>
                        <li>Maksymalny czas naprawy wynosi 14 dni roboczych od daty dostarczenia sprzętu. W przypadku naprawy o szczególnym stopniu trudności lub wymagającej sprowadzenia części, termin naprawy może się przedłużyć po uzgodnieniu z klientem.</li>
                        <li>Serwis nie ponosi odpowiedzialności za dane pozostawione na nośnikach w urządzeniu (np. dyskach twardych) oraz dokumenty pozostawione w urządzeniu.</li>
                        <li>W przypadku gdy koszt naprawy nie przekracza kwoty 100 zł netto , klient zgadza się na naprawę urządzenia bez konsultacji kosztów z klientem.</li>
                        <li>Za sprzęt nieodebrany po 21 dniach od daty zakończenia naprawy serwis nalicza koszty magazynowania w wysokości 5 zł netto za każdy dzień. </li>
                        <li>Sprzęt nieodebrany w ciągu 90 dni od daty pozostawienia go do naprawy zostaje przekazany przez serwis do utylizacji na co klient wyraża zgodę.</li>
                        <li>Niniejszy dokument stanowi jedyną podstawę do odbioru sprzętu z serwisu.</li>
                        <li>Serwis zastrzega sobie prawo do odmowy naprawy. W takim przypadku serwis nie pobiera opłat.</li>
                        <li>Rewers jest jedyną podstawą do odbioru sprzętu z serwisu.</li>
                    </ol>
                </td></tr>
            <tr>
                <td width="50%" align="center">Zapoznałem się i akceptuje warunki naprawy:</td>
                <td width="50%" align="center">Potwierdzenie odbioru drukarki z serwisu:</td>
            </tr>
            <tr>
                <td width="50%" align="center" class="printSign"><div>czytelny podpis klienta</div></td>
                <td width="50%" align="center" class="printSign"><div>data i czytelny podpis klienta</div></td>
            </tr>
        </table>
        </div>
    </div>


    {*<script type="text/ng-template" id="myModalContent.html">*}
        {*<div class="modal-header">*}
            {*<h3 class="modal-title" id="modal-title">I'm a modal!</h3>*}
        {*</div>*}
        {*<div class="modal-body" id="modal-body">*}
            {*This is my modal body, nothing else*}
        {*</div>*}
        {*<div class="modal-footer">*}
            {*<button class="btn btn-primary" type="button" ng-click="$ctrl.ok()">OK</button>*}
            {*<button class="btn btn-warning" type="button" ng-click="$ctrl.cancel()">Cancel</button>*}
        {*</div>*}
    {*</script>*}


    {*<button type="button" class="btn btn-default" ng-click="ctrl.openPopup()">Open me!</button>*}

</div>
