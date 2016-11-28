{config_load file="$fakturownia_conf_file_path"}
<script type="text/javascript">
    // initialize invoice manager
    var invMgr = new InvoiceManager('{#api_token#}', '{#endpoint#}', '{#company_name#}', '{#invoice_number_length#}');
</script>
<div ng-app="app" ng-controller="ProfitabilityCtrl as ctrl">
<div class='divFilter'>

     <label for="txtdataod" class="labelNormal" >data od</label>
     <input type="text" id='txtdataod' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_from">
     <label for="txtdatado" class="labelNormal" >data do</label>
     <input type="text" id='txtdatado' class='textBoxNormal' style='width:90px;min-width: 90px;' ng-model="date_to">
     <a href="#" class="buttonpokaz" ng-click='ctrl.loadData(date_from, date_to)'>Pokaż</a>
</div>
<div class="divFilter" ng-if="ctrl.getProfits().length">
    <label class="labelNormal">
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
                    wartość faktur
                </th>
                <th width="200px" style="text-align: right">
                    suma kosztów
                </th>
                <th width="200px" style="text-align: right">
                    dochód
                </th>
            </tr>
            </thead>
            <tbody ng-repeat="profit in ctrl.getProfits() | filter:search | orderBy: 'name'">

                <tr ng-click="ctrl.getInvoiceDetails(profit.invoice.list, profit.nip); show_row=!show_row">
                    <td class='tdLink'>[[profit.name]]</td>
                    <td align="right">[[profit.sum.wartoscUrzadzen | currency: '']]</td>
                    <td align="right" class="profit">[[profit.invoice.sum | currency: '']]</td>
                    <td align="right" class="cost">[[profit.sum.total | currency: '']]</td>
                    <td align="right" ng-class="((profit.invoice.sum - profit.sum.total) >= 0) ? 'profit' : 'cost'">[[(profit.invoice.sum - profit.sum.total) | currency: '']]</td>
                </tr>
                <tr ng-if="show_row">
                    <td colspan="5">

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
                                wartość faktur
                            </th>
                            <th width="200px" style="text-align: right">
                                suma kosztów
                            </th>
                            <th width="200px" style="text-align: right">
                                dochód
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="agreement in profit.agreements" ng-class="(agreement.agreementIsActive) ? '' : 'inactive-agreement'">
                            <td align="left">[[agreement.agreementRowId]]</td>
                            <td align="left">[[(agreement.agreementIsActive) ? 'tak' : 'nie']]</td>
                            <td align="right">[[agreement.agreementValueUnit | currency: '']]</td>
                            <td align="right">-</td>
                            <td align="right">[[agreement.sum.total | currency: '']]</td>
                            <td align="right">-</td>
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