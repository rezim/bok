<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:12:31
         compiled from "c:\work\bok\bok\application\views\light\clientscontroller\showdane.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3618575924ef3ce836-72304058%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd0367515edec23876c53b68da36c7babfd667af9' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\clientscontroller\\showdane.tpl',
      1 => 1419057232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3618575924ef3ce836-72304058',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czycolorbox' => 0,
    'dataClient' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575924ef4d4f81_28863555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575924ef4d4f81_28863555')) {function content_575924ef4d4f81_28863555($_smarty_tpl) {?>
<table class='tablesorter displaytable' id='tableClient' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
              <th style='min-width: 50px;width:50px;'>
                Lp
            </th >
            <th style='min-width: 165px;width:165px;'>
                nazwa krótka
            </th >
            <th style='min-width: 155px;width:155px;'>
                kod/miasto
            </th>
            <th style='min-width: 155px;width:155px;'>
                adres
            </th>
            <th style='min-width: 105px;width:105px;'>
                nip
            </th>
            <th style='min-width: 95px;width:195px;'>
                telefon
            </th>
            <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>
            <th style='min-width: 55px;width:55px;'>
                umowy
            </th>
            <th style='min-width: 55px;width:55px;'>
                drukarki
            </th>
            <th style='min-width: 75px;width:75px;'>
            </th>
            <?php }?>
        </tr>
    </thead>
    <tbody>

            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataClient']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                            $('#idclientspan').html('<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
');
                            $('#rowid_client').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['nazwakrotka'];?>
');
                            if($('#email').val()=='')
                            {
                                $('#email').val('<?php echo $_smarty_tpl->tpl_vars['item']->value['mail'];?>
');
                            }
                            $.colorbox.close();
                        "
                    <?php }?>
                    >
                      <td><?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['loopek']['index']+1;?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nazwakrotka'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['kodpocztowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['miasto'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ulica'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['nip'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['telefon'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['czycolorbox']->value=='') {?>    
                    <td class='tdLink' style='text-align:center;' onClick='showUmowyDoKlienta("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['drukumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td class='tdLink' style='text-align:center;' onClick='showDrukarkiDoKlienta("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
")'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['drukumowy'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td style='text-align:right;'>
                
                        <img wymaganylevel='w' wymaganyzrobiony='0' class='imgAkcja imgedit' onClick='showNewClientAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Edycja" title='Edycja' />
                        
                        
                    </td>
                    <?php }?>
                </tr>
            <?php } ?>


    </tbody>    
        
</table>
           <?php }} ?>
