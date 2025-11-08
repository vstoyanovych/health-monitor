<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from block_end.tpl */ ?>
<?php if ($this->_tpl_vars['tmp']['block'][$this->_tpl_vars['index']]['blockend'] != 1): ?><?php echo $this->_tpl_vars['special']['document']['block'][$this->_tpl_vars['index']]['blockend']; ?>
<?php $this->assign("tmp.block[".($this->_tpl_vars['index'])."].blockend", 1); ?><?php endif; ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['borders_off'] != '1'): ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['panel'] == 'center'): ?>
      </div>
	</div>
</div>
<?php elseif ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['panel'] == '1'): ?>
  	</div>
</div>
<?php else: ?>
  </div>
<?php endif; ?>
<?php endif; ?>