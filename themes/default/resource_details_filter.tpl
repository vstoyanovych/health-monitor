<div class="dashboard-resources-card resource-details-filter">
	<h3 class="resource-details-section-title">Period Filter</h3>
	<form method="get" action="index.php" class="resource-period-filter-form">
		<input type="hidden" name="m" value="resources">
		<input type="hidden" name="d" value="details">
		<input type="hidden" name="id" value="{$data.resource_id|escape}">
		<div class="resource-filter-field">
			<label class="resource-filter-label">Start Date</label>
			<input type="date" name="period_start" value="{$data.period_start|escape}" class="resource-filter-input">
		</div>
		<div class="resource-filter-field">
			<label class="resource-filter-label">End Date</label>
			<input type="date" name="period_end" value="{$data.period_end|escape}" class="resource-filter-input">
		</div>
		<button type="submit" class="resource-filter-button">Apply</button>
		<a href="index.php?m=resources&d=details&id={$data.resource_id|escape}" class="resource-filter-reset">Reset</a>
	</form>
</div>

