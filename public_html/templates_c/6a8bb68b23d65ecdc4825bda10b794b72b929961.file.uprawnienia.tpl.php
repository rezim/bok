<?php /* Smarty version Smarty-3.1.16, created on 2016-06-12 08:55:29
         compiled from "c:\work\private\bok\application\views\light\share\uprawnienia.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16619575d23819785d3-65571667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a8bb68b23d65ecdc4825bda10b794b72b929961' => 
    array (
      0 => 'c:\\work\\private\\bok\\application\\views\\light\\share\\uprawnienia.tpl',
      1 => 1464699666,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16619575d23819785d3-65571667',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_575d23819f1997_43922365',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_575d23819f1997_43922365')) {function content_575d23819f1997_43922365($_smarty_tpl) {?>



<?php if (isset($_SESSION['shares'])) {?>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_SESSION['shares']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>             
    <?php if (isset($_SESSION['przypisaneshares'][$_smarty_tpl->tpl_vars['key']->value])) {?>
        
        <?php if ($_SESSION['przypisaneshares'][$_smarty_tpl->tpl_vars['key']->value]['permission']=='r') {?>
            <script type="text/javascript">
                
                    if ( $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').is( "a" ) )
                    {
                      
                          $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                          $('#tr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                    }
                    else if ( $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').is( "img" ) )
                    {
                         $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                         $('#tr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                    }
                     else if ( $('<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').is( "div" ) )
                    {
                         $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                        $('#tr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
                    }
                    else
                    {
                      
                        $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').prop('disabled', true);
                    }
            </script>
        <?php }?>
    <?php } else { ?>
        <script type="text/javascript">
            $('#<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
            $('#tr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
').css('display','none');
        </script>
    <?php }?>
    
    
    
<?php } ?>
<?php }?>
<?php }} ?>
