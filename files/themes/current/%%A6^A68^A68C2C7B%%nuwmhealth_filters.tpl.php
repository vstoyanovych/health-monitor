<?php /* Smarty version 2.6.26, created on 2025-11-14 19:18:41
         compiled from nuwmhealth_filters.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'nuwmhealth_filters.tpl', 3, false),)), $this); ?>
<form class="nuwmhealth-filters" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('default', true, $_tmp, 'list') : smarty_modifier_default($_tmp, 'list')); ?>
" />

    <label>
        <span>Status</span>
        <select name="ready" class="form-control input-sm">
            <option value="all"<?php if ($this->_tpl_vars['data']['ready_filter'] == 'all'): ?> selected<?php endif; ?>>All pages</option>
            <option value="ready"<?php if ($this->_tpl_vars['data']['ready_filter'] == 'ready'): ?> selected<?php endif; ?>>Ready only</option>
            <option value="missing"<?php if ($this->_tpl_vars['data']['ready_filter'] == 'missing'): ?> selected<?php endif; ?>>Missing content</option>
        </select>
    </label>

    <label>
        <span>Admin</span>
        <select name="has_admin" class="form-control input-sm">
            <option value="all"<?php if ($this->_tpl_vars['data']['admin_filter'] == 'all'): ?> selected<?php endif; ?>>Any</option>
            <option value="assigned"<?php if ($this->_tpl_vars['data']['admin_filter'] == 'assigned'): ?> selected<?php endif; ?>>Has admin</option>
            <option value="unassigned"<?php if ($this->_tpl_vars['data']['admin_filter'] == 'unassigned'): ?> selected<?php endif; ?>>No admin</option>
        </select>
    </label>

    <label>
        <span>Ready order</span>
        <select name="ready_sort" class="form-control input-sm">
            <option value="id"<?php if ($this->_tpl_vars['data']['ready_sort'] == 'id'): ?> selected<?php endif; ?>>Default (by ID)</option>
            <option value="desc"<?php if ($this->_tpl_vars['data']['ready_sort'] == 'desc'): ?> selected<?php endif; ?>>Ready first</option>
            <option value="asc"<?php if ($this->_tpl_vars['data']['ready_sort'] == 'asc'): ?> selected<?php endif; ?>>Missing first</option>
        </select>
    </label>

    <label>
        <span>Group by</span>
        <select name="group_by" class="form-control input-sm">
            <option value="none"<?php if ($this->_tpl_vars['data']['group_by'] == 'none'): ?> selected<?php endif; ?>>None</option>
            <option value="admin"<?php if ($this->_tpl_vars['data']['group_by'] == 'admin'): ?> selected<?php endif; ?>>Admin</option>
        </select>
    </label>

    <div class="filter-actions">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d=<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['action'])) ? $this->_run_mod_handler('default', true, $_tmp, 'list') : smarty_modifier_default($_tmp, 'list')); ?>
">Reset</a>
        <a class="btn btn-success btn-sm" href="index.php?m=nuwmhealth&d=<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['export_action'])) ? $this->_run_mod_handler('default', true, $_tmp, 'export') : smarty_modifier_default($_tmp, 'export')); ?>
&ready=<?php echo $this->_tpl_vars['data']['ready_filter']; ?>
&has_admin=<?php echo $this->_tpl_vars['data']['admin_filter']; ?>
&ready_sort=<?php echo $this->_tpl_vars['data']['ready_sort']; ?>
&group_by=<?php echo $this->_tpl_vars['data']['group_by']; ?>
&report_sort=<?php echo ((is_array($_tmp=@$this->_tpl_vars['data']['report_sort'])) ? $this->_run_mod_handler('default', true, $_tmp, 'desc') : smarty_modifier_default($_tmp, 'desc')); ?>
">Export CSV</a>

        <a class="btn btn-warning btn-sm" href="<?php echo $this->_tpl_vars['data']['report_link']; ?>
">Admin Report</a>
    </div>
</form>
