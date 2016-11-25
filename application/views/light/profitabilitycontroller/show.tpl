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
     {*<label for="txtmiesiac" class="labelNormal">miesiąc</label>*}
     {*<select id='txtmiesiac' class="comboboxNormal" style='width:110px;min-width:110px;'>*}
                {*<option value="" selected></option>*}
                {*{foreach from=$months item=item key=key}*}
                    {*<option value="{$rok}-{$key}-01" >{$item}</option>*}
                {*{/foreach}*}
     {*</select>*}
     {*<label for="txtklient" class="labelNormal">klient</label>*}
     {*<input type="text" id='txtklient' class='textBoxNormal' style='width:90px;min-width: 90px;'>  *}
     {*<label for="txtdrukarka" class="labelNormal">drukarka</label>*}
     {*<input type="text" id='txtdrukarka' class='textBoxNormal' style='width:90px;min-width: 90px;'>*}

     <a href="#" class="buttonpokaz" ng-click='ctrl.loadData(date_from, date_to)'>Pokaż</a>
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
                {*<th width="200px" style="text-align: right">*}
                    {*ilosc km*}
                {*</th>*}
                {*<th width="200px" style="text-align: right">*}
                    {*czas pracy*}
                {*</th>*}
                {*<th width="200px" style="text-align: right">*}
                    {*wartosc materialow*}
                {*</th>*}
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

            <tr ng-repeat="profit in ctrl.getProfits() | orderBy: 'costs.nazwakrotka'">
                <td class='tdLink'>[[profit.costs.nazwakrotka]]</td>
                <td class='tdLink' align="right">[[profit.costs.wartosc_urzadzen]]</td>
                {*<td class='tdLink' align="right">[[profit.costs.ilosc_km | currency: '']]</td>*}
                {*<td class='tdLink' align="right">[[profit.costs.czas_pracy | currency: '']]</td>*}
                {*<td class='tdLink' align="right">[[profit.costs.wartosc_materialow | currency: '']]</td>*}
                <td class='tdLink' align="right">[[profit.invoice.sum | currency: '']]</td>
                <td class='tdLink' align="right">[[profit.costs.total | currency: '']]</td>
                <td class='tdLink' align="right">[[(profit.invoice.sum - profit.costs.total) | currency: '']]</td>
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