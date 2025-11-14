

<div class="nuwmhealth-admin-report">
    <div class="nuwmhealth-admin-report-header">
        <div>
            <strong>Admin readiness report</strong>
            <span>Reflects current filters</span>
        </div>
        {if $data.overall.total > 0}
            <div class="overall-pill">
                Overall readiness: {$data.overall.ready_percent|number_format:1}%
            </div>
        {/if}
    </div>

    {if $data.report|@count == 0}
        <div class="text-muted">No pages match the applied filters.</div>
    {else}
        <table class="table table-striped table-condensed nuwmhealth-admin-report-table">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Ready</th>
                    <th class="text-center">Missing</th>
                    <th class="text-center">Ready %</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$data.report item=row}
                    <tr>
                        <td>
                            {if $row.admin_email neq ''}
                                <a href="mailto:{$row.admin_email|escape}" class="admin-link">{$row.admin_label|escape}</a>
                            {else}
                                {$row.admin_label|escape}
                            {/if}
                        </td>
                        <td class="text-center">{$row.total}</td>
                        <td class="text-center text-success">{$row.ready}</td>
                        <td class="text-center text-danger">{$row.missing}</td>
                        <td class="text-center">
                            {if $row.total > 0}
                                {$row.ready_percent|number_format:1}%
                            {else}
                                —
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
            <tfoot>
                <tr class="overall-row">
                    <th>All admins</th>
                    <th class="text-center">{$data.overall.total}</th>
                    <th class="text-center text-success">{$data.overall.ready}</th>
                    <th class="text-center text-danger">{$data.overall.missing}</th>
                    <th class="text-center">
                        {if $data.overall.total > 0}
                            {$data.overall.ready_percent|number_format:1}%
                        {else}
                            —
                        {/if}
                    </th>
                </tr>
            </tfoot>
        </table>
    {/if}
</div>

