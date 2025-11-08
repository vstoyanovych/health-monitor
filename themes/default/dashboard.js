/**
 * Dashboard JavaScript
 */

// Apply dynamic colors to action icons
document.addEventListener('DOMContentLoaded', function() {
    var icons = document.querySelectorAll('.action-icon[data-color]');
    icons.forEach(function(icon) {
        icon.style.color = icon.getAttribute('data-color');
    });
    
    // Auto-load Google Ads earnings if widget is present
    var googleAdsWidget = document.getElementById('google-ads-widget');
    if (googleAdsWidget) {
        var ajaxUrl = googleAdsWidget.getAttribute('data-ajax-url');
        if (ajaxUrl) {
            loadGoogleAdsEarnings(ajaxUrl);
        }
    }
});

/**
 * Initialize dashboard chart
 */
window.addEventListener('load', function() {
    var canvas = document.getElementById('canvas');
    if (!canvas) return;
    
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js library not loaded');
        return;
    }
    
    // Parse data attributes - they come as comma-separated values wrapped in brackets
    var labelsStr = canvas.getAttribute('data-labels') || '[]';
    var viewsStr = canvas.getAttribute('data-views') || '[]';
    var pagesStr = canvas.getAttribute('data-pages') || '[]';
    
    var labels, views, pages;
    try {
        labels = JSON.parse(labelsStr);
        views = JSON.parse(viewsStr);
        pages = JSON.parse(pagesStr);
    } catch (e) {
        console.error('Error parsing chart data:', e);
        labels = [];
        views = [];
        pages = [];
    }
    
    var maxValue = parseInt(canvas.getAttribute('data-max-value') || '10');
    var timeLabel = canvas.getAttribute('data-time-label') || '';
    
    // Debug output
    console.log('Dashboard Chart Data:', {
        labels: labels,
        views: views,
        pages: pages,
        maxValue: maxValue,
        timeLabel: timeLabel
    });
    
    var config = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Views',
                    backgroundColor: "#1a73e8",
                    borderColor: "#1a73e8",
                    fill: false,
                    pointStyle: 'line',
                    tension: 0.5,
                    data: views,
                },
                {
                    label: 'Pages',
                    backgroundColor: "#d76d42",
                    borderColor: "#d76d42",
                    fill: false,
                    pointStyle: 'line',
                    tension: 0.5,
                    data: pages,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
            },
            plugins: {
                legend: {
                    labels: {
                        boxHeight: 1,
                    },
                },
                tooltip: {
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    backgroundColor: '#fff',
                    titleColor: '#3C3C4399',
                    titleMarginBottom: 10,
                    titleFont: {
                        size: 16
                    },
                    bodyColor: '#F93A3D',
                    bodyFont: {
                        size: 20,
                    },
                    footerColor: '#F93A3D',
                    padding: 15,
                    caretPadding: 10,
                },
            },
            title: {
                display: true,
                text: ''
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: timeLabel
                    },
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Views'
                    },
                    ticks: {
                        min: 0,
                        max: maxValue,
                        stepSize: Math.ceil(maxValue / 5)
                    }
                }]
            }
        }
    };
    
    var ctx = canvas.getContext('2d');
    window.myLine = new Chart(ctx, config);
    
    // Handle randomize data button if exists
    var randomizeBtn = document.getElementById('randomizeData');
    if (randomizeBtn) {
        randomizeBtn.addEventListener('click', function() {
            config.data.datasets.forEach(function(dataset) {
                dataset.data = dataset.data.map(function() {
                    return randomScalingFactor();
                });
            });
            window.myLine.update();
        });
    }
});

/**
 * Load Google Ads earnings via AJAX
 */
function loadGoogleAdsEarnings(ajaxUrl) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', ajaxUrl, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                
                if (response.success && response.configured) {
                    // Update the stats with real data
                    document.getElementById('ads-today').textContent = response.data.today;
                    document.getElementById('ads-yesterday').textContent = response.data.yesterday;
                    document.getElementById('ads-month').textContent = response.data.month;
                } else if (!response.configured) {
                    // Not configured
                    document.getElementById('google-ads-stats').classList.add('google-ads-error-hidden');
                    document.getElementById('google-ads-error').classList.remove('google-ads-error-hidden');
                    document.getElementById('google-ads-error-message').textContent = 'Not configured';
                } else {
                    // Error occurred
                    document.getElementById('google-ads-stats').classList.add('google-ads-error-hidden');
                    document.getElementById('google-ads-error').classList.remove('google-ads-error-hidden');
                    document.getElementById('google-ads-error-message').textContent = response.error || 'Unknown error';
                }
            } catch (e) {
                // JSON parse error
                document.getElementById('google-ads-stats').classList.add('google-ads-error-hidden');
                document.getElementById('google-ads-error').classList.remove('google-ads-error-hidden');
                document.getElementById('google-ads-error-message').textContent = 'Failed to parse response';
            }
        } else {
            // HTTP error
            document.getElementById('google-ads-stats').classList.add('google-ads-error-hidden');
            document.getElementById('google-ads-error').classList.remove('google-ads-error-hidden');
            document.getElementById('google-ads-error-message').textContent = 'HTTP Error: ' + xhr.status;
        }
    };
    xhr.onerror = function() {
        document.getElementById('google-ads-stats').classList.add('google-ads-error-hidden');
        document.getElementById('google-ads-error').classList.remove('google-ads-error-hidden');
        document.getElementById('google-ads-error-message').textContent = 'Network error';
    };
    xhr.send();
}

