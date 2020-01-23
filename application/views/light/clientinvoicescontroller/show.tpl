<script type="text/javascript">
    app.constant('appConf', {
        API_TOKEN: '{$smarty.const.FAKTUROWNIA_APITOKEN}',
        ENDPOINT: '{$smarty.const.FAKTUROWNIA_ENDPOINT}'
    });
</script>
<div ng-app="app" ng-controller="ClientInvoicesCtrl as ctrl" ng-cloak>

    {include file="$templates/invoice/addPayment.tpl"}
    {include file="$templates/invoice/paymentList.tpl"}

<div class='divFilter'>
    <a href="javascript:void(0)" ng-click="date_from=ctrl.getLastMonths(24); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to)" style="padding: 20px">24 miesiące</a>|
    <a href="javascript:void(0)" ng-click="date_from=ctrl.getLastMonths(12); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to)" style="padding: 20px">12 miesięcy</a>|
    <a href="javascript:void(0)" ng-click="date_from=ctrl.getLastMonths(6); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to)" style="padding: 20px">6 miesięcy</a>|
    <a href="javascript:void(0)" ng-click="date_from=ctrl.getLastMonths(3); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to)" style="padding: 20px">3 miesiące</a>
     <label for="txtdataod" class="labelNormal" >data od</label>
     <input type="text" id='txtdataod' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_from" datepicker required>
     <label for="txtdatado" class="labelNormal" >data do</label>
     <input type="text" id='txtdatado' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_to" datepicker required>
     <a href="#" class="buttonpokaz" ng-click='ctrl.loadData(date_from, date_to, show_inactive)'>Pokaż</a>
</div>

<div class="divFilter" ng-if="ctrl.getClientInvoices().length">
    <label class="labelNormal" style="padding-right: 30px">
        pokaż opłacone
        <input type="checkbox" ng-model="ctrl.filters.show_paid_invoices"/></label>
    <label class="labelNormal" style="padding-right: 30px">
        pokaż klientów bez zadłużenia
        <input type="checkbox" ng-model="ctrl.filters.show_non_deptors"/></label>
    <label class="labelNormal" style="padding-right: 30px" ng-if="!ctrl.show_devices_view">
        klient <input type="text" class='textBoxNormal' ng-model="search.name">
    </label>
    <label class="labelNormal" style="padding-right: 30px" ng-if="ctrl.show_devices_view">
        model <input type="text" class='textBoxNormal' ng-model="ctrl.device.agreementPrinterModel">
    </label>
</div>
<div>
    <div>
        <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0 width="100%" style="padding-bottom: 30px">
            <thead>
            <tr>
                <th width="20%" ng-click="sortBy('name')" class="sortable">
                    nazwa
                    <span class="sortorder" ng-show="orderBy.propertyName === 'name'" ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                </th>
                <th width="20%" style="text-align: right" ng-click="sortBy('invoices.count.notPaid')" class="sortable">
                    ilość faktur niezapłaconych
                    <span class="sortorder" ng-show="orderBy.propertyName === 'invoices.count.notPaid'" ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                </th>
                <th width="20%" style="text-align: right" ng-click="sortBy('invoices.sum.notPaid')" class="sortable">
                    suma faktur niezapłaconych
                    <span class="sortorder" ng-show="orderBy.propertyName === 'invoices.sum.notPaid'" ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                </th>
                <th width="20%" style="text-align: right" ng-click="sortBy('overpaid.sum')" class="sortable">
                    nadpłata
                    <span class="sortorder" ng-show="orderBy.propertyName === 'overpaid.sum'" ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                </th>
                <th width="20%" style="text-align: right">
                    akcja
                </th>
            </tr>
            </thead>
            <tbody ng-repeat="clientInvoice in ctrl.getClientInvoices() | filter:search | filter: deptorsOnly(ctrl.filters.show_paid_invoices) | orderBy:orderBy.propertyName:orderBy.reverse"
                   ng-click="ctrl.showDetails(clientInvoice)"
                   ng-if="(clientInvoice.invoices.sum.notPaid > 0 || ctrl.filters.show_non_deptors) && clientInvoice.invoices.count.all > 0">

                <tr ng-if="!ctrl.filters.show_paid_invoices">
                    <td class='tdLink'">[[clientInvoice.name]]</td>
                    <td align="center" class="profit">[[clientInvoice.invoices.count.notPaid]]</td>
                    <td align="right" class="profit">[[clientInvoice.invoices.sum.notPaid.toFixed(2)]]</td>
                    <td align="right" class="profit">[[clientInvoice.overpaid.sum.toFixed(2)]]</td>
                    <td align="right" class="profit"></td>
                </tr>
                <tr ng-if="ctrl.filters.show_paid_invoices">
                    <td class='tdLink' ng-click="ctrl.sortBy('name')">[[clientInvoice.name]]</td>
                    <td align="center" ng-click="ctrl.sortBy('clientInvoice.invoices.count.notPaid')" class="profit">[[clientInvoice.invoices.count.notPaid]] / [[clientInvoice.invoices.count.all]]</td>
                    <td align="right" ng-click="ctrl.sortBy('clientInvoice.invoices.sum.notPaid')" class="profit" ng-if="ctrl.filters.show_paid_invoices">
                        [[clientInvoice.invoices.sum.notPaid.toFixed(2)]]zł / [[clientInvoice.invoices.sum.all.toFixed(2)]] zł
                    </td>
                    <td align="right" class="profit">[[clientInvoice.overpaid.sum.toFixed(2)]]</td>
                    <td align="right" class="profit"></td>
                </tr>

                <tr ng-if="(ctrl.show_details[clientInvoice.nip] ) && clientInvoice.invoices.list.length">
                    <td colspan="5" class="inner-table">
                        <table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
                            <thead>
                            <tr>
                                <th width="200px">
                                    numer faktury
                                </th>
                                <th width="200px">
                                    data wystawienia
                                </th>
                                <th width="200px">
                                    termin płatności
                                </th>
                                <th width="200px" style="text-align: right">
                                    netto
                                </th>
                                <th width="200px" style="text-align: right">
                                    brutto
                                </th>
                                <th width="200px" style="text-align: right">
                                    zapłacono
                                </th>
                                <th width="200px" style="text-align: right">
                                    opóźnienie dni
                                </th>
                                <th width="100px" style="text-align: right">
                                    akcja
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="invoice in clientInvoice.invoices.list | filter: notPaidInvoicesOnly(ctrl.filters.show_paid_invoices)">
                                    <td><a href="[[invoice.view_url]]" target="_blank" ng-click="$event.stopPropagation();">[[invoice.number]]</a></td>
                                    <td>[[invoice.sell_date]]</td>
                                    <td>[[invoice.payment_to]]</td>
                                    <td align="right">[[invoice.price_net]]</td>
                                    <td align="right">[[invoice.price_gross]]</td>
                                    <td align="right">[[invoice.paid]]</td>
                                    <td align="right">[[invoice.is_late_days]]</td>
                                    <td align="right">
                                        <button ng-click="ctrl.addPayment(clientInvoice.clientId, clientInvoice.nip, invoice); $event.stopPropagation();" class="btn btn-primary ng-scope" type="button" style="font-size: 10px">płatność</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" align="right">
                                        <a href="javascript:void(0)" ng-click="ctrl.paymentsList(clientInvoice, date_from, date_to); $event.stopPropagation();">zarządzaj płatnościami</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div ng-if="isPending" class="loading">Loading&#8230;</div>

</div>