<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:21:38
         compiled from "c:\work\bok\bok\application\views\light\tonerscontroller\showdane.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2740757592712562124-04888785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b8f687fdd96a1b86fea65b6686532110390decf' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\tonerscontroller\\showdane.tpl',
      1 => 1418057350,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2740757592712562124-04888785',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czyhistoria' => 0,
    'dataToners' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575927126951b6_69653434',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575927126951b6_69653434')) {function content_575927126951b6_69653434($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_replace')) include 'C:\\work\\bok\\bok\\library\\smarty\\plugins\\modifier.replace.php';
?>
<table class='tablesorter displaytable' id='tableToner' cellspacing=0 cellpadding=0>
    <thead>
        <tr>
            <th style='min-width: 115px;width:115px;'>
                serial drukarka
            </th >
            <th style='min-width: 100px;width:100px;'>
                serial
            </th>
            <th style='min-width: 50px;width:50px;'>
                typ
            </th>
            <th style='min-width: 70px;width:70px;'>
                number
            </th>
            <th style='min-width: 120px;width:120px;'>
                opis
            </th>
            <th style='min-width: 70px;width:70px;'>
                data instalacji
            </th>
            <th style='min-width: 70px;width:70px;'>
                pozostało
            </th>
            <th style='min-width: 90px;width:90px;'>
                strona max / stron pozos.
            </th>
              <th style='min-width: 70px;width:70px;'>
                ostatnie użycie
            </th>
            <?php if (isset($_smarty_tpl->tpl_vars['czyhistoria']->value)&&$_smarty_tpl->tpl_vars['czyhistoria']->value==1) {?>
                <th style='min-width: 90px;width:90px;'>
                    licznik start<br/>licznikkoniec
                </th>
            <?php }?>
         <th style='min-width: 60px;width:60px;'>
                
            </th>
        </tr>
    </thead>
    <tbody>

            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['dataToners']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                <tr>
                    <td title='<?php echo $_smarty_tpl->tpl_vars['item']->value['model'];?>
--<?php echo $_smarty_tpl->tpl_vars['item']->value['nazwakrotka'];?>
'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['serialdrukarka'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['serial'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 </td>
                    <td style='color:<?php echo $_smarty_tpl->tpl_vars['item']->value['typ'];?>
'><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['typ'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 </td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['number'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['description'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['datainstalacji'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                     <td class='tdNumber' style='padding-right:20px;'>
                        <?php echo mb_convert_encoding(htmlspecialchars(smarty_modifier_replace(number_format($_smarty_tpl->tpl_vars['item']->value['procentpozostalo'],2,","," "),',00',''), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
 %
                    </td>
                    <td class='tdNumber' style='padding-right:20px;'>
                        <?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['stronmax'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<br/><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['stronpozostalo'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                    </td>
                   
                    <td><?php echo mb_convert_encoding(htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['ostatnieuzycie'], ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
</td>
                    <?php if (isset($_smarty_tpl->tpl_vars['czyhistoria']->value)&&$_smarty_tpl->tpl_vars['czyhistoria']->value==1) {?>
                        <td class='tdNumber' style='padding-right:20px;'>
                            <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['licznikstart'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>
<br/>
                            <?php echo mb_convert_encoding(htmlspecialchars(number_format($_smarty_tpl->tpl_vars['item']->value['licznikkoniec'],0,","," "), ENT_QUOTES, 'UTF-8', true), "HTML-ENTITIES", 'UTF-8');?>

                        </td>
                    <?php }?>
                    <td style='text-align:right;'>
                        <img wymaganylevel='w' wymaganyzrobiony='0'  class='imgAkcja imgedit' onClick='showNewTonerAdd("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
","<?php echo $_smarty_tpl->tpl_vars['item']->value['typ'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Edycja" title='Edycja' />
                        <img wymaganylevel='w' wymaganyzrobiony='0'  class='imgAkcja imgusun' onClick='usunToner("<?php echo $_smarty_tpl->tpl_vars['item']->value['rowid'];?>
","<?php echo $_smarty_tpl->tpl_vars['item']->value['typ'];?>
")' src='<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/img/fake.png' alt="Usuń klienta" title='Usuń toner' />
                    </td>
                </tr>
                
            <?php } ?>
    </tbody>    
        
</table>
    <br/><br/><?php }} ?>
