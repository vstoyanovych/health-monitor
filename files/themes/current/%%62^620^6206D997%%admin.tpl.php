<?php /* Smarty version 2.6.26, created on 2025-11-06 19:46:18
         compiled from admin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'htmlescape', 'admin.tpl', 18, false),array('modifier', 'lower', 'admin.tpl', 400, false),)), $this); ?>
<?php if ($this->_tpl_vars['m']['mode'] == 'settings'): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo $this->_tpl_vars['lang']['common']['profile']; ?>
: 
	<?php if ($this->_tpl_vars['m']['mode_settings'] != 'default'): ?><a href="index.php?m=admin&d=settings"><?php else: ?><b><?php endif; ?><?php echo $this->_tpl_vars['lang']['common']['general']; ?>
<?php if ($this->_tpl_vars['m']['mode_settings'] != 'default'): ?></a><?php else: ?></b><?php endif; ?>
	<?php unset($this->_sections['tmpextctrls']);
$this->_sections['tmpextctrls']['name'] = 'tmpextctrls';
$this->_sections['tmpextctrls']['loop'] = is_array($_loop=$this->_tpl_vars['m']['list_modes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['tmpextctrls']['show'] = true;
$this->_sections['tmpextctrls']['max'] = $this->_sections['tmpextctrls']['loop'];
$this->_sections['tmpextctrls']['step'] = 1;
$this->_sections['tmpextctrls']['start'] = $this->_sections['tmpextctrls']['step'] > 0 ? 0 : $this->_sections['tmpextctrls']['loop']-1;
if ($this->_sections['tmpextctrls']['show']) {
    $this->_sections['tmpextctrls']['total'] = $this->_sections['tmpextctrls']['loop'];
    if ($this->_sections['tmpextctrls']['total'] == 0)
        $this->_sections['tmpextctrls']['show'] = false;
} else
    $this->_sections['tmpextctrls']['total'] = 0;
if ($this->_sections['tmpextctrls']['show']):

            for ($this->_sections['tmpextctrls']['index'] = $this->_sections['tmpextctrls']['start'], $this->_sections['tmpextctrls']['iteration'] = 1;
                 $this->_sections['tmpextctrls']['iteration'] <= $this->_sections['tmpextctrls']['total'];
                 $this->_sections['tmpextctrls']['index'] += $this->_sections['tmpextctrls']['step'], $this->_sections['tmpextctrls']['iteration']++):
$this->_sections['tmpextctrls']['rownum'] = $this->_sections['tmpextctrls']['iteration'];
$this->_sections['tmpextctrls']['index_prev'] = $this->_sections['tmpextctrls']['index'] - $this->_sections['tmpextctrls']['step'];
$this->_sections['tmpextctrls']['index_next'] = $this->_sections['tmpextctrls']['index'] + $this->_sections['tmpextctrls']['step'];
$this->_sections['tmpextctrls']['first']      = ($this->_sections['tmpextctrls']['iteration'] == 1);
$this->_sections['tmpextctrls']['last']       = ($this->_sections['tmpextctrls']['iteration'] == $this->_sections['tmpextctrls']['total']);
?>
		  | 
		<?php if ($this->_tpl_vars['m']['mode_settings'] != $this->_tpl_vars['m']['list_modes'][$this->_sections['tmpextctrls']['index']]['mode']): ?><a href="index.php?m=admin&d=settings&viewmode=<?php echo $this->_tpl_vars['m']['list_modes'][$this->_sections['tmpextctrls']['index']]['mode']; ?>
"><?php else: ?><b><?php endif; ?><?php echo $this->_tpl_vars['m']['list_modes'][$this->_sections['tmpextctrls']['index']]['profile']; ?>
<?php if ($this->_tpl_vars['m']['mode_settings'] != $this->_tpl_vars['m']['list_modes'][$this->_sections['tmpextctrls']['index']]['mode']): ?></a><?php else: ?></b><?php endif; ?>
	<?php endfor; endif; ?>
<br /><br />
<form action="index.php?m=admin&d=postsettings&viewmode=<?php echo $this->_tpl_vars['m']['mode_settings']; ?>
" method="post">
<table width="100%" border="0">
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['common_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['resource_title'] == 1): ?>
		<tr>
		    <td width="50%"><?php echo $this->_tpl_vars['lang']['settings_resource_title']; ?>
:</td>
			<td><input type="text" name="p_title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['m']['edit_settings']['resource_title'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'resource_title')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_resource_title&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['resource_url'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_resource_url']; ?>
:</td>
			<td>http://<input type="text" name="p_url" value="<?php echo $this->_tpl_vars['m']['edit_settings']['resource_url']; ?>
"></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_resource_url&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['resource_url_mobile'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_resource_url_mobile']; ?>
:</td>
			<td>http://<input type="text" name="resource_url_mobile" value="<?php echo $this->_tpl_vars['m']['edit_settings']['resource_url_mobile']; ?>
"></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_resource_url_mobile&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['resource_url_tablet'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_resource_url_tablet']; ?>
:</td>
			<td>http://<input type="text" name="resource_url_tablet" value="<?php echo $this->_tpl_vars['m']['edit_settings']['resource_url_tablet']; ?>
"></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=resource_url_tablet&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['resource_url_rewrite'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="resource_url_rewrite" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['resource_url_rewrite'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_resource_url_rewrite']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=resource_url_rewrite&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['logo_text'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_logo_text']; ?>
:</td>
			<td><input type="text" name="p_logo" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['m']['edit_settings']['logo_text'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'logo_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_logo_text&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['copyright_text'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_copyright_text']; ?>
:</td>
			<td><input type="text" name="p_copyright" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['m']['edit_settings']['copyright_text'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'copyright_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_copyright_text&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['meta_keywords'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_meta_keywords']; ?>
:</td>
			<td><input type="text" name="p_keywords" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['m']['edit_settings']['meta_keywords'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'meta_keywords')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_meta_keywords&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['meta_description'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_meta_description']; ?>
:</td>
			<td><input type="text" name="p_description" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['m']['edit_settings']['meta_description'])) ? $this->_run_mod_handler('htmlescape', true, $_tmp) : htmlescape($_tmp)); ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'meta_description')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_meta_description&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['default_language'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_default_language']; ?>
: </td>
			<td><select name="p_lang" size="1">
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['lang']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['lang'][$this->_sections['i']['index']]; ?>
"<?php if ($this->_tpl_vars['m']['lang'][$this->_sections['i']['index']] == $this->_tpl_vars['m']['edit_settings']['default_language']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['lang'][$this->_sections['i']['index']]; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'default_language')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_default_language&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['default_theme'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_default_theme']; ?>
:</td>
			<td><select name="p_theme" size="1">
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['themes']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['themes'][$this->_sections['i']['index']]; ?>
"<?php if ($this->_tpl_vars['m']['themes'][$this->_sections['i']['index']] == $this->_tpl_vars['m']['edit_settings']['default_theme']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['themes'][$this->_sections['i']['index']]; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'default_theme')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_default_theme&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['sidepanel_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_sidepanel_count']; ?>
:</td>
			<td><select name="p_sidepanel_count" size="1">
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)1;
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_sections['i']['index']; ?>
"<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['m']['edit_settings']['sidepanel_count']): ?> SELECTED<?php endif; ?>><?php echo $this->_sections['i']['index']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'sidepanel_count')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_sidepanel_count&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['default_module'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_default_module']; ?>
:</td>
			<td><select name="p_module" size="1">
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['modules']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['modules'][$this->_sections['i']['index']]['name']; ?>
"<?php if ($this->_tpl_vars['m']['modules'][$this->_sections['i']['index']]['name'] == $this->_tpl_vars['m']['edit_settings']['default_module']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['modules'][$this->_sections['i']['index']]['title']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'default_module')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_default_module&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['cookprefix'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_cookprefix']; ?>
:</td>
			<td><input type="text" name="p_cook" value="<?php echo $this->_tpl_vars['m']['edit_settings']['cookprefix']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'cookprefix')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_cookprefix&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['max_upload_filesize'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_max_upload_filesize']; ?>
:</td>
			<td><input type="text" name="p_maxfsize" value="<?php echo $this->_tpl_vars['m']['edit_settings']['max_upload_filesize']; ?>
"> (<?php echo $this->_tpl_vars['lang']['bytes']; ?>
)</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'max_upload_filesize')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_max_upload_filesize&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['admin_items_by_page'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_admin_items_by_page']; ?>
:</td>
			<td><select name="p_adminitems_per_page" size="1">
			  <option value="5"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 5): ?> SELECTED<?php endif; ?>>5</option>
			  <option value="10"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 10): ?> SELECTED<?php endif; ?>>10</option>
			  <option value="15"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 15): ?> SELECTED<?php endif; ?>>15</option>
			  <option value="20"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 20): ?> SELECTED<?php endif; ?>>20</option>
			  <option value="30"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 30): ?> SELECTED<?php endif; ?>>30</option>
			  <option value="40"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 40): ?> SELECTED<?php endif; ?>>40</option>
			  <option value="50"<?php if ($this->_tpl_vars['m']['edit_settings']['admin_items_by_page'] == 50): ?> SELECTED<?php endif; ?>>50</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'admin_items_by_page')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_admin_items_by_page&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['search_items_by_page'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_search_items_by_page']; ?>
:</td>
			<td><select name="p_searchitems_per_page" size="1">
			  <option value="5"<?php if ($this->_tpl_vars['m']['edit_settings']['search_items_by_page'] == 5): ?> SELECTED<?php endif; ?>>5</option>
			  <option value="10"<?php if ($this->_tpl_vars['m']['edit_settings']['search_items_by_page'] == 10): ?> SELECTED<?php endif; ?>>10</option>
			  <option value="15"<?php if ($this->_tpl_vars['m']['edit_settings']['search_items_by_page'] == 15): ?> SELECTED<?php endif; ?>>15</option>
			  <option value="20"<?php if ($this->_tpl_vars['m']['edit_settings']['search_items_by_page'] == 20): ?> SELECTED<?php endif; ?>>20</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'search_items_by_page')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_search_items_by_page&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['ext_editor'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_extern_editor']; ?>
:</td>
			<td><select name="p_exteditor" size="1">
			  <option value=""<?php if ($this->_tpl_vars['m']['edit_settings']['ext_editor'] == ""): ?> SELECTED<?php endif; ?>>[---------]</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['exteditors']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['exteditors'][$this->_sections['i']['index']]; ?>
"<?php if ($this->_tpl_vars['m']['exteditors'][$this->_sections['i']['index']] == $this->_tpl_vars['m']['edit_settings']['ext_editor']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['exteditors'][$this->_sections['i']['index']]; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'ext_editor')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_extern_editor&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['noflood_time'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_noflood_time']; ?>
:</td>
			<td><input type="text" name="p_floodtime" value="<?php echo $this->_tpl_vars['m']['edit_settings']['noflood_time']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'noflood_time')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_noflood_time&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['blocks_use_image'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_blocks_use_image" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['blocks_use_image'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_blocks_use_image']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'blocks_use_image')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_blocks_use_image&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['rewrite_index_title'] == 1): ?>
		<tr>
		    <td width="50%"><?php echo $this->_tpl_vars['lang']['settings_rewrite_index_title']; ?>
:</td>
			<td><input type="text" name="p_rewrite_index_title" value="<?php echo $this->_tpl_vars['m']['edit_settings']['rewrite_index_title']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'rewrite_index_title')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_rewrite_index_title&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['log_type'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_log_type']; ?>
:</td>
			<td><select name="p_log_type" size="1">
			  <option value="0"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 0): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][0]; ?>
</option>
			  <option value="1"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 1): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][1]; ?>
</option>
			  <option value="10"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 10): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][10]; ?>
</option>
			  <option value="20"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 20): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][20]; ?>
</option>
			  <option value="30"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 30): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][30]; ?>
</option>
			  <option value="100"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 100): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][100]; ?>
</option>
			  <option value="120"<?php if ($this->_tpl_vars['m']['edit_settings']['log_type'] == 120): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['log_types'][120]; ?>
</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_log_type&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['log_store_days'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_log_store_days']; ?>
:</td>
			<td><input type="text" name="p_log_store_days" value="<?php echo $this->_tpl_vars['m']['edit_settings']['log_store_days']; ?>
"></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_log_store_days&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['image_generation_type'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_image_generation_type']; ?>
:</td>
			<td><select name="p_image_generation_type" size="1">
			  <option value="dynamic"<?php if ($this->_tpl_vars['m']['edit_settings']['image_generation_type'] != 'static'): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['dynamic']; ?>
</option>
			  <option value="static"<?php if ($this->_tpl_vars['m']['edit_settings']['image_generation_type'] == 'static'): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['static']; ?>
</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_image_generation_type&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['title_delimiter'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_title_delimiter']; ?>
:</td>
			<td><input type="text" name="p_title_delimiter" value="<?php echo $this->_tpl_vars['m']['edit_settings']['title_delimiter']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'title_delimiter')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_title_delimiter&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['meta_resource_title_position'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_meta_resource_title_position']; ?>
:</td>
			<td><select name="p_meta_resource_title_position" size="1">
			  <option value="0"<?php if ($this->_tpl_vars['m']['edit_settings']['meta_resource_title_position'] == '0'): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['meta_resource_title_position'][0]; ?>
</option>
			  <option value="1"<?php if ($this->_tpl_vars['m']['edit_settings']['meta_resource_title_position'] == '1'): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['meta_resource_title_position'][1]; ?>
</option>
			  <option value="2"<?php if ($this->_tpl_vars['m']['edit_settings']['meta_resource_title_position'] == '2'): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['module_admin']['meta_resource_title_position'][2]; ?>
</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'meta_resource_title_position')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_meta_resource_title_position&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['hide_generator_meta'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="hide_generator_meta" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['hide_generator_meta'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_hide_generator_meta']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_hide_generator_meta&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['module_admin']['menu_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['upper_menu_id'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_upper_menu_id']; ?>
:</td>
			<td><select name="p_uppermenu" size="1">
			  <option value=""<?php if ($this->_tpl_vars['m']['edit_settings']['upper_menu_id'] == ""): ?> SELECTED<?php endif; ?>>[---------]</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['menus']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id']; ?>
"<?php if ($this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['m']['edit_settings']['upper_menu_id']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['title']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'upper_menu_id')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_upper_menu_id&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['bottom_menu_id'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_bottom_menu_id']; ?>
:</td>
			<td><select name="p_bottommenu" size="1">
			  <option value=""<?php if ($this->_tpl_vars['m']['edit_settings']['bottom_menu_id'] == ""): ?> SELECTED<?php endif; ?>>[---------]</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['menus']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id']; ?>
"<?php if ($this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['m']['edit_settings']['bottom_menu_id']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['title']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'bottom_menu_id')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_bottom_menu_id&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['users_menu_id'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_users_menu_id']; ?>
:</td>
			<td><select name="p_usersmenu" size="1">
			  <option value=""<?php if ($this->_tpl_vars['m']['edit_settings']['users_menu_id'] == ""): ?> SELECTED<?php endif; ?>>[---------]</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['m']['menus']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id']; ?>
"<?php if ($this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['m']['edit_settings']['users_menu_id']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['m']['menus'][$this->_sections['i']['index']]['title']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'users_menu_id')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_users_menu_id&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['menus_use_image'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_menus_use_image" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['menus_use_image'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_menus_use_image']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'menus_use_image')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_menus_use_image&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['menuitems_use_image'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_menuitems_use_image" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['menuitems_use_image'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_menuitems_use_image']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'menuitems_use_image')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_menuitems_use_image&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['module_admin']['content_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_use_preview'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_preview" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['content_use_preview'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_content_use_preview']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_use_preview&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_per_page_multiview'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_content_per_page_multiview']; ?>
:</td>
			<td><select name="p_multiviewperpage" size="1">
			  <option value="5"<?php if ($this->_tpl_vars['m']['edit_settings']['content_per_page_multiview'] == 5): ?> SELECTED<?php endif; ?>>5</option>
			  <option value="10"<?php if ($this->_tpl_vars['m']['edit_settings']['content_per_page_multiview'] == 10): ?> SELECTED<?php endif; ?>>10</option>
			  <option value="15"<?php if ($this->_tpl_vars['m']['edit_settings']['content_per_page_multiview'] == 15): ?> SELECTED<?php endif; ?>>15</option>
			  <option value="20"<?php if ($this->_tpl_vars['m']['edit_settings']['content_per_page_multiview'] == 20): ?> SELECTED<?php endif; ?>>20</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_per_page_multiview')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_per_page_multiview&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['allow_alike_content'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_alike_content" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['allow_alike_content'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_allow_alike_content']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_allow_alike_content&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['alike_content_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_alike_content_count']; ?>
:</td>
			<td><input type="text" name="p_alike_content_count" value="<?php echo $this->_tpl_vars['m']['edit_settings']['alike_content_count']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'alike_content_count')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_alike_content_count&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_use_path'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_path" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['content_use_path'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_content_use_path']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_use_path')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_use_path&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_attachments_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_content_attachments_count']; ?>
:</td>
			<td><select name="p_content_attachments_count" size="1">
			  <option value="0"<?php if ($this->_tpl_vars['m']['edit_settings']['content_content_attachments_count'] == 0): ?> SELECTED<?php endif; ?>>-</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)1;
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_sections['i']['index']; ?>
"<?php if ($this->_tpl_vars['m']['edit_settings']['content_attachments_count'] == $this->_sections['i']['index']): ?> SELECTED<?php endif; ?>><?php echo $this->_sections['i']['index']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_attachments_count&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_use_image'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_content_use_image" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['content_use_image'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_content_use_image']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_use_image')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_use_image&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_image_preview_width'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_width']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['preview'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_content_image_preview_width" value="<?php echo $this->_tpl_vars['m']['edit_settings']['content_image_preview_width']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_image_preview_width')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=content_image_preview_width&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_image_preview_height'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_height']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['preview'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_content_image_preview_height" value="<?php echo $this->_tpl_vars['m']['edit_settings']['content_image_preview_height']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_image_preview_height')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=content_image_preview_height&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_image_fulltext_width'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_width']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['full_text'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_content_image_fulltext_width" value="<?php echo $this->_tpl_vars['m']['edit_settings']['content_image_fulltext_width']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_image_fulltext_width')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=content_image_fulltext_width&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_image_fulltext_height'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_height']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['full_text'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_content_image_fulltext_height" value="<?php echo $this->_tpl_vars['m']['edit_settings']['content_image_fulltext_height']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'content_image_fulltext_height')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=content_image_fulltext_height&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['content_editor_level'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_editor_level']; ?>
: </td>
			<td><select name="content_editor_level" size="1">
				<option value="3"<?php if (3 == $this->_tpl_vars['m']['edit_settings']['content_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['administrators']; ?>
</option>
				<option value="2"<?php if (2 == $this->_tpl_vars['m']['edit_settings']['content_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['power_users']; ?>
</option>
				<option value="1"<?php if (1 == $this->_tpl_vars['m']['edit_settings']['content_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['logged_users']; ?>
</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_editor_level&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['autogenerate_content_filesystem'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['autogeneration']; ?>
 - <?php echo $this->_tpl_vars['lang']['common']['url']; ?>
: </td>
			<td><select name="autogenerate_content_filesystem" size="1">
				<option value=""<?php if ("" == $this->_tpl_vars['m']['edit_settings']['autogenerate_content_filesystem']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['none']; ?>
</option>
				<option value="1"<?php if (1 == $this->_tpl_vars['m']['edit_settings']['autogenerate_content_filesystem']): ?> SELECTED<?php endif; ?>>content-title.html</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_editor_level&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['news_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_use_time'] == 1): ?>
	<tr>
		<td colspan="2"><input type="checkbox" name="p_news_use_time" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['news_use_time'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_news_use_time']; ?>
</td>
		<td></td>
		<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_use_time&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
	</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_use_image'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_news_use_image" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['news_use_image'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_news_use_image']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_use_image')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_use_image&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_image_preview_width'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_width']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['preview'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_news_image_preview_width" value="<?php echo $this->_tpl_vars['m']['edit_settings']['news_image_preview_width']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_image_preview_width')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_image_preview_width&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_image_preview_height'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_height']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['preview'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_news_image_preview_height" value="<?php echo $this->_tpl_vars['m']['edit_settings']['news_image_preview_height']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_image_preview_height')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_image_preview_height&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_image_fulltext_width'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_width']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['full_text'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_news_image_fulltext_width" value="<?php echo $this->_tpl_vars['m']['edit_settings']['news_image_fulltext_width']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_image_fulltext_width')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_image_fulltext_width&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_image_fulltext_height'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['common']['image_height']; ?>
 (<?php echo ((is_array($_tmp=$this->_tpl_vars['lang']['common']['full_text'])) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
):</td>
			<td><input type="text" name="p_news_image_fulltext_height" value="<?php echo $this->_tpl_vars['m']['edit_settings']['news_image_fulltext_height']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_image_fulltext_height')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_image_fulltext_height&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_by_page'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_news_per_page']; ?>
:</td>
			<td><select name="p_news_per_page" size="1">
			  <option value="5"<?php if ($this->_tpl_vars['m']['edit_settings']['news_by_page'] == 5): ?> SELECTED<?php endif; ?>>5</option>
			  <option value="10"<?php if ($this->_tpl_vars['m']['edit_settings']['news_by_page'] == 10): ?> SELECTED<?php endif; ?>>10</option>
			  <option value="15"<?php if ($this->_tpl_vars['m']['edit_settings']['news_by_page'] == 15): ?> SELECTED<?php endif; ?>>15</option>
			  <option value="20"<?php if ($this->_tpl_vars['m']['edit_settings']['news_by_page'] == 20): ?> SELECTED<?php endif; ?>>20</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_by_page')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_per_page&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_use_preview'] == 1): ?>
	<tr>
		<td colspan="2"><input type="checkbox" name="p_news_use_preview" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['news_use_preview'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_news_use_preview']; ?>
</td>
		<td></td>
		<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_use_preview&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
	</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_anounce_cut'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_news_anounce_cut']; ?>
:</td>
			<td><select name="p_news_cut" size="1">
			  <option value="50"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 50): ?> SELECTED<?php endif; ?>>50</option>
			  <option value="100"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 100): ?> SELECTED<?php endif; ?>>100</option>
			  <option value="150"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 150): ?> SELECTED<?php endif; ?>>150</option>
			  <option value="200"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 200): ?> SELECTED<?php endif; ?>>200</option>
			  <option value="300"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 300): ?> SELECTED<?php endif; ?>>300</option>
			  <option value="400"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 400): ?> SELECTED<?php endif; ?>>400</option>
			  <option value="500"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 500): ?> SELECTED<?php endif; ?>>500</option>
			  <option value="500"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 700): ?> SELECTED<?php endif; ?>>700</option>
			  <option value="1000"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 1000): ?> SELECTED<?php endif; ?>>1000</option>
			  <option value="1000"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 2000): ?> SELECTED<?php endif; ?>>2000</option>
			  <option value="1000"<?php if ($this->_tpl_vars['m']['edit_settings']['news_anounce_cut'] == 10000): ?> SELECTED<?php endif; ?>>10000</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_anounce_cut')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_anounce_cut&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['short_news_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_count_short_news']; ?>
:</td>
			<td><select name="p_news_short" size="1">
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=20) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)1;
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
				  <option value="<?php echo $this->_sections['i']['index']; ?>
"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_count'] == $this->_sections['i']['index']): ?> SELECTED<?php endif; ?>><?php echo $this->_sections['i']['index']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'short_news_count')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_count_short_news&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['short_news_cut'] == 1): ?>
		<tr>				 
			<td><?php echo $this->_tpl_vars['lang']['settings_short_news_cut']; ?>
:</td>
			<td><select name="p_short_news_cut" size="1">
			  <option value="50"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 50): ?> SELECTED<?php endif; ?>>50</option>
			  <option value="100"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 100): ?> SELECTED<?php endif; ?>>100</option>
			  <option value="150"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 150): ?> SELECTED<?php endif; ?>>150</option>
			  <option value="200"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 200): ?> SELECTED<?php endif; ?>>200</option>
			  <option value="300"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 300): ?> SELECTED<?php endif; ?>>300</option>
			  <option value="400"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 400): ?> SELECTED<?php endif; ?>>400</option>
			  <option value="500"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 500): ?> SELECTED<?php endif; ?>>500</option>
			  <option value="700"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 600): ?> SELECTED<?php endif; ?>>700</option>
			  <option value="1000"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 1000): ?> SELECTED<?php endif; ?>>1000</option>
			  <option value="10000"<?php if ($this->_tpl_vars['m']['edit_settings']['short_news_cut'] == 10000): ?> SELECTED<?php endif; ?>>10000</option>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'short_news_cut')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_short_news_cut&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['allow_alike_news'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_alike_news" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['allow_alike_news'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_allow_alike_news']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_allow_alike_news&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['alike_news_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_alike_news_count']; ?>
:</td>
			<td><input type="text" name="p_alike_news_count" value="<?php echo $this->_tpl_vars['m']['edit_settings']['alike_news_count']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'alike_news_count')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_alike_news_count&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_attachments_count'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_news_attachments_count']; ?>
:</td>
			<td><select name="p_news_attachments_count" size="1">
			  <option value="0"<?php if ($this->_tpl_vars['m']['edit_settings']['news_news_attachments_count'] == 0): ?> SELECTED<?php endif; ?>>-</option>
			  <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=16) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)1;
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
if ($this->_sections['i']['start'] < 0)
    $this->_sections['i']['start'] = max($this->_sections['i']['step'] > 0 ? 0 : -1, $this->_sections['i']['loop'] + $this->_sections['i']['start']);
else
    $this->_sections['i']['start'] = min($this->_sections['i']['start'], $this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] : $this->_sections['i']['loop']-1);
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = min(ceil(($this->_sections['i']['step'] > 0 ? $this->_sections['i']['loop'] - $this->_sections['i']['start'] : $this->_sections['i']['start']+1)/abs($this->_sections['i']['step'])), $this->_sections['i']['max']);
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
			  <option value="<?php echo $this->_sections['i']['index']; ?>
"<?php if ($this->_tpl_vars['m']['edit_settings']['news_attachments_count'] == $this->_sections['i']['index']): ?> SELECTED<?php endif; ?>><?php echo $this->_sections['i']['index']; ?>
</option>
			  <?php endfor; endif; ?>
			</select></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'news_news_attachments_count')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_attachments_count&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_full_list_longformat'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['list_news']; ?>
: </td>
			<td><select name="news_full_list_longformat" size="1">
				<option value="0"<?php if (0 == $this->_tpl_vars['m']['edit_settings']['news_full_list_longformat']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['preview']; ?>
</option>
				<option value="1"<?php if (1 == $this->_tpl_vars['m']['edit_settings']['news_full_list_longformat']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['full_text']; ?>
</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=news_full_list_longformat&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['news_editor_level'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_editor_level']; ?>
: </td>
			<td><select name="news_editor_level" size="1">
				<option value="3"<?php if (3 == $this->_tpl_vars['m']['edit_settings']['news_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['administrators']; ?>
</option>
				<option value="2"<?php if (2 == $this->_tpl_vars['m']['edit_settings']['news_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['power_users']; ?>
</option>
				<option value="1"<?php if (1 == $this->_tpl_vars['m']['edit_settings']['news_editor_level']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['logged_users']; ?>
</option>
			</select></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_news_editor_level&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['autogenerate_news_filesystem'] == 1): ?>
	<tr>
		<td><?php echo $this->_tpl_vars['lang']['common']['autogeneration']; ?>
 - <?php echo $this->_tpl_vars['lang']['common']['url']; ?>
: </td>
		<td><select name="autogenerate_news_filesystem" size="1">
			<option value=""<?php if ("" == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>><?php echo $this->_tpl_vars['lang']['common']['none']; ?>
</option>
			<option value="1"<?php if (1 == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>>news-title.html</option>
			<option value="2"<?php if (2 == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>>news/news-title.html</option>
			<option value="4"<?php if (2 == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>>news/yyyy/mm/dd/news-title.html</option>
			<option value="3"<?php if (3 == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>>blog/news-title.html</option>
			<option value="5"<?php if (5 == $this->_tpl_vars['m']['edit_settings']['autogenerate_news_filesystem']): ?> SELECTED<?php endif; ?>>blog/yyyy/mm/dd/news-title.html</option>
		</select></td>
		<td></td>
		<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_content_editor_level&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
	</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['user_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['allow_register'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allowregister" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['allow_register'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_allow_register']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_allow_register&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['allow_forgot_password'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allowforgotpass" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['allow_forgot_password'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_allow_forgot_password']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_allow_forgot_password&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['user_activating_by_admin'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_adminactivating" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['user_activating_by_admin'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_user_activating_by_admin']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_user_activating_by_admin&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['return_after_login'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_return_after_login" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['return_after_login'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_return_after_login']; ?>
</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'return_after_login')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_return_after_login&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['allow_private_messages'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_allow_private_messages" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['allow_private_messages'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_allow_private_messages']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_allow_private_messages&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['use_email_as_login'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="p_use_email_as_login" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['use_email_as_login'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_use_email_as_login']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_use_email_as_login&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['signinwithloginandemail'] == 1): ?>
		<tr>
			<td colspan="2"><input type="checkbox" name="signinwithloginandemail" value="1" <?php if ($this->_tpl_vars['m']['edit_settings']['signinwithloginandemail'] == '1'): ?>checked<?php endif; ?>> <?php echo $this->_tpl_vars['lang']['settings_signinwithloginandemail']; ?>
</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=signinwithloginandemail&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_after_login_1'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_after_login']; ?>
 (<?php echo $this->_tpl_vars['lang']['logged_users']; ?>
):</td>
			<td><input type="text" name="p_redirect_after_login_1" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_after_login_1']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_after_login_1')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_after_login_1&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_after_login_2'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_after_login']; ?>
 (<?php echo $this->_tpl_vars['lang']['power_users']; ?>
):</td>
			<td><input type="text" name="p_redirect_after_login_2" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_after_login_2']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_after_login_2')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_after_login_2&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_after_login_3'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_after_login']; ?>
 (<?php echo $this->_tpl_vars['lang']['administrators']; ?>
):</td>
			<td><input type="text" name="p_redirect_after_login_3" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_after_login_3']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_after_login_3')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_after_login_3&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_after_register'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_after_register']; ?>
:</td>
			<td><input type="text" name="p_redirect_after_register" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_after_register']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_after_register')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_after_register&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_after_logout'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_after_logout']; ?>
:</td>
			<td><input type="text" name="p_redirect_after_logout" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_after_logout']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_after_logout')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_after_logout&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['redirect_on_success_change_usrdata'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_redirect_on_success_change_usrdata']; ?>
:</td>
			<td><input type="text" name="redirect_on_success_change_usrdata" value="<?php echo $this->_tpl_vars['m']['edit_settings']['redirect_on_success_change_usrdata']; ?>
"></td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'redirect_on_success_change_usrdata')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=redirect_on_success_change_usrdata&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['security_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['banned_ip'] == 1): ?>
		<tr>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']['settings_banned_ip']; ?>
<br /><div align="center">
				<textarea cols="40" rows="3" name="p_banned_ip"><?php echo $this->_tpl_vars['m']['edit_settings']['banned_ip']; ?>
</textarea>
				</div>
			</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_banned_ip&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['static_text_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['meta_header_text'] == 1): ?>
		<tr>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']['settings_meta_header_text']; ?>
<br /><div align="center">
				<textarea cols="40" rows="3" name="p_meta_header_text" wrap="off"><?php echo $this->_tpl_vars['m']['edit_settings']['meta_header_text']; ?>
</textarea>
				</div>
			</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'meta_header_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_meta_header_text&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['header_static_text'] == 1): ?>
		<tr>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']['settings_header_static_text']; ?>
<br /><div align="center">
				<textarea cols="40" rows="3" name="p_htext" wrap="off"><?php echo $this->_tpl_vars['m']['edit_settings']['header_static_text']; ?>
</textarea>
				</div>
			</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'header_static_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_header_static_text&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['footer_static_text'] == 1): ?>
		<tr>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']['settings_footer_static_text']; ?>
<br /><div align="center">
				<textarea cols="40" rows="3" name="p_ftext" wrap="off"><?php echo $this->_tpl_vars['m']['edit_settings']['footer_static_text']; ?>
</textarea>
				</div>
			</td>
			<td><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'admin_settings_extctrls.tpl', 'smarty_include_vars' => array('name_settings' => 'footer_static_text')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_footer_static_text&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<tr>
	<td colspan="4" class="admin-settings-separator"><?php echo $this->_tpl_vars['lang']['module_admin']['mass_email_settings']; ?>
</td>
</tr>
	<?php if ($this->_tpl_vars['m']['show_settings']['administrators_email'] == 1): ?>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['settings_administrators_email']; ?>
</td>
			<td><input type="text" name="p_admemail" value="<?php echo $this->_tpl_vars['m']['edit_settings']['administrators_email']; ?>
"></td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_administrators_email&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
	<?php if ($this->_tpl_vars['m']['show_settings']['email_signature'] == 1): ?>
		<tr>
			<td colspan="2"><?php echo $this->_tpl_vars['lang']['settings_email_signature']; ?>
<br /><div align="center">
				<textarea cols="40" rows="3" name="p_esignature"><?php echo $this->_tpl_vars['m']['edit_settings']['email_signature']; ?>
</textarea>
				</div>
			</td>
			<td></td>
			<td><?php if ($this->_tpl_vars['_settings']['show_help'] == 'on'): ?><a target="_blank" href="http://<?php echo $this->_tpl_vars['m']['edit_settings']['help_resource']; ?>
/index.php?m=help&q=settings_email_signature&lang=<?php echo $this->_tpl_vars['m']['edit_settings']['default_language']; ?>
">[?]</a><?php endif; ?></td>
		</tr>
	<?php endif; ?>
<?php echo $this->_tpl_vars['m']['formadditionalhtml']; ?>

<tr>
	<td colspan="4" style="text-align: center"><input type="submit" value="<?php echo $this->_tpl_vars['lang']['save']; ?>
"></td>
</tr>
</table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>