{config_load file="$fakturownia_conf_file_path"}
<script type="text/javascript">
    // initialize invoice manager
    var invMgr = new InvoiceManager('{#api_token#}', '{#endpoint#}', '{#company_name#}', '{#invoice_number_length#}');
</script>
<div class='divFilter'>
     <label for="txtdataod" class="labelNormal" >data od</label>
     <input type="text" id='txtdataod' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     <label for="txtdatado" class="labelNormal" >data do</label>
     <input type="text" id='txtdatado' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     <label for="txtmiesiac" class="labelNormal">miesiąc</label>
     <select id='txtmiesiac' class="comboboxNormal" style='width:110px;min-width:110px;' 
             onchange="changeMiesiac(this);">
                <option value="" selected></option>
                {foreach from=$months item=item key=key}
                    <option value="{$rok}-{$key}-01" >{$item}</option>
                {/foreach}
     </select>
     <label for="txtklient" class="labelNormal">klient</label>
     <input type="text" id='txtklient' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     <label for="txtdrukarka" class="labelNormal">drukarka</label>
     <input type="text" id='txtdrukarka' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     
     
     <a href="#" class="buttonpokaz" onClick='generateProfitsReport(function(data, params){literal}{invMgr.refreshInvoices(params);invMgr.showAgreementWarnings(params);}{/literal});return false;'>Pokaż</a>
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class='divRightCenter' id='divRightCenter'>
    
</div>
<script type="text/javascript">
                       $('#txtklient').unbind("keypress");
                       $('#txtklient').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     generateProfitsReport();return false;
                                                 }
                                             });  
                       $('#txtdrukarka').unbind("keypress");
                       $('#txtdrukarka').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     generateProfitsReport();return false;
                                                 }
                                             });  
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
                    setDateDefault();
                       $('#txtdataod').unbind("keypress");
                       $('#txtdataod').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     generateProfitsReport();return false;
                                                 }
                                             });  
                       $('#txtdatado').unbind("keypress");
                       $('#txtdatado').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     generateProfitsReport();return false;
                                                 }
                                             });  
                       $('#txtmiesiac').unbind("keypress");
                       $('#txtmiesiac').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                     generateProfitsReport();return false;
                                                 }
                                             });  
    
</script>