<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 06:44:27
         compiled from "c:\work\bok\bok\application\views\light\tonerscontroller\addedit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:50975759104b8a87b0-13715958%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b66072d675e0ca8f4ff4e01d9ce603729542d7b' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\tonerscontroller\\addedit.tpl',
      1 => 1418234356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '50975759104b8a87b0-13715958',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'dataPrinters' => 0,
    'item' => 0,
    'rowid' => 0,
    'dataToner' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5759104baffaf6_31096808',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5759104baffaf6_31096808')) {function content_5759104baffaf6_31096808($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.replace.php';
?>
<table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
    
                            <tr>
                               <td class='tdOpis' >
                                  Drukarka
                               </td>
                               <td class='tdWartosc'>
                                    <select id='txtdrukarka' class="comboboxForm" style='width:300px;min-width:300px;'>
                                        <option value="" selected></option>
                                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataPrinters']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataToner']->value[0]['serialdrukarka']==$_smarty_tpl->tpl_vars['item']->value['serial']) {?>selected<?php }?>>
                                            <?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
---<?php echo $_smarty_tpl->tpl_vars['item']->value['model'];?>
---<?php echo $_smarty_tpl->tpl_vars['item']->value['nazwaklient'];?>

                                        </option>
                                        <?php } ?>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
    
    
                          <tr>
                               <td class='tdOpis' >
                                   Serial
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtserial'
                                          class='textBoxForm' maxlength="50" style='width:120px;min-width:120px;' 
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataToner']->value[0]['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                        
                           <tr>
                               <td class='tdOpis' >
                                  Typ
                               </td>
                               <td class='tdWartosc'>
                                    <select id='txttyp' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        
                                        <option value="black" <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataToner']->value[0]['typ']=='black') {?>selected<?php }?>>
                                            black
                                        </option>
                                        <option value="cyan" <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataToner']->value[0]['typ']=='cyan') {?>selected<?php }?>>
                                            cyan
                                        </option>
                                        <option value="magenta" <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataToner']->value[0]['typ']=='magenta') {?>selected<?php }?>>
                                            magenta
                                        </option>
                                        <option value="yellow" <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataToner']->value[0]['typ']=='yellow') {?>selected<?php }?>>
                                            yellow
                                        </option>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Number
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtnumber'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataToner']->value[0]['number'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Opis
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtopis'
                                          class='textBoxForm' maxlength="100" style='width:250px;min-width:250px;' 
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataToner']->value[0]['description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Data instalacji
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtdatainstalacji'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataToner']->value[0]['datainstalacji'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Stron max.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstronmax'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataToner']->value[0]['stronmax'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Stron pozostało
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstronpozostalo'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataToner']->value[0]['stronpozostalo'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Ostatnie użycie
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtostatnieuzycie'
                                          class='textBoxForm' maxlength="100" style='width:100px;min-width:100px;' 
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataToner']->value[0]['ostatnieuzycie'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Licznik start
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtlicznikstart'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataToner']->value[0]['licznikstart'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Licznik koniec
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtlicznikkoniec'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataToner']->value[0]['licznikkoniec'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataToner']->value[0]['licznikkoniec'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                            <tr>
                                <td style='text-align: right;' colspan="2">
                                    <div class='divSave'>
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" 
                                                 <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>onmousedown='zapiszToner("<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
");return false;'
                                                 <?php } else { ?>onmousedown='zapiszToner("0");return false;'
                                                 <?php }?>
                                                 >
                                            <span >Zapisz >></span>
                                        </div>
                                        <div id='actionloader' class="actionloader">
                                            <img src="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                </td>
                            </tr>
                        </table>
                    <script type="text/javascript">     
                           $( "#txtdatainstalacji" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" });
                           $( "#txtostatnieuzycie" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" });
                    </script>
    
</table><?php }} ?>
