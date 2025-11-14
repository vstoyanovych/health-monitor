<?php /* Smarty version 2.6.26, created on 2025-11-14 18:34:10
         compiled from nuwmhealth_groups.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'nuwmhealth_groups.tpl', 2, false),array('modifier', 'escape', 'nuwmhealth_groups.tpl', 15, false),)), $this); ?>
<div class="nuwmhealth-groups">
    <?php if (count($this->_tpl_vars['data']['groups']) == 0): ?>
        <div class="nuwmhealth-group-card">
            <div class="nuwmhealth-group-header">
                <strong>No pages in this selection</strong>
            </div>
        </div>
    <?php else: ?>
        <?php $_from = $this->_tpl_vars['data']['groups']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
            <div class="nuwmhealth-group-card">
                <div class="nuwmhealth-group-header">
                    <div>
                        <strong>
                            <?php if ($this->_tpl_vars['group']['admin_email'] != ''): ?>
                                <a href="mailto:<?php echo ((is_array($_tmp=$this->_tpl_vars['group']['admin_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" class="admin-link"><?php echo ((is_array($_tmp=$this->_tpl_vars['group']['admin_label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
                            <?php else: ?>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['group']['admin_label'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                            <?php endif; ?>
                        </strong>
                        <span><?php echo count($this->_tpl_vars['group']['items']); ?>
 pages</span>
                    </div>
                </div>
                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>URL</th>
                            <th class="text-center">Ready</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $_from = $this->_tpl_vars['group']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                            <tr>
                                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                                <td>
                                    <?php if ($this->_tpl_vars['item']['url'] != ''): ?>
                                        <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target="_blank" rel="noopener"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($this->_tpl_vars['item']['ready']): ?>
                                        <span class="nuwmhealth-status-pill status-ready">Ready</span>
                                    <?php else: ?>
                                        <span class="nuwmhealth-status-pill status-not-ready">Missing</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; unset($_from); ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; endif; unset($_from); ?>
    <?php endif; ?>
</div>
