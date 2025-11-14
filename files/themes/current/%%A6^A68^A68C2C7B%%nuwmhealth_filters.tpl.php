<?php /* Smarty version 2.6.26, created on 2025-11-14 18:34:10
         compiled from nuwmhealth_filters.tpl */ ?>
<form class="nuwmhealth-filters" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="list" />

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
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d=list">Reset</a>
        <a class="btn btn-success btn-sm" href="index.php?m=nuwmhealth&d=export&ready=<?php echo $this->_tpl_vars['data']['ready_filter']; ?>
&has_admin=<?php echo $this->_tpl_vars['data']['admin_filter']; ?>
&ready_sort=<?php echo $this->_tpl_vars['data']['ready_sort']; ?>
&group_by=<?php echo $this->_tpl_vars['data']['group_by']; ?>
">Export CSV</a>
    </div>
</form>
