<div class="container-fluid" ng-app="app" ng-controller="PaymentsCtrl as ctrl" ng-cloak
     ng-init="ctrl.loadData(date_from, date_to, true)">

    <div class="row">
        <div class="otus-sidebar col-12 col-md-12 col-xl-auto">
            <form>
                <div class="form-group">
                    <label for="txtfilterserial">okres (miesięcy)</label>
                </div>
                <div class="form-group">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group"
                             aria-describedby="dateRangeHelp">
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from=ctrl.getLastMonths(24); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true)">
                                24
                            </button>
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from=ctrl.getLastMonths(12); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true)">
                                12
                            </button>
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from=ctrl.getLastMonths(6); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true)">
                                &nbsp;6
                            </button>
                            <button type="button" class="btn btn-outline-secondary form-control"
                                    ng-click="date_from=ctrl.getLastMonths(3); date_to=ctrl.getToday();ctrl.loadData(date_from, date_to, true)">
                                &nbsp;3
                            </button>
                        </div>
                    </div>
                    <small id="dateRangeHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                        okres w miesiącach.</small>
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

                <div class="w-100"></div>

                <div class="form-group">
                    <label for="txtklient">klient</label>
                </div>

                <div class="form-group">
                    <input type="text" id="txtklient" class="form-control"
                           aria-describedby="clientHelp" ng-model="search.name">
                    <small id="clientHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj nazwę
                        klienta</small>
                </div>

                <div class="form-group">
                    <label for="txtclientnip">nip</label>
                </div>
                <div class="form-group">
                    <input type="text" id="txtclientnip" class="form-control"
                           aria-describedby="clienNiptHelp" ng-model="search.nip">
                    <small id="clienNiptHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj NIP
                        klienta</small>
                </div>

                <div class="form-group">
                    <label for="txtInvoiceNb">numer FV</label>
                </div>
                <div class="form-group">
                    <input type="text" id="txtInvoiceNb" class="form-control"
                           aria-describedby="txtInvoiceNbHelp" ng-model="ctrl.filters.invoiceNb">
                    <small id="txtInvoiceNbHelp" class="form-text text-muted"><i class="fas fa-info-circle"></i> Podaj
                        numer Faktury VAT</small>
                </div>

                <div class="w-100"></div>

                <div class="border-top my-4 otus-separator"></div>

                <div class="form-group">
                    <button class="btn btn-info btn-block" type="submit"
                            ng-click='ctrl.loadData(date_from, date_to, true)'>
                        Pokaż
                    </button>
                </div>

            </form>
        </div>

        {include file="$templates/invoice/paymentsClientMessages.tpl"}

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