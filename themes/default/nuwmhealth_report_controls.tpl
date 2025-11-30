<form class="nuwmhealth-report-controls" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="report" />
    <input type="hidden" name="ready" value="{$data.ready_filter}" />
    <input type="hidden" name="has_admin" value="{$data.admin_filter}" />
    <input type="hidden" name="ready_sort" value="{$data.ready_sort}" />
    <input type="hidden" name="group_by" value="{$data.group_by}" />
    <input type="hidden" name="admin_email" value="{$data.admin_email|escape}" />

    <label>
        <span>Sort by readiness</span>
        <select name="report_sort" class="form-control input-sm">
            <option value="desc"{if $data.report_sort eq 'desc'} selected{/if}>Highest readiness first</option>
            <option value="asc"{if $data.report_sort eq 'asc'} selected{/if}>Lowest readiness first</option>
        </select>
    </label>

    <div class="report-actions">
        <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        <a class="btn btn-success btn-sm" href="{$data.export_url|default:''}">Export CSV</a>
        <a class="btn btn-default btn-sm" href="index.php?m=nuwmhealth&d=report_export_pdf&ready={$data.ready_filter}&has_admin={$data.admin_filter}&ready_sort={$data.ready_sort}&group_by={$data.group_by}&report_sort={$data.report_sort}&admin_email={$data.admin_email|escape}">Export PDF</a>
    </div>
</form>

