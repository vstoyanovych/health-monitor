{assign var=m value=$modules[$index]}
{if $modules[$index].mode eq 'view'}
	{include file="block_begin.tpl" panel_title=" "}
    {if $m.error_message neq ""}
        <div class="aui-message aui-message-error">{$m.error_message}</div>
    {/if}

    <div class="dashboard-resources-container">
        <div class="dashboard-resources-card">
            <div class="resources-header">
                <div class="resources-title-group">
                    <h2>Monitored Resources</h2>
                    <p class="resources-subtitle">Track availability and response of your critical services in real time.</p>
                </div>
                <a href="{$m.resources_monitoring.add_url}" class="dashboard-add-resource-btn">
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
                {if $m.resources_monitoring.items|@count > 0}
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
                            {foreach from=$m.resources_monitoring.items item=resource}
                                <tr>
                                    <td class="resource-name">
                                        <div class="resource-service-name">{$resource.service|escape}</div>
                                        {if $resource.url != ''}
                                            <div class="resource-url">
                                                <a href="{$resource.url|escape}" target="_blank" rel="noopener">{$resource.url|escape}</a>
                                            </div>
                                        {/if}
                                    </td>
                                    <td>{$resource.department|default:'—'|escape}</td>
                                    <td>
                                        <span class="resource-status-pill {$resource.status_class|escape}">
                                            {$resource.status|escape}
                                        </span>
                                        {if $resource.status_last_checked ne ''}
                                            <div class="resource-status-meta">
                                                Last checked {$resource.status_last_checked|escape}
                                            </div>
                                        {/if}
                                    </td>
                                    <td>
                                        <div class="resource-availability-bar">
                                            {foreach from=$resource.history_segments item=segment}
                                                <span class="resource-availability-segment status-{$segment|escape}"></span>
                                            {/foreach}
                                        </div>
                                    </td>
                                </tr>
                            {/foreach}
                        </tbody>
                    </table>
                {else}
                    <div class="dashboard-resources-empty">
                        <h3>No resources yet</h3>
                        <p>{$m.resources_monitoring.empty_message|default:'Start by adding a service you want to monitor.'}</p>
                        <a href="{$m.resources_monitoring.add_url}" class="dashboard-add-resource-secondary">Add your first resource</a>
                    </div>
                {/if}
            </div>
        </div>
    </div>

    {include file="block_end.tpl"}
{/if}

