<script type="text/javascript">
    app.constant('appConf', {
        API_TOKEN: '{$smarty.const.FAKTUROWNIA_APITOKEN}',
        ENDPOINT: '{$smarty.const.FAKTUROWNIA_ENDPOINT}'
    });
</script>
<div class="container-fluid" ng-app="app" ng-controller="ProfitabilityCtrl as ctrl" ng-cloak>

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group">
                    <label for="txtfilterserial">okres (od roku)</label>
                </div>
                <div class="form-group">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group" aria-describedby="dateRangeHelp">
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from='2013-08-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2013</button>
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from='2015-05-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2015</button>
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from='2016-06-01'; date_to=ctrl.getToday(); ctrl.loadData(date_from, date_to)">2016</button>
                        </div>
                    </div>
                    <small id="dateRangeHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj od którego roku.</small>
                </div>

                <div class="form-group">
                    <label for="txtdataod">data od</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtdataod' class="form-control"
                           aria-describedby="dateFromHelp" ng-model="date_from" datepicker required>
                    <small id="dateFromHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        początkową.</small>
                </div>

                <div class="form-group">
                    <label for="txtdatado">data do</label>
                </div>
                <div class="form-group">
                    <input type="text" id='txtdatado' class="form-control"
                           aria-describedby="dateToHelp" ng-model="date_to" datepicker required>
                    <small id="dateToHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj datę
                        końcową.</small>
                </div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group mt-4">
                    <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.show_devices_view">
                    <label for='paidHelp'>
                        widok urządzeń
                    </label>
                    <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż widok urządzeń</small>
                </div>

                <div class="form-group mt-4">
                    <input type="checkbox" aria-describedby="paidHelp" ng-model="show_inactive" ng-change="ctrl.showInactive(show_inactive)">
                    <label for='paidHelp'>
                        umowy nieaktywne
                    </label>
                    <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż umowy nieaktywne</small>
                </div>

                <div class="form-group mt-4">
                    <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.showLossOnly">
                    <label for='paidHelp'>
                        tylko strata
                    </label>
                    <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko strate</small>
                </div>

                <div class="form-group mt-4">
                    <input type="checkbox" aria-describedby="paidHelp" ng-model="ctrl.showWithCost">
                    <label for='paidHelp'>
                        tylko z kosztami
                    </label>
                    <small id="paidHelp" class="form-text text-muted"><i class="fa fa-info-circle"></i> pokaż tylko z kosztami</small>
                </div>

                <div class="form-group" ng-if="!ctrl.show_devices_view">
                    <label for="txtklient">klient</label>
                </div>
                <div class="form-group" ng-if="!ctrl.show_devices_view">
                    <input type="text" id="txtklient" class="form-control"
                           aria-describedby="clientHelp" ng-model="search.name">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta</small>
                </div>

            </form>
        </div>

        <main id='divRightCenter' class="col-12 col-md-12 col-xl">
            <div class="table-responsive-sm">
                <table class='table table-hover table-sm tablesorter displaytable' id='tableReport'>
                    <thead class="thead-dark">
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
                    <tr ng-if="profits.length && !isPending && !ctrl.show_devices_view">
                        <td align="right"><b>suma:</b></td>
                        <td align="right"><b>[[(profits | sumOfValue:'sum':'wartoscUrzadzen') | currency: '']]</b></td>
                        <td align="right" class="profit"><b>[[(profits | sumOfValue:'invoice':'sum') | currency: '']]</b></td>
                        <td align="right" class="cost"><b>[[(profits | sumOfValue:'sum':'total') | currency: '']]</b></td>
                        <td align="right" ng-class="((profits | sumOfDifferences:'invoice':'sum':'sum':'total') >=0) ? 'profit' : 'cost'"><b>[[(profits | sumOfDifferences:'invoice':'sum':'sum':'total') | currency: '']]</b></td>
                    </tr>
                    <tr ng-if="ctrl.show_devices_view">
                        {*<td colspan="5">[[ctrl.getAgreements(ctrl.device)]]</td>*}
                        <td align="right"><b>suma:</b></td>
                        <td align="right"><b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'agreementValueUnit') | currency: '']]</b></td>
                        <td align="right" class="profit"><b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'netPrice') | currency: '']]</b></td>
                        <td align="right" class="cost"><b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'sum':'total') | currency: '']]</b></td>
                        <td align="right" ng-class="((ctrl.getAgreements(ctrl.device) | sumOfDifferences:'netPrice':'':'sum':'total') >=0) ? 'profit' : 'cost'"><b>[[(ctrl.getAgreements(ctrl.device) | sumOfDifferences:'netPrice':'':'sum':'total') | currency: '']]</b></td>
                    </tr>
                    </thead>
                    <tbody ng-repeat="profit in profits = (ctrl.getProfits() | filter:search | showProfits: ctrl.showLossOnly | showWithCosts: ctrl.showWithCost | orderBy: 'name')">

                    <tr ng-if="!ctrl.show_devices_view" ng-click="ctrl.show_details[profit.nip]= !ctrl.show_details[profit.nip]">
                        <td class='tdLink'>[[profit.name]]</td>
                        <td align="right">[[profit.sum.wartoscUrzadzen | currency: '']]</td>
                        <td align="right" class="profit">[[profit.invoice.sum | currency: '']]</td>
                        <td align="right" class="cost">[[profit.sum.total | currency: '']]</td>
                        <td align="right" ng-class="((profit.invoice.sum - profit.sum.total) >= 0) ? 'profit' : 'cost'">[[(profit.invoice.sum - profit.sum.total) | currency: '']]</td>
                    </tr>

                    <tr ng-if="(ctrl.show_details[profit.nip] || ctrl.show_devices_view) && (profit.agreements | filter: ctrl.device).length">
                        <td colspan="5" class="inner-table">

                            <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
                                <thead ng-if="!ctrl.show_devices_view || $index == 0">
                                <tr>
                                    <th>
                                        numer umowy
                                    </th>
                                    <th>
                                        aktywna
                                    </th>
                                    <th>
                                        model
                                    </th>
                                    <th style="text-align: right">
                                        wartosc urzadzenia
                                    </th>
                                    <th style="text-align: right">
                                        przychód
                                    </th>
                                    <th style="text-align: right">
                                        suma kosztów
                                    </th>
                                    <th style="text-align: right">
                                        dochód
                                    </th>
                                </tr>
                                </thead>
                                <tbody ng-repeat="agreement in profit.agreements | filter: ctrl.device" ng-class="(agreement.agreementIsActive) ? '' : 'inactive-agreement'">
                                <tr ng-if="$index == 0 && ctrl.show_devices_view"><td colspan="7">[[profit.name]]</td></tr>
                                <tr ng-click="show_notifications=!show_notifications">
                                    <td width="200px" align="left">[[agreement.agreementRowId]]</td>
                                    <td width="200px" align="left">[[(agreement.agreementIsActive) ? 'tak' : 'nie']]</td>
                                    <td width="200px" align="left">[[agreement.agreementPrinterModel]]</td>
                                    <td width="200px" align="right">[[agreement.agreementValueUnit | currency: '']]</td>
                                    <td width="200px" align="right" class="profit">
                                        <i ng-if="ctrl.getInvoiceDetails(profit.invoice.list, profit.nip).isPending" class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                        [[(ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) | currency: '']]
                                    </td>
                                    <td width="200px" align="right" class="cost">[[agreement.sum.total | currency: '']]</td>
                                    <td width="200px" align="right" ng-class="((ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) - agreement.sum.total) >= 0 ? 'profit' : 'cost' ">
                                        [[((ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) - agreement.sum.total) | currency: '']]
                                    </td>
                                </tr>
                                <tr ng-if="show_notifications">
                                    <td colspan="7" class="inner-table" style="background-color: #f9fbbb">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th width="200px">serial</th>
                                                <th width="200px">model</th>
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
                                                    [[notification.model]]
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
                <div ng-if="isPending" class="loading">Loading&#8230;</div>
            </div>
        </main>
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