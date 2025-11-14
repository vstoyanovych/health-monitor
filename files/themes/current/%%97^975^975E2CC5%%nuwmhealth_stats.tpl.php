<?php /* Smarty version 2.6.26, created on 2025-11-14 18:17:52
         compiled from nuwmhealth_stats.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'nuwmhealth_stats.tpl', 4, false),)), $this); ?>
<div class="nuwmhealth-stats">
    <div class="nuwmhealth-stat-card">
        <span class="label">Total pages</span>
        <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['total_pages'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Ready pages</span>
        <strong class="ready"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['ready_pages'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Missing content</span>
        <strong class="not-ready"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['not_ready_pages'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0) : number_format($_tmp, 0)); ?>
</strong>
    </div>
    <div class="nuwmhealth-stat-card">
        <span class="label">Website readiness</span>
        <strong class="ready"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['ready_percent'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 1) : number_format($_tmp, 1)); ?>
%</strong>
    </div>
</div>
