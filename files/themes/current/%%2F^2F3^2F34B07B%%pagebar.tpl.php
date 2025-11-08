<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from pagebar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'math', 'pagebar.tpl', 5, false),)), $this); ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages'] > '1'): ?>
	<ul class="pagination">
		<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected'] != 1): ?>
			<li>
				<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']-2), $this);?>
">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M9.78033 12.7803C9.48744 13.0732 9.01256 13.0732 8.71967 12.7803L4.46967 8.53033C4.17678 8.23744 4.17678 7.76256 4.46967 7.46967L8.71967 3.21967C9.01256 2.92678 9.48744 2.92678 9.78033 3.21967C10.0732 3.51256 10.0732 3.98744 9.78033 4.28033L6.06066 8L9.78033 11.7197C10.0732 12.0126 10.0732 12.4874 9.78033 12.7803Z" fill="CurrentColor"/>
					</svg><span>Previous</span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages'] <= 20): ?>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=5000) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['max'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages'];
$this->_sections['i']['start'] = (int)'1';
$this->_sections['i']['show'] = true;
if ($this->_sections['i']['max'] < 0)
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
		<?php elseif ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected'] < 9 || $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected'] > $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']-9): ?>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=10) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['max'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages'];
$this->_sections['i']['start'] = (int)'1';
$this->_sections['i']['show'] = true;
if ($this->_sections['i']['max'] < 0)
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
			<li class="disabled"><a>...</a></li>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']-9;
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
		<?php else: ?>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['max'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages'];
$this->_sections['i']['start'] = (int)'1';
$this->_sections['i']['show'] = true;
if ($this->_sections['i']['max'] < 0)
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
			<li class="disabled"><a>...</a></li>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']+4) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']-4;
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
			<li class="disabled"><a>...</a></li>
			<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['start'] = (int)$this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']-4;
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
				<li<?php if ($this->_sections['i']['index'] == $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']): ?> class="active"<?php endif; ?>>
					<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_sections['i']['index']-1), $this);?>
"><?php echo $this->_sections['i']['index']; ?>
</a>
				</li>
			<?php endfor; endif; ?>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected'] != $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['pages']): ?>
			<li>
				<a href="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['url']; ?>
&from=<?php echo smarty_function_math(array('equation' => "x*y",'x' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['interval'],'y' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['pages']['selected']), $this);?>
">
					<span>Next</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M6.21967 3.21967C6.51256 2.92678 6.98744 2.92678 7.28033 3.21967L11.5303 7.46967C11.8232 7.76256 11.8232 8.23744 11.5303 8.53033L7.28033 12.7803C6.98744 13.0732 6.51256 13.0732 6.21967 12.7803C5.92678 12.4874 5.92678 12.0126 6.21967 11.7197L9.93934 8L6.21967 4.28033C5.92678 3.98744 5.92678 3.51256 6.21967 3.21967Z" fill="CurrentColor"/>
					</svg>
				</a>
			</li>
		<?php endif; ?>
	</ul>
<?php endif; ?>