<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 15:55:51
         compiled from "c:\work\bok\bok\application\views\light\printerscontroller\show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:144557599187ddf9c5-56963831%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e86eb12c97cd5e2e7bb447d2de51568d6ea9b18' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\printerscontroller\\show.tpl',
      1 => 1417467018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144557599187ddf9c5-56963831',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czycolorbox' => 0,
    'clientnazwakrotka' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57599187edc5d7_16906829',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57599187edc5d7_16906829')) {function content_57599187edc5d7_16906829($_smarty_tpl) {?><div class='divFilter'>
     <label for="txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal">serial</label>
     <input type="text" id='txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
     <label for="txtfiltermodel<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal">model</label>
     <input type="text" id='txtfiltermodel<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
     <label for="txtfilterklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal">klient</label>
     <input type="text" id='txtfilterklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal' style='width:100px;min-width: 100px;'
            <?php if (isset($_smarty_tpl->tpl_vars['clientnazwakrotka']->value)) {?>
                value='<?php echo $_smarty_tpl->tpl_vars['clientnazwakrotka']->value;?>
'
            <?php }?>
            >  
     
     
     
     <a href="#" class="buttonpokaz" onClick="pokazDrukarki('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;">Filtruj</a>
</div>
<div class='divLoader' id='divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
'>
</div>
<div class='divRightCenter' id='divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
'>
    
</div>
<script type="text/javascript">
                       $('#txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfiltermodel<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfiltermodel<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfilterklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfilterklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazDrukarki('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                    
    pokazDrukarki('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');
</script><?php }} ?>
