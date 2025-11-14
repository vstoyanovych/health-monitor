<div class="nuwmhealth-groups">
    {if $data.groups|@count == 0}
        <div class="nuwmhealth-group-card">
            <div class="nuwmhealth-group-header">
                <strong>No pages in this selection</strong>
            </div>
        </div>
    {else}
        {foreach from=$data.groups item=group}
            <div class="nuwmhealth-group-card">
                <div class="nuwmhealth-group-header">
                    <div>
                        <strong>
                            {if $group.admin_email neq ''}
                                <a href="mailto:{$group.admin_email|escape}" class="admin-link">{$group.admin_label|escape}</a>
                            {else}
                                {$group.admin_label|escape}
                            {/if}
                        </strong>
                        <span>{$group.items|@count} pages</span>
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
                        {foreach from=$group.items item=item}
                            <tr>
                                <td>{$item.title|escape}</td>
                                <td>
                                    {if $item.url neq ''}
                                        <a href="{$item.url|escape}" target="_blank" rel="noopener">{$item.url|escape}</a>
                                    {else}
                                        —
                                    {/if}
                                </td>
                                <td class="text-center">
                                    {if $item.ready}
                                        <span class="nuwmhealth-status-pill status-ready">Ready</span>
                                    {else}
                                        <span class="nuwmhealth-status-pill status-not-ready">Missing</span>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
        {/foreach}
    {/if}
</div>

