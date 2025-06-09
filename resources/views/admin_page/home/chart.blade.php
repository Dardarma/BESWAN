<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Statistics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .chart-container {
            height: 250px;
            position: relative;
        }

        canvas {
            display: block;
            width: 95% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>
    <div class="chart-container">
        <canvas id="bar-chart"></canvas>
    </div>

    <script>
        // Parse labels and values as JSON
        const labels = {!! $labels !!};
        let values = {!! $values !!};
        // Ensure all values are integers
        values = values.map(v => parseInt(v, 10));
        console.log(labels);
        const ctx = document.getElementById('bar-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'User',
                    data: values, // Data as integer array
                    backgroundColor: '#3c8dbc',
                    borderColor: '#3c8dbc',
                    borderWidth: 1,
                    borderRadius: 10 // bar melengkung
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            // Show only integer ticks
                            callback: function(value) {
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            },
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                // Show integer value in tooltip
                                return context.dataset.label + ': ' + parseInt(context.parsed.y, 10);
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>
