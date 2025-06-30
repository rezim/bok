<div class="container-fluid agreements" ng-app="app" ng-controller="PaymentsCtrl as ctrl" ng-cloak
     ng-init="ctrl.loadData(date_from, date_to, false)">
    {include file="$templates/partials/filters/client-invoices.tpl"}

    {include file="$templates/invoice/addPayment.tpl"}
    {include file="$templates/invoice/paymentList.tpl"}
    {include file="$templates/invoice/interestNoteList.tpl"}
    {include file="$templates/invoice/paymentsClientMessages.tpl"}
    <div class="otus-table-wrapper">
        <main id='divRightCenter' class="col-12 col-xl">
            <div class="table-responsive-sm">
                <table class='table table-hover table-sm tablesorter payments' id='tablePayments'>
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
                            niezapłaconych
                            <span class="sortorder" ng-show="orderBy.propertyName === 'invoices.count.notPaid'"
                                  ng-class="(orderBy.reverse) ? 'reverse': ''"></span>
                        </th>
                        <th class="sortable">
                            noty
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
                    <tr>
                        <td colspan="2" class="text-right">suma:</td>
                        <td class="text-right"
                            ng-class="(ctrl.getTotal(search, ctrl.filters.show_paid_invoices, ctrl.filters.show_non_deptors) < 0) ? 'underpaid' : (clientInvoice.balance > 0) ? 'overpaid' : 'paid'">
                            [[ctrl.getTotal(search, ctrl.filters.show_paid_invoices, ctrl.filters.show_non_deptors) |
                            currency: '']]
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    </thead>
                    <tbody ng-repeat="clientInvoice in ctrl.getClientInvoices() | filter:search | filter: ctrl.clientInvoicesFilter() | orderBy:orderBy.propertyName:orderBy.reverse">
                    <tr ng-dblclick="ctrl.showDetails(clientInvoice);">
                        <td>
                        <span class='actionLink'
                              ng-click="ctrl.showClientCard(clientInvoice.agreementClientId)">[[clientInvoice.name]]</span>
                        </td>
                        <td><span class='actionLink'
                                  ng-click="ctrl.showClientCard(clientInvoice.agreementClientId)">[[clientInvoice.phone]]</span>
                        </td>
                        <td align="center" ng-click="ctrl.sortBy('clientInvoice.invoices.count.notPaid')" class="profit"
                            ng-class="(clientInvoice.balance < 0) ? 'underpaid' : (clientInvoice.balance > 0) ? 'overpaid' : 'paid'">
                            <span class="actionLink"
                                  ng-click="ctrl.paymentsList(clientInvoice, date_from, date_to); $event.stopPropagation();">[[clientInvoice.invoices.count.notPaid]]</span>
                        </td>
                        <td align="center" ng-click="ctrl.sortBy('clientInvoice.interestNotesLength')">
                            <span class="actionLink" ng-class="overpaid"
                                  ng-click="ctrl.interestNoteList(clientInvoice); $event.stopPropagation();">[[(clientInvoice.interestNotes.length || '-')]]</span>
                        </td>
                        <td align="right" class="profit"
                            ng-class="(clientInvoice.balance < 0) ? 'underpaid' : (clientInvoice.balance > 0) ? 'overpaid' : 'paid'">
                            <span class="actionLink"
                                  ng-click="ctrl.paymentsList(clientInvoice, date_from, date_to); $event.stopPropagation();">[[clientInvoice.balance.toFixed(2)]]</span>
                        </td>
                        <td align="right" class="profit"
                            ng-class="(clientInvoice.overpaid.sum > 0) ? 'overpaid' : 'paid'">
                            <span class="actionLink"
                                  ng-click="ctrl.paymentsList(clientInvoice, date_from, date_to); $event.stopPropagation();">[[clientInvoice.overpaid.sum.toFixed(2)]]</span>
                        </td>
                        <td class="profit">
                            <div class="dropdown show">
                                <button class="btn border border-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                    <span ng-if="clientInvoice.overpaid.sum > 0 && clientInvoice.invoices.count.notPaid > 0"
                                          class="badge badge-pill badge-danger" title="Rozksięgowanie!"><i
                                                class="fas fa-balance-scale"></i></span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a href='{$smarty.const.SCIEZKA}/clientinvoices/showclient/[[clientInvoice.nip]]'
                                       class="dropdown-item pointer"><i
                                                class="fas fa-clipboard-list"></i></i>&nbsp;rozliczenie&nbsp;winien/ma</a>
                                    <a href="javascript:void(0)" class="dropdown-item pointer"
                                       ng-click="ctrl.showDetails(clientInvoice);"><i
                                                class="fas fa-clipboard-list"></i></i>&nbsp;&nbsp;rozliczenie
                                        szczegółowe</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-click="ctrl.paymentsClientMessages(clientInvoice);$event.stopPropagation();"><i
                                                class="fas fa-comment-dots"></i>&nbsp;&nbsp;notatki</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-if="clientInvoice.overpaid.sum > 0 && clientInvoice.invoices.count.notPaid > 0"
                                       ng-click="ctrl.splitPayments(clientInvoice.clientId);$event.stopPropagation();"><i
                                                class="fas fa-balance-scale"></i>&nbsp;&nbsp;rozksięguj</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-click="ctrl.paymentsList(clientInvoice, date_from, date_to); $event.stopPropagation();"><i
                                                class="fas fa-coins"></i>&nbsp;&nbsp;płatności klienta</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-click="ctrl.interestNoteList(clientInvoice); $event.stopPropagation();"><i
                                                class="fas fa-file-invoice"></i>&nbsp;&nbsp;noty odsetkowe</a>
                                    <a href="javascript:void(0)" class="dropdown-item"
                                       ng-click="ctrl.sendPaymentReminderEmail(clientInvoice); $event.stopPropagation();"><i
                                                class="fas fa-envelope"></i>&nbsp;&nbsp;wyślij przypomnienie</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr ng-if="(ctrl.show_details[clientInvoice.nip] ) && clientInvoice.invoices.list.length">
                        <td colspan="6" class="inner-table">
                            <table class='tablesorter displaytable invoices' id='tablePayments' cellspacing=0
                                   cellpadding=0>
                                <tr>
                                    <td colspan="8">
                                        <button type="button" class="close text-danger" aria-label="Close"
                                                ng-click="ctrl.showDetails(clientInvoice);">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </td>
                                </tr>
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
                                    <th width="200px" style="text-align: right">
                                        akcja
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="invoice in clientInvoice.invoices.list | filter: ctrl.notPaidInvoicesOnlyFilter()"
                                    ng-class="(invoice.status === 'paid') ? 'paid' : (invoice.status === 'partial') ? 'partial': 'notpaid'">
                                    <td><a href="[[invoice.view_url]]" target="_blank"
                                           ng-click="$event.stopPropagation();">[[invoice.number]]</a>
                                    </td>
                                    <td>[[invoice.sell_date]]</td>
                                    <td>[[invoice.payment_to]]</td>
                                    <td align="right">[[invoice.price_net]]</td>
                                    <td align="right">[[invoice.price_gross]]</td>
                                    <td align="right">[[invoice.paid]]</td>
                                    <td align="right">[[invoice.is_late_days]]</td>
                                    <td align="right">
                                        <button ng-click="ctrl.addPayment(clientInvoice.clientId, clientInvoice.nip, invoice); $event.stopPropagation();"
                                                class="btn btn-primary ng-scope" type="button" style="font-size: 10px">
                                            zapłać
                                        </button>
                                    </td>
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
