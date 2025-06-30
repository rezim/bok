<script type="text/javascript">
    app.constant('appConf', {
        API_TOKEN: '{$smarty.const.FAKTUROWNIA_APITOKEN}',
        ENDPOINT: '{$smarty.const.FAKTUROWNIA_ENDPOINT}'
    });
</script>
<div class="container-fluid" ng-app="app" ng-controller="ProfitabilityCtrl as ctrl" ng-cloak>

    {include file="$templates/partials/filters/profitability.tpl"}

    <div class="otus-table-wrapper">
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
                        <td align="right" class="profit">
                            <b>[[(profits | sumOfValue:'invoice':'sum') | currency: '']]</b></td>
                        <td align="right" class="cost"><b>[[(profits | sumOfValue:'sum':'total') | currency: '']]</b>
                        </td>
                        <td align="right"
                            ng-class="((profits | sumOfDifferences:'invoice':'sum':'sum':'total') >=0) ? 'profit' : 'cost'">
                            <b>[[(profits | sumOfDifferences:'invoice':'sum':'sum':'total') | currency: '']]</b></td>
                    </tr>
                    <tr ng-if="ctrl.show_devices_view">
                        {*<td colspan="5">[[ctrl.getAgreements(ctrl.device)]]</td>*}
                        <td align="right"><b>suma:</b></td>
                        <td align="right">
                            <b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'agreementValueUnit') | currency: '']]</b>
                        </td>
                        <td align="right" class="profit">
                            <b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'netPrice') | currency: '']]</b></td>
                        <td align="right" class="cost">
                            <b>[[(ctrl.getAgreements(ctrl.device) | sumOfValue:'sum':'total') | currency: '']]</b></td>
                        <td align="right"
                            ng-class="((ctrl.getAgreements(ctrl.device) | sumOfDifferences:'netPrice':'':'sum':'total') >=0) ? 'profit' : 'cost'">
                            <b>[[(ctrl.getAgreements(ctrl.device) | sumOfDifferences:'netPrice':'':'sum':'total') | currency: '']]</b>
                        </td>
                    </tr>
                    </thead>
                    <tbody ng-repeat="profit in profits = (ctrl.getProfits() | filter:search | showProfits: ctrl.showLossOnly | showWithCosts: ctrl.showWithCost | orderBy: 'name')">

                    <tr ng-if="!ctrl.show_devices_view"
                        ng-click="ctrl.show_details[profit.nip]= !ctrl.show_details[profit.nip]">
                        <td class='tdLink'>[[profit.name]]</td>
                        <td align="right">[[profit.sum.wartoscUrzadzen | currency: '']]</td>
                        <td align="right" class="profit">[[profit.invoice.sum | currency: '']]</td>
                        <td align="right" class="cost">[[profit.sum.total | currency: '']]</td>
                        <td align="right" ng-class="((profit.invoice.sum - profit.sum.total) >= 0) ? 'profit' : 'cost'">
                            [[(profit.invoice.sum - profit.sum.total) | currency: '']]
                        </td>
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
                                <tbody ng-repeat="agreement in profit.agreements | filter: ctrl.device"
                                       ng-class="(agreement.agreementIsActive) ? '' : 'inactive-agreement'">
                                <tr ng-if="$index == 0 && ctrl.show_devices_view">
                                    <td colspan="7">[[profit.name]]</td>
                                </tr>
                                <tr ng-click="show_notifications=!show_notifications">
                                    <td width="200px" align="left">[[agreement.agreementRowId]]</td>
                                    <td width="200px" align="left">[[(agreement.agreementIsActive) ? 'tak' : 'nie']]
                                    </td>
                                    <td width="200px" align="left">[[agreement.agreementPrinterModel]]</td>
                                    <td width="200px" align="right">[[agreement.agreementValueUnit | currency: '']]</td>
                                    <td width="200px" align="right" class="profit">
                                        <i ng-if="ctrl.getInvoiceDetails(profit.invoice.list, profit.nip).isPending"
                                           class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                                        [[(ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) | currency: '']]
                                    </td>
                                    <td width="200px" align="right" class="cost">
                                        [[agreement.sum.total | currency: '']]
                                    </td>
                                    <td width="200px" align="right"
                                        ng-class="((ctrl.getInvoiceDetails(profit.invoice.list, profit.nip)[agreement.agreementRowId].netPrice) - agreement.sum.total) >= 0 ? 'profit' : 'cost' ">
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
                                                    <i colorbox html="[[ctrl.getNotificationTemplate(notification)]]"
                                                       class="fa fa-envelope" aria-hidden="true"></i>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </
                        >
                    </tr>
                    </tbody>
                </table>
                <div ng-if="isPending" class="loading">Loading&#8230;</div>
            </div>
        </main>

    </div>
</div>
<!-- this should be replaced by angular based solution -->
<script type="text/javascript">
    $("#txtdataod").datepicker
    ($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $("#txtdatado").datepicker($.datepicker.regional['pl'], {
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        showOtherMonths: true,
        selectOtherMonths: true
    });
</script>