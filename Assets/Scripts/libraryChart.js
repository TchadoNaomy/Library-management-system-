document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('libraryChart').getContext('2d');
    
    // Get data from localStorage
    const chartData = JSON.parse(localStorage.getItem('libraryStats')) || [0, 0, 0];
    
    const libraryData = {
        labels: ['Total Users', 'Total Books', 'Books Borrowed'],
        datasets: [{
            label: 'Library Statistics',
            data: chartData,
            backgroundColor: [
                '#3498DB',  // Blue
                '#2C3E50',  // Dark Blue
                '#E74C3C'   // Red
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: libraryData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Library Statistics Overview',
                    font: {
                        size: 16
                    }
                }
            }
        }
    };

    new Chart(ctx, config);
});