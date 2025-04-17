// this script handles the chart and the filtering logic


document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const filterBtn = document.getElementById('filterData');
    let libraryChart;

    // Initialize chart with current data
    const countElements = document.querySelectorAll('.count');
    createChart(Array.from(countElements).map(el => parseInt(el.textContent)));

    // Handle filter button click
    filterBtn.addEventListener('click', function() {
        fetchFilteredData(startDate.value, endDate.value);
    });

    function fetchFilteredData(start, end) {
        fetch(`../../Backend/Admin/getFilteredStats.php?startDate=${start}&endDate=${end}`)
            .then(response => response.json())
            .then(data => {
                // Update statistics cards
                document.querySelectorAll('.stat-card').forEach(card => {
                    const type = card.querySelector('h3').textContent.toLowerCase();
                    if (type.includes('users')) {
                        card.querySelector('.count').textContent = data.users;
                    } else if (type.includes('books') && !type.includes('borrowed')) {
                        card.querySelector('.count').textContent = data.books;
                    } else if (type.includes('borrowed')) {
                        card.querySelector('.count').textContent = data.borrowed;
                    }
                });

                // Update chart
                updateChart([data.users, data.books, data.borrowed]);
            })
            .catch(error => console.error('Error:', error));
    }

    function createChart(initialData) {
        const ctx = document.getElementById('libraryChart').getContext('2d');
        libraryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Users', 'Books', 'Borrowed Books'],
                datasets: [{
                    data: initialData,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function updateChart(newData) {
        libraryChart.data.datasets[0].data = newData;
        libraryChart.update();
    }
});