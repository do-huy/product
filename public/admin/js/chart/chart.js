$(function() {
    let ctx = document.getElementById("chart").getContext("2d");
    let chart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["2020/Q1", "2020/Q2", "2020/Q3", "2020/Q4"],
        datasets: [
            {
            label: "Gross volume ($)",
            backgroundColor: "#c20d5a",
            borderColor: "#c20d5a",
            data: [26900, 28700, 27300, 29200]
            }
        ]
    },
    options: {
        title: {
            text: "Gross Volume in 2020",
            display: true
        }
    }
    });
});

$(function() {
    const chartCanvas = document.getElementById('countries');
    const ctx = chartCanvas.getContext('2d');

    const chart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                label: 'Doanh thu',
                data: [100000, 200000, 300000, 400000]
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'top',
                },
            },
            layout: {
                padding: {
                    left: 50,
                    right: 50,
                    top: 50,
                    bottom: 50
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Đặt kích thước canvas bằng CSS
    chartCanvas.style.width = '400px';
    chartCanvas.style.height = '493px';
});












$(function() {
// document.addEventListener('DOMContentLoaded', function() {
    // Sample data for followers over time
    const timeLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
    const followersData = [100, 150, 200, 180, 250];

    const ctx = document.getElementById('followersChart').getContext('2d');

    const followersChart = new Chart(ctx, {
        type: 'bar', // Bar chart for followers count
        data: {
            labels: timeLabels,
            datasets: [{
                label: 'Followers',
                data: followersData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Creating a line chart for additional information (e.g., engagement)
    const engagementData = [20, 25, 30, 28, 35];

    followersChart.data.datasets.push({
        label: 'Engagement',
        data: engagementData,
        type: 'line',
        fill: false,
        borderColor: 'rgba(255, 99, 132, 1)',
        tension: 0.1
    });

    followersChart.update(); // Update the chart to display the new dataset
// });
});


$(function() {
    // document.addEventListener('DOMContentLoaded', function() {
        // Sample data for followers over time
        const timeLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        const followersData = [100, 150, 200, 180, 250];

        const ctx = document.getElementById('followersChart2').getContext('2d');

        const followersChart = new Chart(ctx, {
            type: 'bar', // Bar chart for followers count
            data: {
                labels: timeLabels,
                datasets: [{
                    label: 'Followers',
                    data: followersData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Creating a line chart for additional information (e.g., engagement)
        const engagementData = [20, 25, 30, 28, 35];

        followersChart.data.datasets.push({
            label: 'Engagement',
            data: engagementData,
            type: 'line',
            fill: false,
            borderColor: 'rgba(255, 99, 132, 1)',
            tension: 0.1
        });

        followersChart.update(); // Update the chart to display the new dataset
    // });
    });


    $(function() {
        // document.addEventListener('DOMContentLoaded', function() {
            // Sample data for followers over time
            const timeLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
            const followersData = [100, 150, 200, 180, 250];

            const ctx = document.getElementById('followersChart3').getContext('2d');

            const followersChart = new Chart(ctx, {
                type: 'bar', // Bar chart for followers count
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: 'Followers',
                        data: followersData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Creating a line chart for additional information (e.g., engagement)
            const engagementData = [20, 25, 30, 28, 35];

            followersChart.data.datasets.push({
                label: 'Engagement',
                data: engagementData,
                type: 'line',
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.1
            });

            followersChart.update(); // Update the chart to display the new dataset
        // });
        });



    $(function() {
        // document.addEventListener('DOMContentLoaded', function() {
            // Sample data for followers over time
            const timeLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
            const followersData = [100, 150, 200, 180, 250];

            const ctx = document.getElementById('followersChart4').getContext('2d');

            const followersChart = new Chart(ctx, {
                type: 'bar', // Bar chart for followers count
                data: {
                    labels: timeLabels,
                    datasets: [{
                        label: 'Followers',
                        data: followersData,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Creating a line chart for additional information (e.g., engagement)
            const engagementData = [20, 25, 30, 28, 35];

            followersChart.data.datasets.push({
                label: 'Engagement',
                data: engagementData,
                type: 'line',
                fill: false,
                borderColor: 'rgba(255, 99, 132, 1)',
                tension: 0.1
            });

            followersChart.update(); // Update the chart to display the new dataset
        // });
        });


