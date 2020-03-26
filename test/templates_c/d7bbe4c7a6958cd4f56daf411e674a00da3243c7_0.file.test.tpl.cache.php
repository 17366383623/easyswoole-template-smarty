<?php
/* Smarty version 3.1.34-dev-7, created on 2020-03-26 16:20:43
  from '/Users/yehua/Desktop/easyswoole/easyswoole-template-smarty/test/views/index/test.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e7c65db5c0616_27739412',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd7bbe4c7a6958cd4f56daf411e674a00da3243c7' => 
    array (
      0 => '/Users/yehua/Desktop/easyswoole/easyswoole-template-smarty/test/views/index/test.tpl',
      1 => 1585210743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e7c65db5c0616_27739412 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '17681432795e7c65db56bd21_64805628';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test-blade</title>
</head>
<body>
    i'm render by  <?php ob_start();
echo $_smarty_tpl->tpl_vars['engine']->value;
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>

    <?php ob_start();
echo $_smarty_tpl->tpl_vars['test']->value;
$_prefixVariable2 = ob_get_clean();
echo $_prefixVariable2;?>

</body>
</html><?php }
}
