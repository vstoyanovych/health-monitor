<form class="nuwmhealth-filters" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="{$data.action|default:'list'}" />

    <label>
        <span>Status</span>
        <select name="ready" class="form-control input-sm">
            <option value="all"{if $data.ready_filter eq 'all'} selected{/if}>All pages</option>
            <option value="ready"{if $data.ready_filter eq 'ready'} selected{/if}>Ready only</option>
            <option value="missing"{if $data.ready_filter eq 'missing'} selected{/if}>Missing content</option>
        </select>
    </label>

    <label>
        <span>Admin</span>
        <select name="has_admin" class="form-control input-sm">
            <option value="all"{if $data.admin_filter eq 'all'} selected{/if}>Any</option>
            <option value="assigned"{if $data.admin_filter eq 'assigned'} selected{/if}>Has admin</option>
            <option value="unassigned"{if $data.admin_filter eq 'unassigned'} selected{/if}>No admin</option>
        </select>
    </label>

    <label>
        <span>Admin email</span>
        <input type="text" name="admin_email" class="form-control input-sm" value="{$data.admin_email|escape}">
    </label>

    <label>
        <span>Ready order</span>
        <select name="ready_sort" class="form-control input-sm">
            <option value="id"{if $data.ready_sort eq 'id'} selected{/if}>Default (by ID)</option>
            <option value="desc"{if $data.ready_sort eq 'desc'} selected{/if}>Ready first</option>
            <option value="asc"{if $data.ready_sort eq 'asc'} selected{/if}>Missing first</option>
        </select>
    </label>

    <label>
        <span>Group by</span>
        <select name="group_by" class="form-control input-sm">
            <option value="none"{if $data.group_by eq 'none'} selected{/if}>None</option>
            <option value="admin"{if $data.group_by eq 'admin'} selected{/if}>Admin</option>
        </select>
    </label>

    <div class="filter-actions">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d={$data.action|default:'list'}">Reset</a>
        <a class="btn btn-success btn-sm" href="index.php?m=nuwmhealth&d={$data.export_action|default:'export'}&ready={$data.ready_filter}&has_admin={$data.admin_filter}&ready_sort={$data.ready_sort}&group_by={$data.group_by}&report_sort={$data.report_sort|default:'desc'}&admin_email={$data.admin_email|escape}">Export CSV</a>
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d={$data.pdf_action|default:'export_pdf'}&ready={$data.ready_filter}&has_admin={$data.admin_filter}&ready_sort={$data.ready_sort}&group_by={$data.group_by}&report_sort={$data.report_sort|default:'desc'}&admin_email={$data.admin_email|escape}">Export PDF</a>
        <a class="btn btn-warning btn-sm" href="{$data.report_link}">Admin Report</a>
    </div>
</form>

