<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:12:37
         compiled from "c:\work\bok\bok\application\views\light\agreementscontroller\show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:321575924f51cd131-54685848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0e6658b6e5ff0d7c3b49fcd0142fa07bda55ba8' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\agreementscontroller\\show.tpl',
      1 => 1417467018,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '321575924f51cd131-54685848',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'czycolorbox' => 0,
    'serial' => 0,
    'clientnazwakrotka' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575924f52de365_68983731',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575924f52de365_68983731')) {function content_575924f52de365_68983731($_smarty_tpl) {?><div class='divFilter'>
     <label for="txtfilternrumowy<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal">nr umowy</label>
     <input type="text" id='txtfilternrumowy<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal'>  
     <label for="txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal">drukarka</label>
     <input type="text" id='txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal'
              <?php if (isset($_smarty_tpl->tpl_vars['serial']->value)) {?>
                value='<?php echo $_smarty_tpl->tpl_vars['serial']->value;?>
'
            <?php }?>
            
            >  
     <label for="txtfilternazwaklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
" class="labelNormal"
            
            >klient</label>
     <input type="text" id='txtfilternazwaklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
' class='textBoxNormal'   <?php if (isset($_smarty_tpl->tpl_vars['clientnazwakrotka']->value)) {?>
                value='<?php echo $_smarty_tpl->tpl_vars['clientnazwakrotka']->value;?>
'
            <?php }?>>  
     <input type="checkbox" id='checkPokazZakonczone<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
'   class='checkBoxNormal' />
                                        <label class='labelNormal' for='checkPokazZakonczone' >
                                            Zakończone
                                        </label>
     <a href="#" class="buttonpokaz" onClick="pokazUmowy('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
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
                       $('#txtfilternrumowy<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfilternrumowy<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfilterserial<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
                       $('#txtfilternazwaklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').unbind("keypress");
                       $('#txtfilternazwaklient<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazUmowy('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');return false;
                                                 }
                                             });  
    pokazUmowy('divRightCenter<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','divLoader<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['czycolorbox']->value;?>
');
</script><?php }} ?>
