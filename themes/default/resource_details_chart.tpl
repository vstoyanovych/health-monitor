<div class="dashboard-resources-card resource-details-chart">
	<h3 class="resource-details-section-title">Response Time ({$data.period_label|escape})</h3>
	<div class="resource-chart-container">
		<canvas id="response-time-chart-{$data.resource_id|escape}"></canvas>
	</div>
	<script type="application/json" id="chart-data-{$data.resource_id|escape}">
		{$data.chart_data_json}
	</script>
</div>

