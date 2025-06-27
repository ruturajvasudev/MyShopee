<?php
include('includes/admin_navbar.php');
include('includes/admin_leftbar.php');
include('linking.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(7, 188, 243, 0.1);
        }

        .chart-container {
            margin-top: 20px;
        }.chart-container {
    width: 1000px; /* Set desired width */
    height: 1000px; /* Set desired height */
    margin: auto; /* Center the chart */
    position: relative;
}

    </style>
</head>

<body>
    <div class="main-content">
        <h1 style="text-align:center;"><br>Sales Insights</h1>
        <button class="btn btn-primary" id="downloadReport">Download Report</button>

        <!-- Charts -->
        <div class="chart-container row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Category-wise Sales</h5>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5>Monthly Sales</h5>
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                const categoryData = data.categorySales.map(item => item.total_sales);
                const categoryLabels = data.categorySales.map(item => item.category);
                const monthlyData = data.monthlySales.map(item => item.total_sales);
                const monthlyLabels = data.monthlySales.map(item => `Month ${item.month}`);

                // Render Category-wise Donut Chart
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryData,
                            backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1'],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        },
                        cutout: '70%' // Makes it a donut chart
                    }
                });

                // Render Monthly Stylish Bar Chart
                const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'Sales (₹)',
                            data: monthlyData,
                            backgroundColor: 'rgba(0, 123, 255, 0.8)',
                            hoverBackgroundColor: 'rgba(0, 123, 255, 1)',
                            borderRadius: 10
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                grid: {
                                    borderDash: [5, 5]
                                }
                            }
                        }
                    }
                });
            });

        // Download Report
        document.getElementById('downloadReport').addEventListener('click', () => {
            fetch('fetch_data.php')
                .then(response => response.json())
                .then(data => {
                    const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'sales_report.json';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                });
        });
    </script>
</body>

</html>
