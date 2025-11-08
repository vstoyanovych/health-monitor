<?php /* Smarty version 2.6.26, created on 2024-09-18 02:35:37
         compiled from common_adminnavigation.tpl */ ?>
<?php echo '<ul class="anav-container'; ?><?php if ($this->_tpl_vars['data']['class'] != ""): ?><?php echo ' '; ?><?php echo $this->_tpl_vars['data']['class']; ?><?php echo ''; ?><?php endif; ?><?php echo '">'; ?><?php $_from = $this->_tpl_vars['data']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['admindash_index'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['admindash_index']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item_index'] => $this->_tpl_vars['item']):
        $this->_foreach['admindash_index']['iteration']++;
?><?php echo ''; ?><?php echo $this->_tpl_vars['item']['htmlstart']; ?><?php echo '<li '; ?><?php $_from = $this->_tpl_vars['item']['container']['attrs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attr_name'] => $this->_tpl_vars['attr']):
?><?php echo ''; ?><?php if ($this->_tpl_vars['attr'] != ""): ?><?php echo ' '; ?><?php echo $this->_tpl_vars['attr_name']; ?><?php echo '="'; ?><?php echo $this->_tpl_vars['attr']; ?><?php echo '"'; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '><a '; ?><?php $_from = $this->_tpl_vars['item']['attrs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['admindashitemattrs_index'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['admindashitemattrs_index']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['attr_name'] => $this->_tpl_vars['attr']):
        $this->_foreach['admindashitemattrs_index']['iteration']++;
?><?php echo ''; ?><?php if ($this->_tpl_vars['attr'] != ""): ?><?php echo ' '; ?><?php echo $this->_tpl_vars['attr_name']; ?><?php echo '="'; ?><?php echo $this->_tpl_vars['attr']; ?><?php echo '"'; ?><?php endif; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '>'; ?><?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['item']['level']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['start'] = (int)1;
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
if ($this->_sections['j']['start'] < 0)
    $this->_sections['j']['start'] = max($this->_sections['j']['step'] > 0 ? 0 : -1, $this->_sections['j']['loop'] + $this->_sections['j']['start']);
else
    $this->_sections['j']['start'] = min($this->_sections['j']['start'], $this->_sections['j']['step'] > 0 ? $this->_sections['j']['loop'] : $this->_sections['j']['loop']-1);
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = min(ceil(($this->_sections['j']['step'] > 0 ? $this->_sections['j']['loop'] - $this->_sections['j']['start'] : $this->_sections['j']['start']+1)/abs($this->_sections['j']['step'])), $this->_sections['j']['max']);
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?><?php echo '<span class="anav-level-marker">-</span>'; ?><?php endfor; endif; ?><?php echo ''; ?><?php echo $this->_tpl_vars['item']['html']; ?><?php echo '</a></li>'; ?><?php echo $this->_tpl_vars['item']['htmlend']; ?><?php echo ''; ?><?php endforeach; endif; unset($_from); ?><?php echo '</ul>'; ?>