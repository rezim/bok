<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 15:55:59
         compiled from "c:\work\bok\bok\application\views\light\agreementscontroller\addedit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:239305759918fa3db13-02882417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c4437e872b2c468cb0aa36ae5095ec11b35bd864' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\agreementscontroller\\addedit.tpl',
      1 => 1464952800,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '239305759918fa3db13-02882417',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rowid' => 0,
    'dataUmowa' => 0,
    'dataClients' => 0,
    'key' => 0,
    'item' => 0,
    'dataPrinters' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5759919016b0e5_92925088',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5759919016b0e5_92925088')) {function content_5759919016b0e5_92925088($_smarty_tpl) {?><table id='tableform' class='tableform' cellspacing=0 cellpadding=0>
                          <tr>
                               <td class='tdOpis' style="width:170px;min-width:170px;max-width:170px;" >
                                   Nr umowy
                               </td>
                               <td class='tdWartosc' colspan="3">
                                   <input type="text" id='txtnrumowy' autofocus 
                                          class='textBoxForm' maxlength="40" style='width:130px;min-width:130px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['nrumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr>
                               <td class='tdOpis' >
                                   Klient
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                    <select id='txtklient' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataClients']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rowidclient']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['nazwakrotka'];?>
</option>
                                        <?php } ?>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                            <tr>
                               <td class='tdOpis' >
                                   Drukarka
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                  
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
" <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataUmowa']->value[0]['serial']==$_smarty_tpl->tpl_vars['item']->value['serial']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
 - <?php echo $_smarty_tpl->tpl_vars['item']->value['model'];?>
