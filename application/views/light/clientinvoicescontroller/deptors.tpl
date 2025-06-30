<div class="container-fluid" ng-app="app" ng-controller="PaymentsCtrl as ctrl" ng-cloak
     ng-init="ctrl.loadData(date_from, date_to, true, null, true)">
    {include file="$templates/partials/filters/deptors.tpl"}

    {include file="$templates/invoice/paymentsClientMessages.tpl"}
    <div class="otus-table-wrapper">
        <main id='divRightCenter' class="col-12 col-md-12 col-xl">
            <div class="table-responsive-sm">
                <table class='table table-hover table-sm tablesorter payments' id='tableDeptors'>
                    <thead class="thead-dark">
                    <tr>
                        <th ng-click="sortBy('name')" class="sortable">
                            client
                            <span class="sortorder" ng-show="orderBy.propertyName === 'name'"
                                  ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                        </th>
                        <th>telefon</th>
                        <th ng-click="sortBy('invoices.count.notPaid')"
                            class="sortable">
                            faktur niezapłaconych
                            <span class="sortorder" ng-show="orderBy.propertyName === 'invoices.count.notPaid'"
                                  ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                        </th>
                        <th ng-click="sortBy('balance')" class="sortable text-right">
                            saldo
                            <span class="sortorder" ng-show="orderBy.propertyName === 'balance'"
                                  ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                        </th>
                        <th class="sortable text-right">
                            nadpłata
                        </th>
                        <th>
                            akcja
                        </th>
                    </tr>
                    </thead>
                    <!-- TODO: monitoring platnosci should be filtered on server side, see: filter: ctrl.paymentMonitoringFilter() -->
                    <!-- filter: ctrl.paymentMonitoringFilter() | -->
                    <tbody ng-repeat="clientInvoice in ctrl.getClientInvoices() | filter:search | filter: ctrl.clientInvoicesFilter() | orderBy:orderBy.propertyName:orderBy.reverse">

                    <tr>
                        <td class='tdLink' ng-click="ctrl.sortBy('name')">[[clientInvoice.name]]</td>
                        <td>[[clientInvoice.phone]]</td>
                        <td align="center" ng-click="ctrl.sortBy('clientInvoice.invoices.count.notPaid')" class="profit"
                            ng-class="(clientInvoice.balance < 0) ? 'underpaid' : (clientInvoice.balance > 0) ? 'overpaid' : 'paid'">
                            [[clientInvoice.invoices.count.notPaid]]
                        </td>
                        <td align="right" class="profit"
                            ng-class="(clientInvoice.balance < 0) ? 'underpaid' : (clientInvoice.balance > 0) ? 'overpaid' : 'paid'">
                            [[clientInvoice.balance.toFixed(2)]]
                        </td>
                        <td align="right" class="profit"
                            ng-class="(clientInvoice.overpaid.sum > 0) ? 'overpaid' : 'paid'">
                            [[clientInvoice.overpaid.sum.toFixed(2)]]
                        </td>
                        <td class="profit">


                            <div class="dropdown show">
                                <button class="btn border border-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a href='{$smarty.const.SCIEZKA}/clientinvoices/showclient/[[clientInvoice.nip]]'
                                       class="dropdown-item pointer"><i
                                                class="fas fa-clipboard-list"></i></i>&nbsp;rozliczenie&nbsp;winien/ma</a>
                                    <a href="#" class="dropdown-item pointer"
                                       ng-click="ctrl.showDetails(clientInvoice);"><i class="fas fa-file-invoice"></i>&nbsp;&nbsp;faktury</a>
                                    <a href="#" class="dropdown-item"
                                       ng-click="ctrl.paymentsClientMessages(clientInvoice);$event.stopPropagation();"><i
                                                class="fas fa-comment-dots"></i>&nbsp;&nbsp;notatki</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-click="ctrl.sendPaymentReminderEmail(clientInvoice); $event.stopPropagation();"><i
                                                class="fas fa-envelope"></i>&nbsp;&nbsp;wyślij przypomnienie</a></div>
                            </div>
                        </td>
                    </tr>

                    <tr ng-if="(ctrl.show_details[clientInvoice.nip] ) && clientInvoice.invoices.list.length">
                        <td colspan="6" class="inner-table">
                            <table class='tablesorter displaytable invoices' id='tableReport'>
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
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="invoice in clientInvoice.invoices.list | filter: ctrl.notPaidInvoicesOnlyFilter()"
                                    ng-class="(invoice.status === 'paid') ? 'paid' : (invoice.status === 'partial') ? 'partial': 'notpaid'">
                                    <td><span>[[invoice.number]]</span>
                                    </td>
                                    <td>[[invoice.sell_date]]</td>
                                    <td>[[invoice.payment_to]]</td>
                                    <td align="right">[[invoice.price_net]]</td>
                                    <td align="right">[[invoice.price_gross]]</td>
                                    <td align="right">[[invoice.paid]]</td>
                                    <td align="right">[[invoice.is_late_days]]</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>

                <div ng-if="isPending" class="loading">Loading&#8230;</div>
            </div>
        </main>
    </div>
</div>