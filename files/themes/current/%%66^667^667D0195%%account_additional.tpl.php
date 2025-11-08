<?php /* Smarty version 2.6.26, created on 2024-09-15 05:36:41
         compiled from account_additional.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlescape', 'account_additional.tpl', 7, false),)), $this); ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'register'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message'] != ""): ?><div class="error-message"><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']; ?>
</div><?php endif; ?>
<table width="100%" border="0">
<form action="index.php?m=account&d=postregister" method="post" class="registerForm">
<tr>
<td width="50%"><?php if ($this->_tpl_vars['_settings']['use_email_as_login'] != '1'): ?><?php echo $this->_tpl_vars['lang']['login_str']; ?>
<?php else: ?><?php echo $this->_tpl_vars['lang']['common']['email']; ?>
<?php endif; ?></td><td width="50%"><input type="text" name="p_login" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['sm']['p']['p_login'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
</tr>
<tr>
<td><?php echo $this->_tpl_vars['lang']['password']; ?>
</td><td><input type="password" name="p_password" value=""></td>
</tr>
<tr>
<td><?php echo $this->_tpl_vars['lang']['repeat_password']; ?>
</td><td><input type="password" name="p_password2" value=""></td>
</tr>
<?php if ($this->_tpl_vars['_settings']['use_email_as_login'] != '1'): ?>
	<tr>
	<td><?php echo $this->_tpl_vars['lang']['email']; ?>
</td><td><input type="text" name="p_email" value="<?php echo $this->_tpl_vars['sm']['p']['p_email']; ?>
"></td>
	</tr>
<?php endif; ?>
<?php if ($this->_tpl_vars['_settings']['account_disable_secret_question'] != '1'): ?>
	<tr>
	<td><?php echo $this->_tpl_vars['lang']['secret_question']; ?>
</td><td><input type="text" name="p_question" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['sm']['p']['p_question'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
	</tr>
	<tr>
	<td><?php echo $this->_tpl_vars['lang']['secret_answer_question']; ?>
</td><td><input type="text" name="p_answer" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['sm']['p']['p_answer'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
	</tr>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "additionregister.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['_settings']['use_protect_code'] == '1'): ?>
	<tr>
	<td><?php echo $this->_tpl_vars['lang']['module_account']['enter_protect_code']; ?>
</td><td><img src="ext/antibot/antibot.php?rand=<?php echo $this->_tpl_vars['special']['rand']; ?>
"> <input type="text" name="p_protect_code" size="4"></td>
	</tr>
<?php endif; ?>
<tr>
<td colspan="2" align="center"><input type="submit" value="<?php echo $this->_tpl_vars['lang']['register']; ?>
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

<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'change'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message'] != ""): ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['message']; ?>
<?php endif; ?>
<form action="index.php?m=account&d=postchange" method="post" class="registerForm">
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td width="50%"><?php echo $this->_tpl_vars['lang']['login_str']; ?>
</td><td width="50%"><strong><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['user_login']; ?>
</strong></td></tr>
<tr><td colspan="2"><font size="1"><?php echo $this->_tpl_vars['lang']['set_passwords_if_want_to_change']; ?>
</font></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['old_password']; ?>
</td><td><input type="password" name="p_old_password" value=""></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['password']; ?>
</td><td><input type="password" name="p_password" value=""></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['repeat_password']; ?>
</td><td><input type="password" name="p_password2" value=""></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['email']; ?>
</td><td><input type="text" name="p_email" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['user_email']; ?>
"></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['secret_question']; ?>
</td><td><input type="text" name="p_question" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['user_question']; ?>
"></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['secret_answer_question']; ?>
</td><td><input type="text" name="p_answer" value="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['user_answer']; ?>
"></td></tr>
<tr><td><?php echo $this->_tpl_vars['lang']['module_account']['get_mail_from_admin']; ?>
</td><td><input type="checkbox" name="p_get_mail" value="1"<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['user_get_mail'] == 1): ?> checked<?php endif; ?>></td></tr>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "additionchreginfo.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<tr><td colspan="2" align="center"><input type="submit" value="<?php echo $this->_tpl_vars['lang']['change']; ?>
"></td></tr>
</table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
