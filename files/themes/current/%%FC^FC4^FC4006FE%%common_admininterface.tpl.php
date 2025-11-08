<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from common_admininterface.tpl */ ?>
<?php echo ''; ?><?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'common_admininterface_launcher' && $this->_tpl_vars['blocks'] == ""): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_admininterface.tpl", 'smarty_include_vars' => array('blocks' => $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['common_admininterface_output'],'uiblockindex' => $this->_sections['admininterfaceblockindex']['index'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php unset($this->_sections['admininterfaceblockindex']);
$this->_sections['admininterfaceblockindex']['name'] = 'admininterfaceblockindex';
$this->_sections['admininterfaceblockindex']['loop'] = is_array($_loop=$this->_tpl_vars['blocks']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['admininterfaceblockindex']['show'] = true;
$this->_sections['admininterfaceblockindex']['max'] = $this->_sections['admininterfaceblockindex']['loop'];
$this->_sections['admininterfaceblockindex']['step'] = 1;
$this->_sections['admininterfaceblockindex']['start'] = $this->_sections['admininterfaceblockindex']['step'] > 0 ? 0 : $this->_sections['admininterfaceblockindex']['loop']-1;
if ($this->_sections['admininterfaceblockindex']['show']) {
    $this->_sections['admininterfaceblockindex']['total'] = $this->_sections['admininterfaceblockindex']['loop'];
    if ($this->_sections['admininterfaceblockindex']['total'] == 0)
        $this->_sections['admininterfaceblockindex']['show'] = false;
} else
    $this->_sections['admininterfaceblockindex']['total'] = 0;
if ($this->_sections['admininterfaceblockindex']['show']):

            for ($this->_sections['admininterfaceblockindex']['index'] = $this->_sections['admininterfaceblockindex']['start'], $this->_sections['admininterfaceblockindex']['iteration'] = 1;
                 $this->_sections['admininterfaceblockindex']['iteration'] <= $this->_sections['admininterfaceblockindex']['total'];
                 $this->_sections['admininterfaceblockindex']['index'] += $this->_sections['admininterfaceblockindex']['step'], $this->_sections['admininterfaceblockindex']['iteration']++):
$this->_sections['admininterfaceblockindex']['rownum'] = $this->_sections['admininterfaceblockindex']['iteration'];
$this->_sections['admininterfaceblockindex']['index_prev'] = $this->_sections['admininterfaceblockindex']['index'] - $this->_sections['admininterfaceblockindex']['step'];
$this->_sections['admininterfaceblockindex']['index_next'] = $this->_sections['admininterfaceblockindex']['index'] + $this->_sections['admininterfaceblockindex']['step'];
$this->_sections['admininterfaceblockindex']['first']      = ($this->_sections['admininterfaceblockindex']['iteration'] == 1);
$this->_sections['admininterfaceblockindex']['last']       = ($this->_sections['admininterfaceblockindex']['iteration'] == $this->_sections['admininterfaceblockindex']['total']);
?><?php echo ''; ?><?php if ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['show_borders'] == 1): ?><?php echo ''; ?><?php if ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['title'] == ""): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php else: ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array('panel_title' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['title'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php unset($this->_sections['admininterfaceitemindex']);
$this->_sections['admininterfaceitemindex']['name'] = 'admininterfaceitemindex';
$this->_sections['admininterfaceitemindex']['loop'] = is_array($_loop=$this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['admininterfaceitemindex']['show'] = true;
$this->_sections['admininterfaceitemindex']['max'] = $this->_sections['admininterfaceitemindex']['loop'];
$this->_sections['admininterfaceitemindex']['step'] = 1;
$this->_sections['admininterfaceitemindex']['start'] = $this->_sections['admininterfaceitemindex']['step'] > 0 ? 0 : $this->_sections['admininterfaceitemindex']['loop']-1;
if ($this->_sections['admininterfaceitemindex']['show']) {
    $this->_sections['admininterfaceitemindex']['total'] = $this->_sections['admininterfaceitemindex']['loop'];
    if ($this->_sections['admininterfaceitemindex']['total'] == 0)
        $this->_sections['admininterfaceitemindex']['show'] = false;
} else
    $this->_sections['admininterfaceitemindex']['total'] = 0;
if ($this->_sections['admininterfaceitemindex']['show']):

            for ($this->_sections['admininterfaceitemindex']['index'] = $this->_sections['admininterfaceitemindex']['start'], $this->_sections['admininterfaceitemindex']['iteration'] = 1;
                 $this->_sections['admininterfaceitemindex']['iteration'] <= $this->_sections['admininterfaceitemindex']['total'];
                 $this->_sections['admininterfaceitemindex']['index'] += $this->_sections['admininterfaceitemindex']['step'], $this->_sections['admininterfaceitemindex']['iteration']++):
$this->_sections['admininterfaceitemindex']['rownum'] = $this->_sections['admininterfaceitemindex']['iteration'];
$this->_sections['admininterfaceitemindex']['index_prev'] = $this->_sections['admininterfaceitemindex']['index'] - $this->_sections['admininterfaceitemindex']['step'];
$this->_sections['admininterfaceitemindex']['index_next'] = $this->_sections['admininterfaceitemindex']['index'] + $this->_sections['admininterfaceitemindex']['step'];
$this->_sections['admininterfaceitemindex']['first']      = ($this->_sections['admininterfaceitemindex']['iteration'] == 1);
$this->_sections['admininterfaceitemindex']['last']       = ($this->_sections['admininterfaceitemindex']['iteration'] == $this->_sections['admininterfaceitemindex']['total']);
?><?php echo ''; ?><?php if ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'form'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_adminform.tpl", 'smarty_include_vars' => array('form' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['form'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'table'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_admintable.tpl", 'smarty_include_vars' => array('table' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['table'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'board'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_boardmessages.tpl", 'smarty_include_vars' => array('board' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['board'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'bar'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_adminbuttons.tpl", 'smarty_include_vars' => array('bar' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['bar'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'panel'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "common_adminpanel.tpl", 'smarty_include_vars' => array('panelblocks' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['panel'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'pagebar'): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['type'] == 'html'): ?><?php echo ''; ?><?php echo $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['html']; ?><?php echo ''; ?><?php elseif ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['tpl'] != ""): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['tpl'], 'smarty_include_vars' => array('data' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['data'],'action' => $this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['items'][$this->_sections['admininterfaceitemindex']['index']]['action'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?><?php if ($this->_tpl_vars['blocks'][$this->_sections['admininterfaceblockindex']['index']]['show_borders'] == 1): ?><?php echo ''; ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?><?php endfor; endif; ?><?php echo ''; ?><?php endif; ?><?php echo ''; ?>