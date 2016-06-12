<?php /* Smarty version Smarty-3.1.16, created on 2016-06-08 21:35:37
         compiled from "c:\work\bok\bok\application\views\light\agreementscontroller\showdane.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2052057588fa9dc4905-49911721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14b3488f79a941e953af00be93af254cb9e4f07f' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\agreementscontroller\\showdane.tpl',
      1 => 1464952709,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2052057588fa9dc4905-49911721',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czycolorbox' => 0,
    'dataAgreements' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57588faa0e3869_48088456',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57588faa0e3869_48088456')) {function content_57588faa0e3869_48088456($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_modifier_replace')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.replace.php';
?>
<table class='tablesorter displaytable' id='tableUmowy' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
             <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 115px;width:115px;'>
                nr umowy
            </th >
             <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>  
            <th style='min-width: 155px;width:155px;'>
                klient
            </th>
            <th style='min-width: 115px;width:115px;'>
                drukarka
            </th>
            <?php }?>
            <th wymaganylevel='w' wymaganyzrobiony='0' style='min-width: 75px;width:75px;'>
                data od
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 75px;width:75px;'>
                data do
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                stron <br/> abonam.
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                cena <br/> strona
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                rozliczenie
            </th>
            <th wymaganylevel='w' wymaganyzrobiony='0'  style='min-width: 65px;width:65px;text-align: center;'>
                abonament
            </th>
             <th style='min-width: 30px;width:30px;text-align: center;' titla="1-tak; 0-nie">
                aktywna
            </th>
            <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>  
            <th style='min-width: 75px;width:75px;'>
            </th>
            <?php }?>
        </tr>
    </thead>
    <tbody>

            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataAgreements']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                            $('#idumowaspan').html('<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
');
                            $('#rowid_agreements').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['nrumowy'];?>
');
                            $('#sla').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['sla'];?>
');
                            $.colorbox.close();
                        "
                    <?php }?>
                    >
                      <td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loopek']['index']+1;?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nrumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                     <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>  
                    <td class='tdLink' onClick='showNewClientAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowidclient'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nazwakrotka'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink' onClick='showNewPrinterAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <?php }?>
                    <td wymaganylevel='w' wymaganyzrobiony='0' ><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['dataod'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0' 
                         <?php if ((smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['datado'],"%Y-%m"))==(smarty_modifier_date_format(time(),"%Y-%m"))) {?>style='background-color:red'<?php }?>
                        >
                        <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['datado'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'><?php echo smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['stronwabonamencie'],2,","," "),',00','');?>

                    </td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'><?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['cenazastrone'],3,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                    </td>    
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['rozliczenie'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td wymaganylevel='w' wymaganyzrobiony='0'  class='tdNumber'><?php if (!empty($_smarty_tpl->tpl_vars['item']->value['abonament'])) {?><?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['abonament'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<?php }?>
                    </td>  
                    <td class='tdNumber'><?php echo $_smarty_tpl->tpl_vars['item']->value['activity'];?>
</td>
                    <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>  
                    <td style='text-align: right;'>
                         
                        <img wymaganylevel='r' wymaganyzrobiony='0' class='imgAkcja imgedit' onClick='showNewAgreementAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Edycja" title='Edycja' />
                        <?php if (!empty($_smarty_tpl->tpl_vars['item']->value['serial'])) {?>
                            <?php if (empty($_smarty_tpl->tpl_vars['item']->value['blad'])) {?>
                            <img class='imgAkcja imgNormalLogs' onClick='pokazLogi("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />    
                            <?php } else { ?>
                            <img class='imgAkcja imgIstniejeLogs' onClick='pokazLogi("<?php echo $_smarty_tpl->tpl_vars['item']->value['serial'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Usuń klienta" title='Pokaż logi' />        
                            <?php }?>
                        <?php }?>
                        
                    </td>
                    <?php }?>
                </tr>
            <?php } ?>


    </tbody>    
        
</table>
       <?php }} ?>
