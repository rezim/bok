<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 14:48:38
         compiled from "c:\work\bok\bok\application\views\light\clientscontroller\addedit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20479575981c654bcf4-43787216%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '735d7a7456b5eca71c76fc59c27af9a2ed680781' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\clientscontroller\\addedit.tpl',
      1 => 1413400660,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20479575981c654bcf4-43787216',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rowid' => 0,
    'dataClient' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575981c6731b33_15264581',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575981c6731b33_15264581')) {function content_575981c6731b33_15264581($_smarty_tpl) {?><table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
                          <tr>
                               <td class='tdOpis' >
                                   Nazwa krótka
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtnazwakrotka' autofocus 
                                          class='textBoxForm' maxlength="40" style='width:250px;min-width:250px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['nazwakrotka'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   Nazwa pełna
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtnazwapelna" class="textareaForm" style='height:50px;min-height: 50px;'  maxlength="200" ><?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?><?php echo $_smarty_tpl->tpl_vars['dataClient']->value[0]['nazwapelna'];?>
<?php }?></textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr>
                               <td class='tdOpis' >
                                   adres
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtulica'
                                          class='textBoxForm' maxlength="100" style='width:300px;min-width:300px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['ulica'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=2></td></tr>
                           
                             <tr>
                               <td class='tdOpis' >
                                   Miasto
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmiasto'
                                          class='textBoxForm' maxlength="70" style='width:200px;min-width:200px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['miasto'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                             <tr>
                               <td class='tdOpis' >
                                   Kod pocztowy
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtkodpocztowy'
                                          class='textBoxForm' maxlength="10" style='width:90px;min-width:90px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['kodpocztowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   NIP
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtknip'
                                          class='textBoxForm' maxlength="20" style='width:150px;min-width:150px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['nip'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                          <tr>
                               <td class='tdOpis' >
                                   telefon
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txttelefon'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['telefon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   mail
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmail'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['mail'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                             <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr>
                               <td class='tdOpis' >
                                   mail faktury
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtmailfaktury'
                                          class='textBoxForm' maxlength="50" style='width:150px;min-width:150px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['mailfaktury'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                             <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr>
                               <td class='tdOpis' >
                                   termin płatności
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtterminplatnosci' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataClient']->value[0]['terminplatnosci'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataClient']->value[0]['terminplatnosci'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                                   dni
                               </td>
                           </tr>
                           
                           
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   krótki opis
                               </td>
                               <td class='tdWartosc'>
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" ><?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['opis'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr>
                               <td class='tdOpis' >
                                   REGON
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtregon'
                                          class='textBoxForm' maxlength="20" style='width:150px;min-width:150px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataClient']->value[0]['regon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                           
                            <tr>
                                <td style='text-align: right;' colspan="2">
                                    <div class='divSave'>
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                         <div id='actionbuttonclick2' class="buttonDeclin" onmousedown='usunKlienta("<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
");return false;'>

                                            <span >X Usuń</span>
                                        </div>
                                         
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown='zapiszKlienta("<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
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
                      
                    </script>
    
</table><?php }} ?>
