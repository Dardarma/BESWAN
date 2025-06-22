<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Level Statistics</title>
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
            height: 90vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        canvas {
            display: block;
            max-width: 100%!important;
            max-height: 100% !important;
        }

        .chart-title {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="chart-container">
        <canvas id="donut-chart"></canvas>
    </div>

    <script>
        // Parse data from controller
        const labels = {!! $labels !!};
        let values = {!! $values !!};
        const colors = {!! $colors !!};
        
        // Ensure all values are integers
        values = values.map(v => parseInt(v, 10));
        
        console.log('Labels:', labels);
        console.log('Values:', values);
        console.log('Colors:', colors);

        const ctx = document.getElementById('donut-chart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah User',
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors.map(color => color), // Same as background for cleaner look
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '60%', // Creates the donut hole (60% of radius)
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.parsed;
                                const percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': ' + value + ' user (' + percentage + '%)';
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    datalabels: {
                        display: true,
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: function(value, context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return percentage + '%';
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1000
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
</body>

</html>
