<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
window.addEventListener('load', function() {ldelim}
	var canvas = document.getElementById('response-time-chart-{$data.resource_id|escape}');
	if (!canvas) return;
	if (typeof Chart === 'undefined') {ldelim}
		console.error('Chart.js not loaded');
		return;
	{rdelim}
	
	var dataScript = document.getElementById('chart-data-{$data.resource_id|escape}');
	if (!dataScript) {ldelim}
		console.error('Chart data script not found');
		return;
	{rdelim}
	
	var chartDataObj;
	try {ldelim}
		chartDataObj = JSON.parse(dataScript.textContent);
	{rdelim} catch (e) {ldelim}
		console.error('Error parsing chart data:', e);
		return;
	{rdelim}
	
	var chartData = {ldelim}
		labels: chartDataObj.labels,
		datasets: [{ldelim}
			label: 'Response Time (ms)',
			data: chartDataObj.data,
			borderColor: '#2563eb',
			backgroundColor: 'rgba(37, 99, 235, 0.1)',
			fill: true,
			tension: 0.4,
			pointRadius: 3,
			pointHoverRadius: 5
		{rdelim}]
	{rdelim};
	
	var ctx = canvas.getContext('2d');
	new Chart(ctx, {ldelim}
		type: 'line',
		data: chartData,
		options: {ldelim}
			responsive: true,
			maintainAspectRatio: false,
			scales: {ldelim}
				xAxes: [{ldelim}
					display: true,
					scaleLabel: {ldelim} display: true, labelString: '{$data.time_label|escape}' {rdelim}
				{rdelim}],
				yAxes: [{ldelim}
					display: true,
					scaleLabel: {ldelim} display: true, labelString: 'Response Time (ms)' {rdelim},
					ticks: {ldelim} beginAtZero: true {rdelim}
				{rdelim}]
			{rdelim},
			plugins: {ldelim}
				legend: {ldelim} display: true, position: 'top' {rdelim},
				tooltip: {ldelim}
					mode: 'index',
					intersect: false
				{rdelim}
			{rdelim}
		{rdelim}
	{rdelim});
{rdelim});
</script>
