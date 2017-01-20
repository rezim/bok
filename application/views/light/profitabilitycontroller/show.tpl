<script type="text/javascript">
    app.constant('appConf', {
        API_TOKEN: '{$smarty.const.FAKTUROWNIA_APITOKEN}',
        ENDPOINT: '{$smarty.const.FAKTUROWNIA_ENDPOINT}'
    });
</script>
<div ng-app="app" ng-controller="ProfitabilityCtrl as ctrl">
<div class='divFilter'>
    <a href="javascript:void(0)" ng-click="date_from='2013-08-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)" style="padding: 20px">od 2013</a>|
    <a href="javascript:void(0)" ng-click="date_from='2015-05-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)" style="padding: 20px">od 2015</a>|
    <a href="javascript:void(0)" ng-click="date_from='2016-06-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)" style="padding: 20px">od 2016</a>
     <label for="txtdataod" class="labelNormal" >data od</label>
     <input type="text" id='txtdataod' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_from">
     <label for="txtdatado" class="labelNormal" >data do</label>
     <input type="text" id='txtdatado' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_to">
     <a href="#" class="buttonpokaz" ng-click='ctrl.loadData(date_from, date_to, show_inactive)'>Pokaż</a>
</div>

<div class="divFilter" ng-if="ctrl.getProfits().length">
    <label class="labelNormal" style="padding-right: 30px">
        pokaż umowy nieaktywne
        <input type="checkbox" ng-model="show_inactive" ng-change="ctrl.showInactive(show_inactive)"/></label>
    <label class="labelNormal" style="padding-right: 30px">
        tylko strata
        <input type="checkbox" ng-model="ctrl.showLossOnly"/></label>
    <label class="labelNormal" style="padding-right: 30px">
        tylko z kosztami
        <input type="checkbox" ng-model="ctrl.showWithCost"/></label>
    <label class="labelNormal" style="padding-right: 30px">
        klient <input type="text" class='textBoxNormal' ng-model="search.name">
    </label>
