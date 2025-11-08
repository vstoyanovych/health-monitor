<?php /* Smarty version 2.6.26, created on 2024-09-15 04:38:54
         compiled from block_begin.tpl */ ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['borders_off'] != '1'): ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['panel'] == 'center'): ?>
		<div id="block<?php echo $this->_tpl_vars['index']; ?>
body">
			<div class="block">
				<div class="button-title-justify">
					<h2 id="block<?php echo $this->_tpl_vars['index']; ?>
title">
						<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image'] != ""): ?><img src="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image']; ?>
"> <?php endif; ?>
						<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to'] != ""): ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to']; ?>
<?php elseif ($this->_tpl_vars['panel_title'] != ""): ?><?php echo $this->_tpl_vars['panel_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['title']; ?>
<?php endif; ?>
					</h2>
				</div>

                <div class="block-content-outer">
<?php elseif ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['panel'] == '1'): ?>
		<div class="row" id="block<?php echo $this->_tpl_vars['index']; ?>
body">
			<div class="col-md-12">
				<h3>
					<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image'] != ""): ?><img src="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image']; ?>
"> <?php endif; ?>
					<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to'] != ""): ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to']; ?>
<?php elseif ($this->_tpl_vars['panel_title'] != ""): ?><?php echo $this->_tpl_vars['panel_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['title']; ?>
<?php endif; ?>
				</h3>
<?php else: ?>
		<div class="col-md-3" id="block<?php echo $this->_tpl_vars['index']; ?>
title">
			<div>		
				<h3>
					<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image'] != ""): ?><img src="<?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['block_image']; ?>
"> <?php endif; ?>
					<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to'] != ""): ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['rewrite_title_to']; ?>
<?php elseif ($this->_tpl_vars['panel_title'] != ""): ?><?php echo $this->_tpl_vars['panel_title']; ?>
<?php else: ?><?php echo $this->_tpl_vars['modules'][$this->_tpl_vars['index']]['title']; ?>
<?php endif; ?>
				</h3>
			</div>
<?php endif; ?>
<?php endif; ?>
<?php if ($this->_tpl_vars['tmp']['block'][$this->_tpl_vars['index']]['blockstart'] != 1): ?><?php echo $this->_tpl_vars['special']['document']['block'][$this->_tpl_vars['index']]['blockstart']; ?>
<?php $this->assign("tmp.block[".($this->_tpl_vars['index'])."].blockstart", 1); ?><?php endif; ?>