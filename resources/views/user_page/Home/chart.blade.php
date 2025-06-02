{{-- resources/views/components/chart-v3.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chart v3</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
    </style>

</head>

<body>
    <canvas id="bar-chart"></canvas>
    <script>
        const ctx = document.getElementById('bar-chart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! $labels !!},
                datasets: [{
                    label: 'Activity',
                    data: {!! $values !!}, // Raw data values
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
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '%';
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
