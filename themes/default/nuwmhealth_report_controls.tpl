<form class="nuwmhealth-report-controls" method="get" action="index.php">
    <input type="hidden" name="m" value="nuwmhealth" />
    <input type="hidden" name="d" value="report" />
    <input type="hidden" name="ready" value="{$data.ready_filter}" />
    <input type="hidden" name="has_admin" value="{$data.admin_filter}" />
    <input type="hidden" name="ready_sort" value="{$data.ready_sort}" />
    <input type="hidden" name="group_by" value="{$data.group_by}" />

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
    </div>
</form>

