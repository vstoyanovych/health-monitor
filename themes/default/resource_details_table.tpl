<div class="dashboard-resources-card resource-details-table">
	<h3 class="resource-details-section-title">Recent Checks</h3>
	{if $data.logs|@count > 0}
		<table class="table resource-checks-table">
			<thead>
				<tr>
					<th>Time</th>
					<th>Status</th>
					<th>Response Time</th>
					<th>IP Address</th>
					<th>Error</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$data.logs item=log}
					<tr>
						<td>{$log.time|escape}</td>
						<td>
							<span class="resource-status-pill status-{$log.status|escape}">{$log.status_label|escape}</span>
						</td>
						<td>{$log.response_time|escape}</td>
						<td>{$log.ip|escape}</td>
						<td>
							{if $log.error neq ''}
								<span class="resource-error-text">{$log.error|escape}</span>
							{else}
								—
							{/if}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		<p class="resource-no-checks">No checks recorded yet.</p>
	{/if}
</div>

