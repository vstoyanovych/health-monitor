<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from path.tpl */ ?>
<?php if ($this->_tpl_vars['special']['pathcount'] > 0): ?>
<ol class="breadcrumb">
<?php unset($this->_sections['path_index']);
$this->_sections['path_index']['name'] = 'path_index';
$this->_sections['path_index']['loop'] = is_array($_loop=$this->_tpl_vars['special']['path']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['path_index']['show'] = true;
$this->_sections['path_index']['max'] = $this->_sections['path_index']['loop'];
$this->_sections['path_index']['step'] = 1;
$this->_sections['path_index']['start'] = $this->_sections['path_index']['step'] > 0 ? 0 : $this->_sections['path_index']['loop']-1;
if ($this->_sections['path_index']['show']) {
    $this->_sections['path_index']['total'] = $this->_sections['path_index']['loop'];
    if ($this->_sections['path_index']['total'] == 0)
        $this->_sections['path_index']['show'] = false;
} else
    $this->_sections['path_index']['total'] = 0;
if ($this->_sections['path_index']['show']):

            for ($this->_sections['path_index']['index'] = $this->_sections['path_index']['start'], $this->_sections['path_index']['iteration'] = 1;
                 $this->_sections['path_index']['iteration'] <= $this->_sections['path_index']['total'];
                 $this->_sections['path_index']['index'] += $this->_sections['path_index']['step'], $this->_sections['path_index']['iteration']++):
$this->_sections['path_index']['rownum'] = $this->_sections['path_index']['iteration'];
$this->_sections['path_index']['index_prev'] = $this->_sections['path_index']['index'] - $this->_sections['path_index']['step'];
$this->_sections['path_index']['index_next'] = $this->_sections['path_index']['index'] + $this->_sections['path_index']['step'];
$this->_sections['path_index']['first']      = ($this->_sections['path_index']['iteration'] == 1);
$this->_sections['path_index']['last']       = ($this->_sections['path_index']['iteration'] == $this->_sections['path_index']['total']);
?>
  <li>
    <a href="<?php echo $this->_tpl_vars['special']['path'][$this->_sections['path_index']['index']]['url']; ?>
"><?php echo $this->_tpl_vars['special']['path'][$this->_sections['path_index']['index']]['title']; ?>
</a>
  </li>
<?php endfor; endif; ?>
</ol>
<?php endif; ?>