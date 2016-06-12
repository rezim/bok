<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 08:21:37
         compiled from "c:\work\bok\bok\application\views\light\tonerscontroller\show.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1923657592711383702-61087251%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0579955330f3019ad133d13576662643cff1616c' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\tonerscontroller\\show.tpl',
      1 => 1418240468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1923657592711383702-61087251',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575927113db2a3_51409161',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575927113db2a3_51409161')) {function content_575927113db2a3_51409161($_smarty_tpl) {?><div class='divFilter'>
    <label for="txtfilterdrukarka" class="labelNormal">serial drukarka</label>
     <input type="text" id='txtfilterdrukarka' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
     <label for="txtfilterserial" class="labelNormal">serial toner</label>
     <input type="text" id='txtfilterserial' class='textBoxNormal' style='width:100px;min-width: 100px;'>  
          
            <input name='txttonerzakonczone' type="checkbox" id='txttonerzakonczone'   class='checkBoxNormal' />
            <label  class='labelNormal' for='txttonerzakonczone' >
                  Zakończone
            </label>
          
     
     
     
     <a href="#" class="buttonpokaz" onClick='pokazTonery();return false;'>Filtruj</a>
</div>
<div class='divLoader' id='divLoader'>
</div>
<div class='divRightCenter' id='divRightCenter'>
    
</div>
<script type="text/javascript">
                       $('#txtfilterserial').unbind("keypress");
                       $('#txtfilterserial').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    pokazTonery();return false;
                                                 }
                                             });  
                       
    pokazTonery();
</script><?php }} ?>