</div>
<div>
    <div>
        <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
            <thead>
            <tr>
                <th width="200px">
                    nazwa
                </th>
                <th width="200px" style="text-align: right">
                    wartosc urzadzen
                </th>
                <th width="200px" style="text-align: right">
                    przychód
                </th>
                <th width="200px" style="text-align: right">
                    suma kosztów
                </th>
                <th width="200px" style="text-align: right">
                    dochód
                </th>
            </tr>
            <tr ng-if="profits.length && !isPending">
                <td align="right"><b>suma:</b></td>
                <td align="right"><b>[[(profits | sumOfValue:'sum':'wartoscUrzadzen') | currency: '']]</b></td>
                <td align="right" class="profit"><b>[[(profits | sumOfValue:'invoice':'sum') | currency: '']]</b></td>
                <td align="right" class="cost"><b>[[(profits | sumOfValue:'sum':'total') | currency: '']]</b></td>
                <td align="right" ng-class="((profits | sumOfDifferences:'invoice':'sum':'sum':'total') >=0) ? 'profit' : 'cost'"><b>[[(profits | sumOfDifferences:'invoice':'sum':'sum':'total') | currency: '']]</b></td>
            </tr>
            </thead>
            <tbody ng-repeat="profit in profits = (ctrl.getProfits() | filter:search | showProfits: ctrl.showLossOnly | showWithCosts: ctrl.showWithCost | orderBy: 'name')">

                <tr ng-click="show_row=!show_row">
                    <td class='tdLink'>[[profit.name]]</td>
                    <td align="right">[[profit.sum.wartoscUrzadzen | currency: '']]</td>
                    <td align="right" class="profit">[[profit.invoice.sum | currency: '']]</td>
                    <td align="right" class="cost">[[profit.sum.total | currency: '']]</td>
                    <td align="right" ng-class="((profit.invoice.sum - profit.sum.total) >= 0) ? 'profit' : 'cost'">[[(profit.invoice.sum - profit.sum.total) | currency: '']]</td>
                </tr>
                <tr ng-if="show_row">
                    <td colspan="5" class="inner-table">

                    <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
                        <thead>
                        <tr>
                            <th width="200px">
                                numer umowy
                            </th>
                            <th width="200px">
                                aktywna
                            </th>
                            <th width="200px" style="text-align: right">
                                wartosc urzadzenia
                            </th>
                            <th width="200px" style="text-align: right">
                                przychód
                            </th>
                            <th width="200px" style="text-align: right">
                                suma kosztów
                            </th>
                            <th width="200px" style="text-align: right">
                                dochód
                            </th>
                        </tr>
                        </thead>
                        <tbody ng-repeat="agreement in profit.agreements" ng-class="(agreement.agreementIsActive) ? '' : 'inactive-agreement'">
                            <tr ng-click="show_notifications=!show_notifications">
                                <td align="left">[[agreement.agreementRowId]]</td>
                                <td align="left">[[(agreement.agreementIsActive) ? 'tak' : 'nie']]</td>
                                <td align="right">[[agreement.agreementValueUnit | currency: '']]</td>
                                <td align="right" class="profit">
                                    <i ng-if="ctrl.getInvoiceDetails(profit.invoice.list, profit.nip).isPending" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                    [[(ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) | currency: '']]
                                </td>
                                <td align="right" class="cost">[[agreement.sum.total | currency: '']]</td>
                                <td align="right" ng-class="((ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) - agreement.sum.total) >= 0 ? 'profit' : 'cost' ">
                                    [[((ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) - agreement.sum.total) | currency: '']]
                                </td>
                            </tr>
                            <tr ng-if="show_notifications">
                                <td colspan="6" class="inner-table" style="background-color: #f9fbbb">
                                <table>
                                    <thead>
                                    <tr>
                                    <th width="200px">serial</th>
                                    <th width="200px">zgłaszający</th>
                                    <th width="200px">temat</th>
                                    <th width="200px">data zakończenia</th>
                                    <th width="200px" style="text-align: right">koszt kilometrów</th>
                                    <th width="200px" style="text-align: right">koszt pracy</th>
                                    <th width="200px" style="text-align: right">koszt materiałów</th>
                                    <th width="100px" style="text-align: right"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat="notification in ctrl.getAgreementNotifications(date_from, date_to, agreement.agreementId)">
                                        <td>
                                            [[notification.serial]]
                                        </td>
                                        <td>
                                            [[notification.osobazglaszajaca]]
                                        </td>
                                        <td>
                                            [[notification.temat]]
                                        </td>
                                        <td align="center">
                                            [[ctrl.getDate(notification.date_zakonczenia)]]
                                        </td>
                                        <td align="right" class="cost">
                                            [[notification.koszt_ilosc_km | currency: '']]
                                        </td>
                                        <td align="right" class="cost">
                                            [[notification.koszt_czas_pracy | currency: '']]
                                        </td>
                                        <td align="right" class="cost">
                                            [[notification.koszt_wartosc_materialow | currency: '']]
                                        </td>
                                        <td align="center" style="color: darkgray; cursor: pointer;">
                                            <i colorbox html="[[ctrl.getNotificationTemplate(notification)]]" class="fa fa-envelope" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                        </tbody>
                        </table>
                    </>
                </tr>
            </tbody>
        </table>
        <i ng-if="isPending" class="fa fa-spinner fa-spin fa-5x" aria-hidden="true" style="margin-top: 50px;"></i>
    </div>
</div>
    <!-- this should be replaced by angular based solution -->
<script type="text/javascript">
                    $( "#txtdataod" ).datepicker
                    ($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        showOtherMonths: true,
                        selectOtherMonths: true
                    });
                    $( "#txtdatado" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        showOtherMonths: true,
                        selectOtherMonths: true });
</script>