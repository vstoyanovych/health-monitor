<?php /* Smarty version 2.6.26, created on 2025-11-08 02:24:00
         compiled from dashboard.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'dashboard.tpl', 27, false),array('modifier', 'escape', 'dashboard.tpl', 41, false),array('modifier', 'default', 'dashboard.tpl', 48, false),)), $this); ?>
<?php $this->assign('m', $this->_tpl_vars['modules'][$this->_tpl_vars['index']]); ?>
<?php if ($this->_tpl_vars['modules'][$this->_tpl_vars['index']]['mode'] == 'view'): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_begin.tpl", 'smarty_include_vars' => array('panel_title' => ' ')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['m']['error_message'] != ""): ?>
        <div class="aui-message aui-message-error"><?php echo $this->_tpl_vars['m']['error_message']; ?>
</div>
    <?php endif; ?>

    <div class="dashboard-resources-container">
        <div class="dashboard-resources-card">
            <div class="resources-header">
                <div class="resources-title-group">
                    <h2>Monitored Resources</h2>
                    <p class="resources-subtitle">Track availability and response of your critical services in real time.</p>
                </div>
                <a href="<?php echo $this->_tpl_vars['m']['resources_monitoring']['add_url']; ?>
" class="dashboard-add-resource-btn">
                    <span class="btn-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 3.33325V12.6666" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.33398 8H12.6673" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    Add Resource
                </a>
            </div>

            <div class="dashboard-resources-table-wrap">
                <?php if (count($this->_tpl_vars['m']['resources_monitoring']['items']) > 0): ?>
                    <table class="dashboard-resources-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Last 24h</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $_from = $this->_tpl_vars['m']['resources_monitoring']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['resource']):
?>
                                <tr>
                                    <td class="resource-name">
                                        <div class="resource-service-name"><?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['service'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</div>
                                        <?php if ($this->_tpl_vars['resource']['url'] != ''): ?>
                                            <div class="resource-url">
                                                <a href="<?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" target="_blank" rel="noopener"><?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['url'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['resource']['department'])) ? $this->_run_mod_handler('default', true, $_tmp, '—') : smarty_modifier_default($_tmp, '—')))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
                                    <td>
                                        <span class="resource-status-pill <?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['status_class'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">
                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['status'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                        </span>
                                        <?php if ($this->_tpl_vars['resource']['status_last_checked'] != ''): ?>
                                            <div class="resource-status-meta">
                                                Last checked <?php echo ((is_array($_tmp=$this->_tpl_vars['resource']['status_last_checked'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="resource-availability-bar">
                                            <?php $_from = $this->_tpl_vars['resource']['history_segments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['segment']):
?>
                                                <span class="resource-availability-segment status-<?php echo ((is_array($_tmp=$this->_tpl_vars['segment'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"></span>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; endif; unset($_from); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="dashboard-resources-empty">
                        <h3>No resources yet</h3>
                        <p><?php echo ((is_array($_tmp=@$this->_tpl_vars['m']['resources_monitoring']['empty_message'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Start by adding a service you want to monitor.') : smarty_modifier_default($_tmp, 'Start by adding a service you want to monitor.')); ?>
</p>
                        <a href="<?php echo $this->_tpl_vars['m']['resources_monitoring']['add_url']; ?>
" class="dashboard-add-resource-secondary">Add your first resource</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "block_end.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
