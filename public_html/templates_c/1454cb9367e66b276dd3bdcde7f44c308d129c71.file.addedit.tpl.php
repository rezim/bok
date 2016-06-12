<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:12:24
         compiled from "c:\work\bok\bok\application\views\light\printerscontroller\addedit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24491575924e810e8a5-45064792%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1454cb9367e66b276dd3bdcde7f44c308d129c71' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\printerscontroller\\addedit.tpl',
      1 => 1418234356,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24491575924e810e8a5-45064792',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'serial' => 0,
    'dataPrinter' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575924e83072c6_75602597',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575924e83072c6_75602597')) {function content_575924e83072c6_75602597($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.replace.php';
?><table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
                          <tr>
                               <td class='tdOpis' >
                                   Serial
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtserial' autofocus 
                                          class='textBoxForm' maxlength="50" style='width:120px;min-width:120px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                             <tr> 
                               <td class='tdOpis' >
                                   Model
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmodel'
                                          class='textBoxForm' maxlength="100" style='width:200px;min-width:200px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['model'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Product number
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtproduct_number'
                                          class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['product_number'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Nr firmware
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtnr_firmware'
                                          class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['nr_firmware'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Data firmware
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtdate_firmware'
                                          class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['date_firmware'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Ip
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtip'
                                          class='textBoxForm' maxlength="100" style='width:120px;min-width:120px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['ip'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           <tr> 
                               <td class='tdOpis' >
                                   Stan fuser
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstan_fuser'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!=''&&!empty($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['stan_fuser'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['stan_fuser'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  %
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                             <tr> 
                               <td class='tdOpis' >
                                   Stan ADF
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtstan_adf'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!=''&&!empty($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['stan_adf'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['stan_adf'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  %
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                             <tr> 
                               <td class='tdOpis' >
                                   Toner czarny
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtblack_toner'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['black_toner'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  %
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                           
                            <tr> 
                               <td class='tdOpis' >
                                   Ilość stron black
                               </td>
                               <td class='tdWartosc' colspan="3">
                                   <input type="text" id='txtiloscstron'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['iloscstron'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                                   <font style='font-size: 12px;color:black'>Stan na</font> 
                                   <input type="text" id='txtstanna' class='textBoxForm' maxlength="10" style='width:100px;min-width:100px;' >
                                      <font  style='font-size: 12px;color:gray;cursor:hand;cursor:pointer;' onClick="zapiszStanNa('<?php echo $_smarty_tpl->tpl_vars['serial']->value;?>
');">zapisz</font>
                                         
                               </td>
                           </tr>
                              <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           <tr> 
                               <td class='tdOpis' >
                                   Ilość stron kolor
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstronkolor'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['iloscstron_kolor'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                              <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           <tr> 
                               <td class='tdOpis' >
                                   Ilość stron total
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstrontotal'
                                          class='textBoxForm' maxlength="100" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?>value="<?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['iloscstron_total'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>> 
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                            <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   Krótki opis
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" ><?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['opis'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                          <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   Lokalizacja
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtlokalizacja" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" ><?php if ($_smarty_tpl->tpl_vars['serial']->value!='') {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataPrinter']->value[0]['lokalizacja'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                           
                            <tr>
                                <td style='text-align: right;' colspan="2">
                                     
                                    <div class='divSave' wymaganylevel='w' wymaganyzrobiony='0' >
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                        <div id='actionbuttonclick2' class="buttonDeclin" onmousedown='usunDrukarke("<?php echo $_smarty_tpl->tpl_vars['serial']->value;?>
");return false;'>

                                            <span >X Usuń</span>
                                        </div>
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown='zapiszDrukarke("<?php echo $_smarty_tpl->tpl_vars['serial']->value;?>
");return false;'>
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
                         
                        $( "#txtstanna" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,
                        changeYear: true,});
                                            
                    </script>
    
</table><?php }} ?>
