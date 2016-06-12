<?php /* Smarty version Smarty-3.1.16, created on 2016-06-08 20:23:00
         compiled from "c:\work\bok\bok\application\views\light\reportscontroller\show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1132457587ea41fcf56-05956661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b2a16f03ae201058cdbf5258667b8737fbc180a' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\reportscontroller\\show.tpl',
      1 => 1464943188,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1132457587ea41fcf56-05956661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'months' => 0,
    'rok' => 0,
    'key' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57587ea4343d31_81580517',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57587ea4343d31_81580517')) {function content_57587ea4343d31_81580517($_smarty_tpl) {?><?php  $_config = new Smarty_Internal_Config(((string)$_smarty_tpl->tpl_vars['fakturownia_conf_file_path']->value), $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
<script type="text/javascript">
    // initialize invoice manager
    var invMgr = new InvoiceManager('<?php echo $_smarty_tpl->getConfigVariable('api_token');?>
', '<?php echo $_smarty_tpl->getConfigVariable('endpoint');?>
', '<?php echo $_smarty_tpl->getConfigVariable('company_name');?>
');
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
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['months']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['rok']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
-01" ><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                <?php } ?>
     </select>
     <label for="txtklient" class="labelNormal">klient</label>
     <input type="text" id='txtklient' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     <label for="txtdrukarka" class="labelNormal">drukarka</label>
     <input type="text" id='txtdrukarka' class='textBoxNormal' style='width:90px;min-width: 90px;'>  
     
     
     <a href="#" class="buttonpokaz" onClick='generujRaport(function(data, params){invMgr.refreshInvoices(params);});return false;'>Generuj</a>
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class='divRightCenter' id='divRightCenter'>
    
</div>
<script type="text/javascript">
                       $('#txtklient').unbind("keypress");
                       $('#txtklient').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    generujRaport();return false;
                                                 }
                                             });  
                       $('#txtdrukarka').unbind("keypress");
                       $('#txtdrukarka').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    generujRaport();return false;
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
                                                    generujRaport();return false;
                                                 }
                                             });  
                       $('#txtdatado').unbind("keypress");
                       $('#txtdatado').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    generujRaport();return false;
                                                 }
                                             });  
                       $('#txtmiesiac').unbind("keypress");
                       $('#txtmiesiac').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    generujRaport();return false;
                                                 }
                                             });  
    
</script><?php }} ?>
