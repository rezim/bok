<?php /* Smarty version Smarty-3.1.16, created on 2016-06-09 13:03:32
         compiled from "c:\work\bok\bok\application\views\light\aclscontroller\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1766575969247d6dd9-70772954%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7bcb8556d28aa911227ba9175cd08b901ff405ac' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\aclscontroller\\login.tpl',
      1 => 1418110596,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1766575969247d6dd9-70772954',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575969249d3c45_49799014',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575969249d3c45_49799014')) {function content_575969249d3c45_49799014($_smarty_tpl) {?>
<div id='acl_OkienkoContainer' >
  <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'
       style='position:relative;margin-left: 0px;'
       ></img>
  <span class='acl_spanInfoPowitanie'>Istniejemy dzięki naszym klientom</span>
<div class="acl_divOkienko" >
                    <table id='acl_tableForm' class='acl_tableform' cellspacing=0 cellpadding=0 >
                           <tr>
                               <td  >
                                   login
                               </td>
                               <td >
                                   <input type="text" id='txtlogin' autofocus 
                                          class='acl_textBoxFormNormal' style='width:220px;' maxlength="70" >  
                               </td>
                           </tr>
                           <tr>
                               <td style='height:5px;min-height: 5px;' colspan=3>
                                   
                               </td>
                              
                           </tr>
                            <tr>
                               <td  >
                                   hasło
                               </td>
                               <td  style='width:160px;'>
                                   <input type="password" id='txtPass1' class='acl_textBoxFormNormal' style='width:220px;' >  
                               </td>
                           </tr>
                           <tr><td style='height:5px;min-height: 5px;' colspan=3></td></tr>
                          
                           <tr>
                               <td style='height:5px;min-height: 5px;' colspan=3>
                                   
                               </td>
                              
                           </tr>
                            
                           <tr><td style='height:5px;min-height: 5px;' colspan=3></td></tr>
                          
                           <tr>
                               <td style='height:5px;min-height: 5px;' colspan=3>
                                   
                               </td>
                              
                           </tr>
                            <tr>
                                <td style='text-align: right;' colspan="3">
                                    <div >
                                        <div id='actionerror' class='acl_actionerror' style='height:80px;min-height: 80px;max-height: 80px;'><span>Błąd logowania.</span></div>
                                        <div id='actionok' class='acl_actionok' ><span style='margin-top:6px;'>Logowanie przebiegło pomyślnie.</span></div>
                                        <a id='actionbuttonclick' href="#" class="acl_buttonAkcept" style='width:150px;' title='Zaloguj się' 
                                           onmousedown="acl_logowanie('<?php echo @constant('SCIEZKA');?>
','<?php echo @constant('SCIEZKA');?>
');return false;">zaloguj się >></a>
                                        
                                        <div id='actionloader' class="acl_actionloader">
                                            <img src="/<?php echo @constant('SMARTVERSION');?>
/img/smallLoader.GIF" style='display:inline;'/>przetwarzanie
                                        </div>
                                        <div style='clear:both'></div>
                                    </div> 
                                </td>
                            </tr>
                               <tr>
                               <td style='height:30px;min-height: 30px;' colspan=3>
                               </td>
                              
                           </tr>
                            
                        </table>
</div>  
</div>
                                        <script type="text/javascript">
                     
                            
                        $('#txtlogin').unbind("keypress");
                        $('#txtlogin').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                   acl_logowanie('<?php echo @constant('SCIEZKA');?>
','<?php echo @constant('SCIEZKA');?>
');return false;
                                                 }
                                             });  
                       $('#txtPass1').unbind("keypress");
                       $('#txtPass1').keypress(function(event) {
                                                 if (event.keyCode == 13) {
                                                    acl_logowanie('<?php echo @constant('SCIEZKA');?>
','<?php echo @constant('SCIEZKA');?>
');return false;
                                                 }
                                             }); 
                 </script>
<?php }} ?>
