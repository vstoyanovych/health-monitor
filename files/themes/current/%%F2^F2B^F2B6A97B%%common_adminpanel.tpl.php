<?php /* Smarty version 2.6.26, created on 2024-09-15 04:47:33
         compiled from common_adminpanel.tpl */ ?>
<?php echo ''; ?><?php unset($this->_sections['adminpanelblockindex']);
$this->_sections['adminpanelblockindex']['name'] = 'adminpanelblockindex';
$this->_sections['adminpanelblockindex']['loop'] = is_array($_loop=$this->_tpl_vars['panelblocks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['adminpanelblockindex']['show'] = true;
$this->_sections['adminpanelblockindex']['max'] = $this->_sections['adminpanelblockindex']['loop'];
$this->_sections['adminpanelblockindex']['step'] = 1;
$this->_sections['adminpanelblockindex']['start'] = $this->_sections['adminpanelblockindex']['step'] > 0 ? 0 : $this->_sections['adminpanelblockindex']['loop']-1;
if ($this->_sections['adminpanelblockindex']['show']) {
    $this->_sections['adminpanelblockindex']['total'] = $this->_sections['adminpanelblockindex']['loop'];
    if ($this->_sections['adminpanelblockindex']['total'] == 0)
        $this->_sections['adminpanelblockindex']['show'] = false;
} else
    $this->_sections['adminpanelblockindex']['total'] = 0;
if ($this->_sections['adminpanelblockindex']['show']):

            for ($this->_sections['adminpanelblockindex']['index'] = $this->_sections['adminpanelblockindex']['start'], $this->_sections['adminpanelblockindex']['iteration'] = 1;
                 $this->_sections['adminpanelblockindex']['iteration'] <= $this->_sections['adminpanelblockindex']['total'];
                 $this->_sections['adminpanelblockindex']['index'] += $this->_sections['adminpanelblockindex']['step'], $this->_sections['adminpanelblockindex']['iteration']++):
$this->_sections['adminpanelblockindex']['rownum'] = $this->_sections['adminpanelblockindex']['iteration'];
$this->_sections['adminpanelblockindex']['index_prev'] = $this->_sections['adminpanelblockindex']['index'] - $this->_sections['adminpanelblockindex']['step'];
$this->_sections['adminpanelblockindex']['index_next'] = $this->_sections['adminpanelblockindex']['index'] + $this->_sections['adminpanelblockindex']['step'];
$this->_sections['adminpanelblockindex']['first']      = ($this->_sections['adminpanelblockindex']['iteration'] == 1);
$this->_sections['adminpanelblockindex']['last']       = ($this->_sections['adminpanelblockindex']['iteration'] == $this->_sections['adminpanelblockindex']['total']);
?><?php echo ''; ?><?php unset($this->_sections['adminpanelitemindex']);
$this->_sections['adminpanelitemindex']['name'] = 'adminpanelitemindex';
$this->_sections['adminpanelitemindex']['loop'] = is_array($_loop=$this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['adminpanelitemindex']['show'] = true;
$this->_sections['adminpanelitemindex']['max'] = $this->_sections['adminpanelitemindex']['loop'];
$this->_sections['adminpanelitemindex']['step'] = 1;
$this->_sections['adminpanelitemindex']['start'] = $this->_sections['adminpanelitemindex']['step'] > 0 ? 0 : $this->_sections['adminpanelitemindex']['loop']-1;
if ($this->_sections['adminpanelitemindex']['show']) {
    $this->_sections['adminpanelitemindex']['total'] = $this->_sections['adminpanelitemindex']['loop'];
    if ($this->_sections['adminpanelitemindex']['total'] == 0)
        $this->_sections['adminpanelitemindex']['show'] = false;
} else
    $this->_sections['adminpanelitemindex']['total'] = 0;
if ($this->_sections['adminpanelitemindex']['show']):

            for ($this->_sections['adminpanelitemindex']['index'] = $this->_sections['adminpanelitemindex']['start'], $this->_sections['adminpanelitemindex']['iteration'] = 1;
                 $this->_sections['adminpanelitemindex']['iteration'] <= $this->_sections['adminpanelitemindex']['total'];
                 $this->_sections['adminpanelitemindex']['index'] += $this->_sections['adminpanelitemindex']['step'], $this->_sections['adminpanelitemindex']['iteration']++):
$this->_sections['adminpanelitemindex']['rownum'] = $this->_sections['adminpanelitemindex']['iteration'];
$this->_sections['adminpanelitemindex']['index_prev'] = $this->_sections['adminpanelitemindex']['index'] - $this->_sections['adminpanelitemindex']['step'];
$this->_sections['adminpanelitemindex']['index_next'] = $this->_sections['adminpanelitemindex']['index'] + $this->_sections['adminpanelitemindex']['step'];
$this->_sections['adminpanelitemindex']['first']      = ($this->_sections['adminpanelitemindex']['iteration'] == 1);
$this->_sections['adminpanelitemindex']['last']       = ($this->_sections['adminpanelitemindex']['iteration'] == $this->_sections['adminpanelitemindex']['total']);
?><?php echo ''; ?><?php if ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'form'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_adminform.tpl", 'smarty_include_vars' => array('form' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'table'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_admintable.tpl", 'smarty_include_vars' => array('table' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['table'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'board'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_boardmessages.tpl", 'smarty_include_vars' => array('board' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['board'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'bar'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_adminbuttons.tpl", 'smarty_include_vars' => array('bar' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['bar'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'pagebar'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['type'] == 'html'): ?><?php echo ''; ?><?php echo $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['html']; ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['tpl'] != ""): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['tpl'], 'smarty_include_vars' => array('data' => $this->_tpl_vars['panelblocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['data'],'action' => $this->_tpl_vars['blocks'][$this->_sections['adminpanelblockindex']['index']]['items'][$this->_sections['adminpanelitemindex']['index']]['action'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?>