</option>
                                        <?php } ?>
                                    </select>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id='trtxtrozliczenie'>
                               <td class='tdOpis' >
                                   Rozliczenie
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                    <select id='txtrozliczenie' class="comboboxForm" style='width:200px;min-width:200px;'>
                                        <option value="" selected></option>
                                        <option value="miesięczne" <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rozliczenie']=='miesięczne') {?>selected<?php }?>>miesięczne</option>
                                        <option value="roczne" <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&$_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rozliczenie']=='roczne') {?>selected<?php }?>>roczne</option>
                                    </select> 
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                             <tr id="trtxtabonament">
                               <td class='tdOpis' >
                                   abonament
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtabonament' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['abonament'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtdataod">
                               <td class='tdOpis' >
                                   Data od
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtdataod' 
                                          class='textBoxForm' maxlength="10" style='width:100px;min-width:100px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['dataod'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                                          <font style='font-size: 12px;color:gray'>(rok-miesiąc-dzień )np.2007-07-23</font>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtdataod">
                               <td class='tdOpis' >
                                   Data do
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <input type="text" id='txtdatado' 
                                          class='textBoxForm' maxlength="10" style='width:100px;min-width:100px;' 
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['datado'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               <font style='font-size: 12px;color:gray'>(rok-miesiąc-dzień )np.2007-07-23</font>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                        
                           <tr id="trtxtiloscstron">
                               <td class='tdOpis' >
                                   stron black w abonam.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstron' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['stronwabonamencie'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                               
                                <td class='tdOpis' >
                                   cena instalacji
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenainstalacji' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['cenainstalacji'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['cenainstalacji'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                               
                               
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtcenazastrone">
                               <td class='tdOpis' >
                                   cena za stronę black
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenazastrone' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['cenazastrone'],3,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>
                               </td>
                                <td class='tdOpis' >
                                   prowizja partn.[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtprowizjapartnerska' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['prowizjapartnerska'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['prowizjapartnerska'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                          
                           
                           
                            <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           <tr id="trtxtiloscstron_kolor">
                               <td class='tdOpis' >
                                   stron kolor w abonam.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtiloscstron_kolor' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['iloscstron_color'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['iloscstron_color'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                                 <td class='tdOpis' >
                                   SLA [ h ]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtsla' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['sla'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['sla'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           <tr id="trtxtcenazastrone_kolor">
                               <td class='tdOpis' >
                                   cena za stronę kolor
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtcenazastrone_kolor' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['cenazastrone_kolor'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['cenazastrone_kolor'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                                <td class='tdOpis' >
                                   wartość urządz.
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtwartoscurzadzenia' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['wartoscurzadzenia'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['wartoscurzadzenia'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                             <tr id="trtxtrabatdoabonamentu">
                               <td class='tdOpis' >
                                   rabat do abonamentu[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtrabatdoabonamentu' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rabatdoabonamentu'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rabatdoabonamentu'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                               
                                <td class='tdOpis' >
                                   wszystko jak czarne
                               </td>
                               <td class='tdWartosc'>
                                     <input type="checkbox" id='checkJakCzarne' class='checkBoxNormal' 
                                            <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['jakczarne'])&&$_smarty_tpl->tpl_vars['dataUmowa']->value[0]['jakczarne']==1) {?>checked<?php }?>
                                            />
                                        
                                  
                               </td>
                               
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                            <tr id="trtxtrabatdowydrukow">
                               <td class='tdOpis' >
                                   rabat do wydruków[%]
                               </td>
                               <td class='tdWartosc'>
                                   <input type="text" id='txtrabatdowydrukow' 
                                          class='textBoxForm' maxlength="10" style='width:70px;min-width:70px;text-align: right;padding-right: 10px;'
                                          <?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0&&!empty($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rabatdowydrukow'])) {?>value="<?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['rabatdowydrukow'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
"<?php }?>>  
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                           
                           
                           
                            <tr>
                               <td class='tdOpis' style='height:50px;min-height: 50px;max-height: 50px;'>
                                   krótki opis
                               </td>
                               <td class='tdWartosc'  colspan="3">
                                   <textarea id="txtopis" class="textareaForm" style='height:80px;min-height: 80px;'  
                                             maxlength="500" ><?php if ($_smarty_tpl->tpl_vars['rowid']->value!=0) {?><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['dataUmowa']->value[0]['opis'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></textarea>
                               </td>
                           </tr>
                           <tr><td style='height:3px;min-height: 3px;' colspan=2></td></tr>
                
                           
                           
                           
                            <tr>
                                <td style='text-align: right;' colspan="4">
                                    <div class='divSave' id="divSaveUmowa">
                                        <div id='actionerror' class='actionerror'><span>Błąd zapisu danych.</span></div>
                                        <div id='actionok' class='actionok' ><span style='margin-top:6px;'>Dane zapisane poprawnie</span></div>
                                           <div id='actionbuttonclick2' class="buttonDeclin" onmousedown='usunUmowe("<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
");return false;'>

                                            <span >X Zamknij</span>
                                        </div>
                                            <div id='actionbuttonclick' class="actionbuttonZapisz" onmousedown='zapiszUmowe("<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
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
                            <tr>
                                <td style='text-align: center;' colspan="4">    
                                    
                                      <?php if (isset($_smarty_tpl->tpl_vars['rowid']->value)&&$_smarty_tpl->tpl_vars['rowid']->value!=0) {?>
                                            <div class="dropzone" id="divdropzone3">

                                            </div>
                                           <script type="text/javascript">
                                               createDropZone('div#divdropzone3','<?php echo $_smarty_tpl->tpl_vars['rowid']->value;?>
','agreements','<?php echo @constant('ADRESHTTPS');?>
/public_html','<?php echo @constant('SCIEZKA');?>
');
                                           </script>     
                                     <?php }?>
                                </td>
                            </tr>
                        </table>
                    <script type="text/javascript">
                                          $( "#txtdataod" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd" , changeMonth: true,
                        changeYear: true,});
                                            $( "#txtdatado" ).datepicker($.datepicker.regional['pl'],{ dateFormat: "yy-mm-dd", changeMonth: true,
                        changeYear: true, });
                    </script>
    
</table>
<?php }} ?>
