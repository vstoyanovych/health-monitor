<?php /* Smarty version 2.6.26, created on 2024-09-15 05:36:41
         compiled from account_adminpart.tpl */ ?>
<?php if ($this->_tpl_vars['_settings']['allow_forgot_password'] == '1'): ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'getpasswd'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<form action="index.php" method="get">
<input type="hidden" name="m" value="account">
<input type="hidden" name="d" value="getpasswd2">
<tr>
    <td><?php echo $this->_tpl_vars['lang']['login_str']; ?>
</td>
    <td><input type="text" name="login"></td>
</tr>
<tr>
    <td colspan="2" align="center"><input type="submit" value="<?php echo $this->_tpl_vars['lang']['get_password']; ?>
"></td>
</tr>
</form>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'getpasswd2'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['secret_question']; ?>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<form action="index.php?m=account&d=getpasswd3&login=<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['userdata_login']; ?>
" method="post">
<tr>
    <td><?php echo $this->_tpl_vars['lang']['secret_answer_question']; ?>
</td>
    <td><input type="text" name="p_answ"></td>
</tr>
<tr>
    <td><?php echo $this->_tpl_vars['lang']['new_password']; ?>
</td>
    <td><input type="text" name="p_newpwd"></td>
</tr>
<tr>
    <td colspan="2" align="center"><input type="submit" value="<?php echo $this->_tpl_vars['lang']['set_password']; ?>
"></td>
</tr>
</form>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'viewprivmsg'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<a href="index.php?m=account&d=sendprivmsg"><?php echo $this->_tpl_vars['lang']['module_account']['send_message']; ?>
</a> :: <?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['privmsg_folder'] == 'inbox'): ?><b><?php endif; ?><a href="index.php?m=account&d=viewprivmsg&folder=inbox"><?php echo $this->_tpl_vars['lang']['module_account']['inbox']; ?>
</a><?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['privmsg_folder'] == 'inbox'): ?></b><?php endif; ?> :: <?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['privmsg_folder'] == 'outbox'): ?><b><?php endif; ?><a href="index.php?m=account&d=viewprivmsg&folder=outbox"><?php echo $this->_tpl_vars['lang']['module_account']['outbox']; ?>
</a><?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['privmsg_folder'] == 'outbox'): ?></b><?php endif; ?><br>
<br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_admintable.tpl", 'smarty_include_vars' => array('table' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['table'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'sendprivmsg'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<b><a href="index.php?m=account&d=sendprivmsg"><?php echo $this->_tpl_vars['lang']['module_account']['send_message']; ?>
</a></b> :: <a href="index.php?m=account&d=viewprivmsg&folder=inbox"><?php echo $this->_tpl_vars['lang']['module_account']['inbox']; ?>
</a> :: <a href="index.php?m=account&d=viewprivmsg&folder=outbox"><?php echo $this->_tpl_vars['lang']['module_account']['outbox']; ?>
</a><br>
<br />
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['error_message'] != ""): ?>
<span style="color:#ff0000;"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['error_message']; ?>
</span><br />
<?php endif; ?>
<form action="index.php?m=account&d=postsendprivmsg" method="post">
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td valign="top" width="50%"><?php echo $this->_tpl_vars['lang']['module_account']['recipient']; ?>
</td>
    <td valign="top" width="50%"><input type="text" name="p_recipient" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['data']['recipient']; ?>
" style="width:100%"></td>
</tr>
<tr>
    <td valign="top"><?php echo $this->_tpl_vars['lang']['module_account']['message_theme']; ?>
</td>
    <td valign="top"><input type="text" name="p_theme" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['data']['theme']; ?>
" style="width:100%"></td>
</tr>
<tr>
    <td colspan="2" valign="top"><?php echo $this->_tpl_vars['lang']['module_account']['message_text']; ?>
<br />
<textarea cols="50" rows="15" name="p_text" style="width:100%"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['data']['text']; ?>
</textarea>	
	</td>
</tr>
<tr>
    <td colspan="2" valign="top" align="center">
	<input type="submit" value="<?php echo $this->_tpl_vars['lang']['module_account']['send_message']; ?>
">
	</td>
</tr>
</table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'readprivmsg'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<a href="index.php?m=account&d=sendprivmsg"><?php echo $this->_tpl_vars['lang']['module_account']['send_message']; ?>
</a> :: <a href="index.php?m=account&d=viewprivmsg&folder=inbox"><?php echo $this->_tpl_vars['lang']['module_account']['inbox']; ?>
</a> :: <a href="index.php?m=account&d=viewprivmsg&folder=outbox"><?php echo $this->_tpl_vars['lang']['module_account']['outbox']; ?>
</a><br>
<br />
<table width="100%" cellspacing="2" cellpadding="2" border="0">
<tr>
    <td valign="top" width="50%"><?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['folder_privmsg'] == 'outbox'): ?><?php echo $this->_tpl_vars['lang']['module_account']['recipient']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['module_account']['sender']; ?>
<?php endif; ?></td>
    <td valign="top" width="50%"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['user']; ?>
</td>
</tr>
<tr>
    <td valign="top"><?php echo $this->_tpl_vars['lang']['module_account']['message_theme']; ?>
</td>
    <td valign="top"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['theme']; ?>
</td>
</tr>
<tr>
    <td valign="top"><?php echo $this->_tpl_vars['lang']['common']['time']; ?>
</td>
    <td valign="top"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['time']; ?>
</td>
</tr>
<tr>
    <td colspan="2" valign="top"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['body']; ?>
</td>
</tr>
</table>
<form action="index.php?m=account&d=postsendprivmsg" method="post">
<input type="hidden" name="p_recipient" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['user']; ?>
" style="width:100%">
<input type="hidden" name="p_theme" value="Re: <?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['theme']; ?>
" style="width:100%">
<input type="hidden" name="p_body" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']['rebody']; ?>
" style="width:100%">
<input type="submit" value="<?php echo $this->_tpl_vars['lang']['module_account']['reply']; ?>
">
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
