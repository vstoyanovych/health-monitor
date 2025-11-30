<div class="dashboard-resources-card resource-details-info">
	<h2 class="resource-details-title">{$data.service|escape}</h2>
	<div class="resource-details-grid">
		<div class="resource-details-field">
			<strong>URL:</strong><br>
			<a href="https://{$data.url|escape}" target="_blank" rel="noopener">https://{$data.url|escape}</a>
		</div>
		<div class="resource-details-field">
			<strong>Notification Email:</strong><br>
			{if $data.email neq ''}
				<a href="mailto:{$data.email|escape}">{$data.email|escape}</a>
			{else}
				—
			{/if}
		</div>
		<div class="resource-details-field">
			<strong>Added:</strong><br>
			{$data.added_time|escape}
		</div>
		<div class="resource-details-field">
			<strong>Last Checked:</strong><br>
			{$data.last_checked|escape}
		</div>
		<div class="resource-details-field">
			<strong>Current Status:</strong><br>
			<span class="resource-status-pill status-{$data.status.status|escape} resource-status-pill-small">{$data.status.label|escape}</span>
		</div>
		<div class="resource-details-field">
			<strong>Availability:</strong><br>
			{$data.availability_percent|escape}% ({$data.online_count|escape}/{$data.total_checks|escape} hours online)
		</div>
		{if isset($data.history) && $data.history|@count > 0}
			<div class="resource-details-field">
				<strong>Availability ({$data.period_label|escape})</strong><br>
				<div class="resource-availability-bar resource-availability-bar-large">
					{foreach from=$data.history item=segment_status}
						<span class="resource-availability-segment status-{$segment_status|escape}"></span>
					{/foreach}
				</div>
			</div>
		{/if}
	</div>
</div>

