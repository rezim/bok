<?php /* Smarty version Smarty-3.1.16, created on 2016-06-08 20:34:25
         compiled from "c:\work\bok\bok\application\views\light\share\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1182357587ea3a34256-31857117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f3b187703f2d6c0beb2a8b6538b17398fd2a341' => 
    array (
      0 => 'c:\\work\\bok\\bok\\application\\views\\light\\share\\header.tpl',
      1 => 1465417974,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1182357587ea3a34256-31857117',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_57587ea4040639_60716230',
  'variables' => 
  array (
    'title' => 0,
    'keywords' => 0,
    'description' => 0,
    'uprawnienia' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57587ea4040639_60716230')) {function content_57587ea4040639_60716230($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php if (!isset($_smarty_tpl->tpl_vars['title']->value)||$_smarty_tpl->tpl_vars['title']->value=='') {?><?php echo @constant('TITLE');?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
<?php }?></title>
    <meta name="keywords" content="<?php if (!isset($_smarty_tpl->tpl_vars['keywords']->value)||$_smarty_tpl->tpl_vars['keywords']->value=='') {?><?php echo @constant('KEYWORDS');?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
<?php }?>">
    <meta name='description' content="<?php if (!isset($_smarty_tpl->tpl_vars['description']->value)||$_smarty_tpl->tpl_vars['description']->value=='') {?><?php echo @constant('DESCRIPTION');?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
<?php }?>"/>
    
    
    
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/style.css" title="default" />
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/menu.css" title="default" />
         <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/acl.css" title="default" />   
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/colorbox.css" title="default" />
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/jquery-ui-1.10.4.custom.min.css" title="default" />
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/jquery-ui-timepicker-addon.css" title="default" />
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/sort.css" title="default" />
        <link rel="stylesheet" type="text/css" href="<?php echo @constant('SCIEZKA');?>
/<?php echo @constant('SMARTVERSION');?>
/css/dropzone.css" title="default" />
    <script type="text/javascript">
        function loadScript(src, callback) 
            {
                    var head = document.getElementsByTagName('head')[0],
                        script = document.createElement('script');
                    done = false;
                    script.setAttribute('src', src);
                    script.setAttribute('type', 'text/javascript');
                    script.setAttribute('charset', 'utf-8');
                    script.onload = script.onreadstatechange = function() {
                        if (!done && (!this.readyState || this.readyState === 'loaded' || this.readyState === 'complete')) {
                            done = true;
                            script.onload = script.onreadystatechange = null;
                                if (callback) {
                                    callback();
                                }
                            }
                    }
                    head.insertBefore(script, head.firstChild);
            }
            
     </script>
     <script type="text/javascript">
        var sciezka = "<?php echo @constant('SCIEZKA');?>
";
        <?php if (isset($_smarty_tpl->tpl_vars['uprawnienia']->value)) {?>
            var val2 = '<?php echo $_smarty_tpl->tpl_vars['uprawnienia']->value;?>
';
         <?php }?>
     </script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/js.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/acl.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/jquery.tablesorter.min.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/dropzone.js"></script>
        <script type="text/javascript" src="<?php echo @constant('SCIEZKA');?>
/js/invoices.js"></script>
</head>
 <<?php ?>?php flush(); ?<?php ?>>
<body>
<div id='divContainer' >
     
    <?php if (isset($_SESSION['login'])&&$_SESSION['login']==1) {?>
        <img src='http://www.otus.pl/templates/otus/images/obraz/logo.png' alt='Otus' title='Otus' border='0' height='82' width='150'
       style='position:absolute;left:40px;'
       ></img>
    <div id='divHeader' >
         <?php if (isset($_SESSION['przypisanemenu']['but_addclient'])) {?>
                <a id='but_addclient' href="#" onclick='showNewClientAdd("0");return false;' class="butaddclient" >Nowy klient</a>
        <?php }?>
        <?php if (isset($_SESSION['przypisanemenu']['but_addprinter'])) {?>
        <a id='but_addprinter' href="#" onclick='showNewPrinterAdd("");return false;'  class="butaddprinter">Nowa drukarka</a>
        <?php }?>
        <?php if (isset($_SESSION['przypisanemenu']['but_addagreement'])) {?>
        <a id='but_addagreement' href="#" onclick='showNewAgreementAdd("0");return false;' class="butaddumowa">Nowa umowa</a>
        <?php }?>
        <?php if (isset($_SESSION['przypisanemenu']['but_addtoner'])) {?>
        <a id='but_addtoner' href="#" onclick='showNewTonerAdd("0","");return false;' class="butaddtoner">Nowy toner</a>
        <?php }?>
         <?php if (isset($_SESSION['przypisanemenu']['but_addcase'])) {?>
        <a id='but_addcase' href="javascript:void(0);" onclick='showNewNotiAdd("0");return false;' class="butaddcase">Nowe zgłoszenie</a>
        <?php }?>
        
    </div>
    <div class='liniaRozdzielajaca'></div>
    <div id='leftMenu'>
        
        <div id='cssmenu'>
                <ul>
                   <li><a href='<?php echo @constant('SCIEZKA');?>
/acls/logout/notemplate'><span>Wyloguj</span></a></li>
                     <?php if (isset($_SESSION['przypisanemenu']['li_printersshow'])) {?>
                   <li id='li_printersshow'><a href='<?php echo @constant('SCIEZKA');?>
/printers/show'><span>Drukarki</span></a></li>
                   <?php }?>
                   <?php if (isset($_SESSION['przypisanemenu']['li_clientsshow'])) {?>
                   <li id='li_clientsshow'><a href='<?php echo @constant('SCIEZKA');?>
/clients/show' ><span>Klienci</span></a></li>
                   <?php }?>
                   <?php if (isset($_SESSION['przypisanemenu']['li_agreementsshow'])) {?>
                   <li id='li_agreementsshow'><a href='<?php echo @constant('SCIEZKA');?>
/agreements/show'><span>Umowy</span></a></li>
                   <?php }?>
                   <?php if (isset($_SESSION['przypisanemenu']['li_tonersshow'])) {?>
                   <li id='li_tonersshow'><a href='<?php echo @constant('SCIEZKA');?>
/toners/show'><span>Tonery</span></a></li>
                   <?php }?>
                   <?php if (isset($_SESSION['przypisanemenu']['li_reportsshow'])) {?>
                   <li id='li_reportsshow'><a href='<?php echo @constant('SCIEZKA');?>
/reports/show' ><span>Raporty</span></a></li>
                   <?php }?>
                   
                   <?php if (isset($_SESSION['przypisanemenu']['li_passwordshow'])) {?>
                   <li id='li_passwordshow' class='last'><a href='<?php echo @constant('SCIEZKA');?>
/acls/passshow' ><span>Hasło</span></a></li>
                   <?php }?>
                  
                     <?php if (isset($_SESSION['przypisanemenu']['li_casesshow'])) {?>
                   <li id='li_caseshow' class='last'><a href='<?php echo @constant('SCIEZKA');?>
/notifications/show' ><span>Zgłoszenia</span></a></li>
                   <?php }?>
                 
                 
                </ul>
         </div>
   
        
    </div><?php }?> 
    <div id='rightCenter'>
   <?php }} ?>
