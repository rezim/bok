<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 06:59:34
         compiled from "c:\work\bok\bok\application\views\light\printerscontroller\showdane.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10350575913d69e4950-66353575%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e45882b41a4fe35c2fd6fa7eeee28b880acb2a9a' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\printerscontroller\\showdane.tpl',
      1 => 1419057286,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10350575913d69e4950-66353575',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czycolorbox' => 0,
    'dataPrinters' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575913d6c34843_11843377',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575913d6c34843_11843377')) {function content_575913d6c34843_11843377($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.replace.php';
if (!is_callable('smarty_modifier_date_format')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.date_format.php';
?>
<table class='tablesorter displaytable' id='tablePrinter' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
             <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 115px;width:115px;'>
                serial
            </th >
            <th style='min-width: 195px;width:195px;'>
                model
            </th>
          
            <th style='min-width: 85px;width:85px;'>
                nr firmware
            </th>
           
            <th style='min-width: 55px;width:55px;'>
                toner
            </th>
            <!-- <th style='min-width: 70px;width:70px;'>
                fuser
            </th>-->
            <th style='min-width: 85px;width:85px;text-align: center;'>
                black
            </th>
            <th style='min-width: 85px;width:85px;text-align: center;'>
                color
            </th>
             <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>    
            <th style='min-width: 85px;width:85px;'>
                nr umowy
            </th>
              <th style='min-width: 85px;width:85px;'>
                klient
            </th>
            <?php }?>
            <th style='min-width: 85px;width:85px;'>
                data mail
            </th>
            <th style='min-width: 110px;width:110px;'>
                
            </th>
        </tr>
    </thead>
    <tbody>

            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataPrinters']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopek']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['loopek']['index']++;
?>
                <tr
                     <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='1') {?>
                        style='cursor:hand;cursor:pointer;'
                          onClick="
                            $('#idserialspan').html('<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
');
                            $('#serial').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
');
                            
                            $('#rowid_client').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['nazwaklient'];?>
');
                            $('#idclientspan').html('<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
');
                            
                            $('#rowid_agreements').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['nrumowy'];?>
');
                            $('#idumowaspan').html('<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidumowa'];?>
');
                            
                            $('#sla').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['sla'];?>
');
                            
                            $.colorbox.close();
                        "
                    <?php }?>
                    >
                    <td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loopek']['index']+1;?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['model'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 </td>
                    
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nr_firmware'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                   
                    <td >
                        <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['black_toner'])) {?>
                            <?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['black_toner'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 %
                        <?php }?>
                        
                            <img class='imgColor' onClick='showTonersInfo("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
");' 
                                 src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' />
                        
                    </td>
                    <!-- <td class='tdNumber'>
                        <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['stan_fuser'])) {?>
                            <?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['stan_fuser'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 %
                        <?php }?>
                     </td>-->
                    <td class='tdNumber' style='padding-right:20px;'><?php if ($_smarty_tpl->tpl_vars['item']->value['iloscstron']==0) {?>0<?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['iloscstron'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></td>
                    <td class='tdNumber' style='padding-right:20px;'><?php if ($_smarty_tpl->tpl_vars['item']->value['iloscstron_kolor']=='') {?><?php } else { ?><?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['iloscstron_kolor'],0,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?></td>
                     <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>    
                    <td class='tdLink' onClick='showNewAgreementAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidumowa'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nrumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink' <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['nazwaklient'])) {?>onClick='showNewClientAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'<?php }?>><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nazwaklient'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <?php }?>
                    <td 
                        <?php if ((!empty($_smarty_tpl->tpl_vars['item']->value['datawiadomosci'])&&(smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['datawiadomosci'],"%Y-%m-%d"))<(smarty_modifier_date_format(time(),"%Y-%m-%d")))) {?>style='background-color:red'<?php }?>
                    >
                        <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['datawiadomosci'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                    </td>
                    
                    <td style='text-align:right;'>
                         <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>    
                        <img wymaganylevel='r' wymaganyzrobiony='0'  class='imgAkcja imgedit' onClick='showNewPrinterAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Edycja" title='Edycja' />
                        <?php if (empty($_smarty_tpl->tpl_vars['item']->value['blad'])) {?>
                        <img  class='imgAkcja imgNormalLogs' onClick='pokazLogi("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />    
                        <?php } else { ?>
                        <img  class='imgAkcja imgIstniejeLogs' onClick='pokazLogi("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />        
                        <?php }?>
                        <img wymaganylevel='w' wymaganyzrobiony='0' class='imgAkcja imgtonery' onClick='historiaTonerow("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Pokaż historię tonerów" title='Pokaż historię tonerów' />
                        <?php }?>
                    </td>
                </tr>
                
                <tr id='tonertr<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
' style='display:none;' vis='0'>
                    <td colspan=12 id='tonertd<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
'>
                        
                    </td>
                </tr>    
                
            <?php } ?>


    </tbody>    
        
</table><?php }} ?>
