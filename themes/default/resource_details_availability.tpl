<div class="dashboard-resources-card resource-details-availability">
	<h3 class="resource-details-section-title">Availability ({$data.period_label|escape})</h3>
	<div class="resource-availability-bar resource-availability-bar-large">
		{foreach from=$data.history item=segment_status}
			<span class="resource-availability-segment status-{$segment_status|escape}"></span>
		{/foreach}
	</div>
	<div class="resource-availability-dates">
		<span>{$data.start_date|escape}</span>
		<span>{$data.end_date|escape}</span>
	</div>
</div>

