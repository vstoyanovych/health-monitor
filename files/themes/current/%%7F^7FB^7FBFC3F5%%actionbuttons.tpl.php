<?php /* Smarty version 2.6.26, created on 2025-11-07 20:36:21
         compiled from actionbuttons.tpl */ ?>
<div class="dropdown action-buttons">
    <button class="btn ab-button dropdown-toggle btn-focus-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <span><?php if ($this->_tpl_vars['data']['button_title'] != ""): ?><?php echo $this->_tpl_vars['data']['button_title']; ?>
<?php else: ?>Actions<?php endif; ?> <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#4B5563" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
    </button>
    <div class="dropdown-menu dropdown-menu-compaign dropdown-menu-cont">
        <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['data']['actionbuttons']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
            <a href="<?php echo $this->_tpl_vars['data']['actionbuttons'][$this->_sections['i']['index']]['url']; ?>
" onclick="<?php echo $this->_tpl_vars['data']['actionbuttons'][$this->_sections['i']['index']]['onclick']; ?>
" class="dropdown-item <?php if ($this->_tpl_vars['data']['actionbuttons'][$this->_sections['i']['index']]['active']): ?>active<?php endif; ?>"><?php echo $this->_tpl_vars['data']['actionbuttons'][$this->_sections['i']['index']]['icon']; ?>
<span><?php echo $this->_tpl_vars['data']['actionbuttons'][$this->_sections['i']['index']]['title']; ?>
</span></a>
        <?php endfor; endif; ?>
    </div>
</div>