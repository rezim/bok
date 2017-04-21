<div ng-app="app" ng-controller="ServiceCtrl as ctrl" ng-cloak class="service">

    <div ng-if="ctrl.mode == 'view'">
        <table class='tablesorter displaytable' cellspacing=0 cellpadding=0>
            <thead>
            <tr>
                <th style='min-width: 50px;width:50px;'>
                    Lp
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
                    <td>[[request.nazwa]]</td>
                    <td>[[request.modeldrukarki]]</td>
                    <td>[[request.numerseryjny]]</td>
                    <td>[[request.opisusterki]]</td>
                    <td>[[request.status]]</td>
                    <td>[[request.date_insert]]</td>
                    <td></td>
                    <td>
                        <i class="fa fa-print" ng-click="ctrl.print('print-template', request)"></i>
                        <i class="fa fa-edit" ng-click="ctrl.edit(request)"></i>
                    </td>
                </tr>


            </tbody>

        </table>

        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
    </div>

    <div ng-if="ctrl.mode == 'add'">
        <table class='tableform' cellpadding='0' cellspacing='0'>
            <tr>
                <td style="vertical-align: top">
                    <table class='tableform' cellpadding='0' cellspacing='0'>
                        <tbody>
                        <tr id='tr' ng-repeat="data in clientData">
                            <td  class='tdOpis'><span>[[data.title]]</span></td>
                            <td class='tdWartosc' ng-switch="data.type">
                                <input ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value" />
                                <textarea ng-switch-when="textarea" type="text" name='editobj' class="textareaForm" ng-model="data.value"></textarea>
                                <img ng-if="$index == 0" src="/bok/light/img/find.png" style="display:inline;margin-left: 5px;cursor:hand;cursor:pointer;" title="Wybierz">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
                <td style="vertical-align: top">
                    <table class='tableform' cellpadding='0' cellspacing='0'>
                        <tbody>
                        <tr id='tr' ng-repeat="data in deviceData" ng-if="data.title">
                            <td  class='tdOpis'><span>[[data.title]]</span></td>
                            <td class='tdWartosc' ng-switch="data.type">
                                <input ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value"/>
                                <textarea ng-switch-when="textarea" type="text" class="textareaForm" ng-model="data.value"></textarea>
                                <select ng-switch-when="select" ng-model="data.value" class="comboboxForm" ng-options="option.id as option.name for option in data.availableOptions()">
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">
                    <div class="actionbuttonZapisz" ng-click="ctrl.addNew()">Zapisz</div>
                </td>
            </tr>
        </table>
    </div>

    <div ng-if="ctrl.mode == 'edit'">
        <table class='tableform' cellpadding='0' cellspacing='0'>
            <tr>
                <td style="vertical-align: top">
                    <table class='tableform' cellpadding='0' cellspacing='0'>
                        <tbody>
                        <tr id='tr' ng-repeat="data in clientData" ng-if="data.title">
                            <td  class='tdOpis'><span>[[data.title]]</span></td>
                            <td class='tdWartosc' ng-switch="data.type">
                                <input ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value" />
                                <textarea ng-switch-when="textarea" type="text" name='editobj' class="textareaForm" ng-model="data.value"></textarea>
                                <img ng-if="$index == 0" src="/bok/light/img/find.png" style="display:inline;margin-left: 5px;cursor:hand;cursor:pointer;" title="Wybierz">
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
                <td style="vertical-align: top">
                    <table class='tableform' cellpadding='0' cellspacing='0'>
                        <tbody>
                        <tr id='tr' ng-repeat="data in deviceData" ng-if="data.title">
                            <td  class='tdOpis'><span>[[data.title]]</span></td>
                            <td class='tdWartosc' ng-switch="data.type">
                                <input ng-switch-when="text" type="text" name='editobj' class="textBoxForm" ng-model="data.value"/>
                                <textarea ng-switch-when="textarea" type="text" class="textareaForm" ng-model="data.value"></textarea>
                                <select ng-switch-when="select" ng-model="data.value" class="comboboxForm" ng-options="option.id as option.name for option in data.availableOptions()">
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">
                    <div class="actionbuttonZapisz" ng-click="ctrl.updateRequest()">Aktualizuj</div>
                </td>
            </tr>
        </table>
    </div>
    <div ng-show="false">
        <div id="print-template">
        <table class="printTable">
            <tr>
                <td colspan="2" align="left">
                    <div>
                        <img src="http://www.otus.pl/templates/otus/images/obraz/logo.png" alt="Otus" title="Otus" border="0" height="82" width="150">
                    </div>
                    <div>
                        {$smarty.const.BOK_OTUS_ADRES}, {$smarty.const.BOK_OTUS_ADRES2}
                    </div>
                    <div>
                        Tel.: {$smarty.const.BOK_OTUS_TELEFON}, {$smarty.const.BOK_OTUS_WWW}
                    </div>
                    <div>
                        {$smarty.const.BOK_OTUS_KONTO_BANKOWE}
                    </div>
                </td>
            </tr>
            <tr>
                <td width="60%"></td>
                <td width="40%" align="center" class="positionRight">
                    <div class="printSubHeader">Data sporządzenia wydruku</div>
                    <div>[[toPrint.date | date:'dd.MM.yyyy']]</div>
                </td>
            </tr>
            <tr>
                <td width="50%" class="positionLeft">
                    <div class="printSubHeader">Sprzedawca:</div>
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
                </td>
            </tr>
            <tr>
                <td width="50%" class="positionLeft">
                    <div class="printSubHeader"></div>
                </td>
                <td width="50%" class="positionRight">
                    <div class="printSubHeader"></div>
                </td>
            </tr>
            <tr><td colspan="2"><span>Rewers przyjęcia do serwisu </span> <span class="text-uppercase">[[toPrint.rowid]][[toPrint.date | date:'/MMM/yyyy']]</span></td></tr>
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
                    <table class="requestDetails">
                        <tr>
                            <th>Lp</th>
                            <th>Nazwa</th>
                            <th>PKWiU</th>
                            <th>Ilość</th>
                            <th>j.m.</th>
                            <th>Rabat <br/>[%]</th>
                            <th>Cenaa brutton</th>
                            <th>VAT <br/>[%]</th>
                            <th>Wartość netto</th>
                            <th>VAT</th>
                            <th>Wartość brutto</th>
                        </tr>
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-left">Naprawa Drukarki</td>
                            <td></td>
                            <td class="text-right">1,000</td>
                            <td class="text-center">szt.</td>
                            <td class="text-right">0,00</td>
                            <td class="text-right">0,00</td>
                            <td class="text-center">23</td>
                            <td class="text-right">0,00</td>
                            <td class="text-right">0,00</td>
                            <td class="text-right">0,00</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" valign="bottom">Ciąg dalszy na nstępnej stronie</td>
                <td align="right" valign="bottom">1</td>
            </tr>
        </table>

        <table class="printTable">
            <tr>
                <td colspan="2" align="left">
                    <div>
                        {$smarty.const.BOK_OTUS_ADRES}, {$smarty.const.BOK_OTUS_ADRES2}
                    </div>
                    <div>
                        Tel.: {$smarty.const.BOK_OTUS_TELEFON}, {$smarty.const.BOK_OTUS_WWW}
                    </div>
                    <div>
                        {$smarty.const.BOK_OTUS_KONTO_BANKOWE}
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%"></td>
                <td width="50%">
                    <div class="printSubHeader"><strong>Razem</strong><strong>0,00 PLN</strong></div>
                    <div><strong>Słownie:</strong> zero PLN 0/100</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <ol>
                        <li>Sprzęt przyjęty do serwisu jest diagnozowany tylko pod kątem usterki zgłoszonej przez klienta. Koszt diagnozy wynosi 30 zł  netto + 23 % VAT. Kwota ta nie jest pobierana w przypadku naprawy sprzętu w naszym serwisie.</li>
                        <li>Maksymalny czas naprawy wynosi 14 dni roboczych od daty dostarczenia sprzętu. W przypadku naprawy o szczególnym stopniu trudności lub wymagającej sprowadzenia części, termin naprawy może się przedłużyć po uzgodnieniu z klientem.</li>
                        <li>Serwis nie ponosi odpowiedzialności za dane pozostawione na nośnikach w urządzeniu (np. dyskach twardych) oraz dokumenty pozostawione w urządzeniu.</li>
                        <li>W przypadku gdy koszt naprawy nie przekracza kwoty 100 zł netto , klient zgadza się na naprawę urządzenia bez konsultacji kosztów z klientem.</li>
                        <li>Za sprzęt nieodebrany po 21 dniach od daty zakończenia naprawy serwis nalicza koszty magazynowania w wysokości 5 zł netto za każdy dzień. </li>
                        <li>Sprzęt nieodebrany w ciągu 90 dni od daty pozostawienia go do naprawy zostaje przekazany przez serwis do utylizacji na co klient wyraża zgodę.</li>
                        <li>Niniejszy dokument stanowi jedyną podstawę do odbioru sprzętu z serwisu.</li>
                        <li>Serwis zastrzega sobie prawo do odmowy naprawy. W takim przypadku serwis nie pobiera opłat.</li>
                    </ol>
                </td></tr>
            <tr>
                <td colspan="2">Zapozanalem sie i akceptuje warunki naprawy:</td></tr>
            <tr>
                <td width="50%" class="printSign"><div>Czytelny podpis klienta</div></td>
                <td width="50%"></td>
            </tr>

            <tr>
                <td width="50%"></td>
                <td width="50%">Potwierdzenie odbioru drukarki z serwisu:</td>
            </tr>
            <tr>
                <td width="50%"></td>
                <td width="50%" class="printSign"><div>data i czytelny podpis klienta</div></td>
            </tr>
            <tr>
                <td align="left" valign="bottom"></td>
                <td align="right" valign="bottom">2</td>
            </tr>
        </table>
    </div>
    </div>
</div>
