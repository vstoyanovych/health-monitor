{assign var=m value=$modules[$index]}

<div class="col-md-12 box box-1 col-xs-12">
    <div class="wrapper">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="day">
                <div class="content-container">
                    <div style="width:100%;">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="canvas" style="display: block; width: 100%; height: 400px;"  class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="themes/{$special.theme}/chart/pie-chart.js"></script>
<script type="text/javascript" src="themes/{$special.theme}/chart/graph.js"></script>
<script type="text/javascript" src="themes/{$special.theme}/chart/graphchart.js"></script>

<script>
    var config = {ldelim}
        type: 'bar',
        data: {ldelim}
            labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
            datasets: [{ldelim}
                label: 'Views',
                backgroundColor: "#ff6666",
                borderColor: "#ff6666",
                fill: false,
                data: [{$m.views}],
                {rdelim}, {ldelim}
                label: '{$m.title_2}',
                backgroundColor: "#4dffa6",
                borderColor: "#4dffa6",
                fill: false,
                data: [{$m.time_spent}],
                {rdelim}]
            {rdelim},
        options: {ldelim}
            responsive: true,
            title: {ldelim}
                display: true,
                text: ''
                {rdelim},
            scales: {ldelim}
                xAxes: [{ldelim}
                    display: true,
                    scaleLabel: {ldelim}
                        display: true,
                        labelString: 'Month'
                        {rdelim},

                    {rdelim}],
                yAxes: [{ldelim}
                    display: true,
                    //type: 'logarithmic',
                    scaleLabel: {ldelim}
                        display: true,
                        labelString: 'Views'
                        {rdelim},
                    ticks: {ldelim}
                        min: 0,
                        max: {$m.max_value},

                        // forces step size to be 5 units
                        stepSize: {$m.max_value/5|ceil}
                        {rdelim}
                    {rdelim}]
                {rdelim}
            {rdelim}
        {rdelim};

    window.onload = function() {ldelim}
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myLine = new Chart(ctx, config);
        {rdelim};

    document.getElementById('randomizeData').addEventListener('click', function() {ldelim}
        config.data.datasets.forEach(function(dataset) {ldelim}
            dataset.data = dataset.data.map(function() {ldelim}
                return randomScalingFactor();
                {rdelim});

            {rdelim});

        window.myLine.update();
        {rdelim});
</script>