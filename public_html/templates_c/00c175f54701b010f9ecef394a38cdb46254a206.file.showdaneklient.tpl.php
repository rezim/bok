<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 09:13:44
         compiled from "c:\work\bok\bok\application\views\light\reportscontroller\showdaneklient.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3233157587eb8817bd3-69284803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00c175f54701b010f9ecef394a38cdb46254a206' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\reportscontroller\\showdaneklient.tpl',
      1 => 1465463223,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3233157587eb8817bd3-69284803',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57587eb8ec84b9_88045164',
  'variables' => 
  array (
    'dataReports' => 0,
    'key' => 0,
    'item' => 0,
    'turns' => 0,
    'item2' => 0,
    'key2' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57587eb8ec84b9_88045164')) {function content_57587eb8ec84b9_88045164($_smarty_tpl) {?><table class='tablesorter displaytable' id='tableReport' cellspacing=0 cellpadding=0>
    <thead>
                      <tr>
           <th style='min-width: 50px;width:50px;'>
                                                Lp
                                            </th >
            <th style='min-width: 115px;width:115px;'>
                klient
            </th>
            <th style='min-width: 200px;width:200px;'>
                nazwa pełna
            </th>
             <th style='min-width: 55px;width:55px;'>
                umowy
            </th>
            <th style='min-width: 55px;width:55px;'>
                drukarki
            </th>
            <th style='min-width: 55px;width:55px;'>
                abonament
            </th>
             <th style='min-width: 70px;width:70px;'>
                wart. black
            </th>
              <th style='min-width: 70px;width:70px;'>
                wart. kolor
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;'>
                netto
            </th>
            <th style='min-width: 75px;width:75px;text-align: center;' onclick="invMgr.showInvoice()">
                faktura
            </th>
        </tr>
    </thead>
    <tbody>
         <?php $_smarty_tpl->tpl_vars['turns'] = new Smarty_variable(1, null, 0);?> 
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataReports']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <?php if ($_smarty_tpl->tpl_vars['key']->value!='suma'&&$_smarty_tpl->tpl_vars['key']->value!='blad') {?>
                <?php if (isset($_smarty_tpl->tpl_vars['item']->value['blad'])&&$_smarty_tpl->tpl_vars['item']->value['blad']=='1') {?>
                        <tr style='border-bottom:none;border-top:1px solid lightgrey;background-color: red;'>
                <?php } else { ?>
                        <tr style='border-bottom:none;border-top:1px solid lightgrey'>
                <?php }?>
                    <td><?php echo $_smarty_tpl->tpl_vars['turns']->value;?>
</td>
                    <td class='tdLink'  onClick='showNewClientAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nazwakrotka'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink'  onClick='showNewClientAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nazwapelna'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink' style='text-align:center;' onClick='showUmowyDoKlienta("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['drukumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink' style='text-align:center;' onClick='showDrukarkiDoKlienta("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['drukumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdNumber' style='padding-right:20px;' >
                               <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['wartoscabonament'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['wartoscabonament'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                    </td>
                    <td class='tdNumber' style='padding-right:20px;' >
                               <?php if (isset($_smarty_tpl->tpl_vars['item']->value['wartoscblack'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['wartoscblack'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                    </td>
                      <td class='tdNumber' style='padding-right:20px;' >
                               <?php if (isset($_smarty_tpl->tpl_vars['item']->value['wartosckolor'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['wartosckolor'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                    </td>
                    <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:blue;' 
                        onClick="showSzczegolyRaportRozwin('tr_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
')">
                               <?php if (isset($_smarty_tpl->tpl_vars['item']->value['wartosc'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['wartosc'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                    </td>
                    <td align="center">
                        <input type="image" src="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/add.png" onClick='invMgr.add(<?php echo json_encode($_smarty_tpl->tpl_vars['item']->value);?>
, invMgr.getSelectedAgreementIds("#tr_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
", ".to_invoice_agreement:checked"))'/>
                        <span class="invoice-count <?php echo $_smarty_tpl->tpl_vars['item']->value['nip'];?>
">0</span>
                        <span style="display: none;" class="invoice-details <?php echo $_smarty_tpl->tpl_vars['item']->value['nip'];?>
"></span>
                    </td>
                </tr>
                  <tr id='tr_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
' stan='0' style='display:none'>
                    <td colspan="9" >
                        
                        <div class="divRep">
                             <table class='tablesorter displaytable'  cellspacing=0 cellpadding=0>
                                    <thead>
                                        <tr>
                                             <th style='min-width: 50px;width:50px;'>
                                                Lp
                                            </th >
                                             <th style='min-width: 70px;width:70px;display:none;'>
                                                rowid
                                            </th>
                                            <th style='min-width: 70px;width:70px;'>
                                                nr umowy
                                            </th>
                                             <th style='min-width: 115px;width:115px;'>
                                                drukarka
                                            </th>
                                           
                                             <th style='min-width: 70px;width:70px;'>
                                                rozliczenie
                                            </th>
                                            <th style='min-width: 90px;width:90px;'>
                                                abonament
                                            </th>
                                             <th style='min-width: 55px;width:55px;'>
                                                stron black w abonam.
                                            </th>
                                            <th style='min-width: 55px;width:55px;'>
                                                cena za strone black
                                            </th>
                                              <th style='min-width: 55px;width:55px;'>
                                                stron kolor w abonam.
                                            </th>
                                            <th style='min-width: 55px;width:55px;'>
                                                cena za strone kolor
                                            </th>
                                             <th style='min-width: 70px;width:70px;'>
                                                black powyżej
                                            </th>
                                              <th style='min-width: 70px;width:70px;'>
                                                wartość black
                                            </th>
                                              <th style='min-width: 70px;width:70px;'>
                                                kolor powyżej
                                            </th>
                                            <th style='min-width: 70px;width:70px;'>
                                                wartość kolor
                                            </th>
                                             <th style='min-width: 70px;width:70px;'>
                                                opłata instalacyjna
                                            </th>
                                             <th style='min-width: 70px;width:70px'>
                                                kwota
                                            </th>
                                             <th style='min-width: 70px;width:70px'>
                                                wybierz do faktury
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php  $_smarty_tpl->tpl_vars['item2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataReports']->value[$_smarty_tpl->tpl_vars['key']->value]['umowy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopek']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item2']->key => $_smarty_tpl->tpl_vars['item2']->value) {
$_smarty_tpl->tpl_vars['item2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['item2']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopek']['index']++;
?>
                                              <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['blad'])&&$_smarty_tpl->tpl_vars['item2']->value['blad']=='1') {?>
                                                        <tr style='background-color: #FFCCCC;'>
                                                <?php } else { ?>
                                                        <tr>
                                                <?php }?>
                                                
                                                    <td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loopek']['index']+1;?>
</td>
                                                    <td class='tdWartosc'  style='display: none;'><?php echo $_smarty_tpl->tpl_vars['key2']->value;?>
</td>
                                                    <td class='tdWartosc'  onClick="showNewAgreementAdd('<?php echo $_smarty_tpl->tpl_vars['item2']->value['rowidumowa'];?>
')"><?php echo $_smarty_tpl->tpl_vars['item2']->value['nrumowy'];?>
</td>
                                                    
                                                    <td class='tdLink' style='vertical-align: top;' onClick='showNewPrinterAdd("<?php echo $_smarty_tpl->tpl_vars['item2']->value['serial'];?>
")'>
                                                        <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item2']->value['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<br/>
                                                        <font style='color:blue'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item2']->value['model'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</font>
                                                    </td>
                                                    <td class='tdWartosc'  ><?php echo $_smarty_tpl->tpl_vars['item2']->value['rozliczenie'];?>
</td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['wartoscabonament'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['wartoscabonament'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['stronwabonamencie'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['stronwabonamencie'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['cenazastrone'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['cenazastrone'],3,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['iloscstron_kolor'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['iloscstron_kolor'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['cenazastrone_kolor'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['cenazastrone_kolor'],3,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['stronblackpowyzej'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['stronblackpowyzej'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['wartoscblack'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['wartoscblack'],3,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['stronkolorpowyzej'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['stronkolorpowyzej'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['wartosckolor'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['wartosckolor'],3,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                                                     </td>
                                                       <td class='tdNumber' style='padding-right:20px;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['oplatainstalacyjna'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['oplatainstalacyjna'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                      <td class='tdNumber' style='padding-right:20px;color:blue;' >
                                                                <?php if (isset($_smarty_tpl->tpl_vars['item2']->value['wartosc'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item2']->value['wartosc'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                                                     </td>
                                                     <td>
                                                         <input type="checkbox" class="to_invoice_agreement" checked="true" value="<?php echo $_smarty_tpl->tpl_vars['item2']->value['nrumowy'];?>
" />
                                                     </td>
                                                </tr>
                                          <?php } ?>
                                    </tbody>
                            </table>
                        </div>
                        
                        
                    </td>
                    
                </tr>
                 <?php $_smarty_tpl->tpl_vars['turns'] = new Smarty_variable($_smarty_tpl->tpl_vars['turns']->value+1, null, 0);?> 
                <?php }?>
                
              
                
            <?php } ?>
                <tr >
                    <td class='tdLink'  ></td>
                    <td class='tdLink'  ></td>
                    <td class='tdLink'  ></td>
                    <td class='tdLink' style='text-align:center;' ></td>
                    <td class='tdLink' style='text-align:center;' ></td>
                    <td class='tdNumber' style='padding-right:20px;' >
                     
                    </td>
                    <td class='tdNumber' style='padding-right:20px;' >
                     
                    </td>
                      <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:brown;' >
                     Suma:
                    </td>
                    <td class='tdNumber tdLink' title='Pokaż szczegóły' style='padding-right:20px;font-weight: bold;color:brown;' >
                               <?php if (isset($_smarty_tpl->tpl_vars['dataReports']->value['suma'])) {?> <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['dataReports']->value['suma'],2,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>     
                    </td>
                </tr>
    </tbody>    
        
</table>
       <?php }} ?>
