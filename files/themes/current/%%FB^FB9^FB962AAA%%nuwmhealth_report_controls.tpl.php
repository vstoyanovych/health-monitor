<?php /* Smarty version 2.6.26, created on 2025-11-15 19:52:29
         compiled from nuwmhealth_report_controls.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'nuwmhealth_report_controls.tpl', 8, false),array('modifier', 'default', 'nuwmhealth_report_controls.tpl', 20, false),)), $this); ?>
<form class="nuwmhealth-report-controls" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="report" />
    <input type="hidden" name="ready" value="<?php echo $this->_tpl_vars['data']['ready_filter']; ?>
" />
    <input type="hidden" name="has_admin" value="<?php echo $this->_tpl_vars['data']['admin_filter']; ?>
" />
    <input type="hidden" name="ready_sort" value="<?php echo $this->_tpl_vars['data']['ready_sort']; ?>
" />
    <input type="hidden" name="group_by" value="<?php echo $this->_tpl_vars['data']['group_by']; ?>
" />
    <input type="hidden" name="admin_email" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['admin_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />

    <label>
        <span>Sort by readiness</span>
        <select name="report_sort" class="form-control input-sm">
            <option value="desc"<?php if ($this->_tpl_vars['data']['report_sort'] == 'desc'): ?> selected<?php endif; ?>>Highest readiness first</option>
            <option value="asc"<?php if ($this->_tpl_vars['data']['report_sort'] == 'asc'): ?> selected<?php endif; ?>>Lowest readiness first</option>
        </select>
    </label>

    <div class="report-actions">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        <a class="btn btn-success btn-sm" href="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['export_url'])) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
">Export CSV</a>
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d=report_export_pdf&ready=<?php echo $this->_tpl_vars['data']['ready_filter']; ?>
&has_admin=<?php echo $this->_tpl_vars['data']['admin_filter']; ?>
&ready_sort=<?php echo $this->_tpl_vars['data']['ready_sort']; ?>
&group_by=<?php echo $this->_tpl_vars['data']['group_by']; ?>
&report_sort=<?php echo $this->_tpl_vars['data']['report_sort']; ?>
&admin_email=<?php echo ((is_array($_tmp=$this->_tpl_vars['data']['admin_email'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
">Export PDF</a>
    </div>
</form>
