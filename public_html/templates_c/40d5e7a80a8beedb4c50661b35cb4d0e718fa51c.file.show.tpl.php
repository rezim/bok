<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:12:30
         compiled from "c:\work\bok\bok\application\views\light\clientscontroller\show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1544575924ee1d5f10-54985966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40d5e7a80a8beedb4c50661b35cb4d0e718fa51c' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\clientscontroller\\show.tpl',
      1 => 1418056130,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1544575924ee1d5f10-54985966',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'serial' => 0,
    'czycolorbox' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575924ee278267_60894464',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575924ee278267_60894464')) {function content_575924ee278267_60894464($_smarty_tpl) {?><div class='divFilter'>
     <label for="txtfilternazwa" class="labelNormal">nazwa</label>
     <input type="text" id='txtfilternazwa' class='textBoxNormal'>  
     <label for="txtfiltermiasto" class="labelNormal">miasto</label>
     <input type="text" id='txtfiltermiasto' class='textBoxNormal'>  
     <label for="txtfilternip" class="labelNormal">nip</label>
     <input type="text" id='txtfilternip' class='textBoxNormal'>  
      <label for="txtfilterserial" class="labelNormal">serial</label>
     <input type="text" id='txtfilterserial' class='textBoxNormal'
              <?php if (isset($_smarty_tpl->tpl_vars['serial']->value)) {?>
                value='<?php echo $_smarty_tpl->tpl_vars['serial']->value;?>
'
            <?php }?>
            >  
    
     <a href="#" class="buttonpokaz" onClick="pokazKlientow('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
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
                       $('#txtfilternazwa').unbind("keypress");
                       $('#txtfilternazwa').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfilternip').unbind("keypress");
                       $('#txtfilternip').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfiltermiasto').unbind("keypress");
                       $('#txtfiltermiasto').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazKlientow('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
    pokazKlientow('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');
</script><?php }} ?>
