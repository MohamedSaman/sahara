<script>
    // Prepare brand sales data from PHP
    const brandLabels = @json(collect($brandSales)->pluck('brand'));
    const brandTotals = @json(collect($brandSales)->pluck('total_sales'));

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize chart
        const ctx = document.getElementById('salesChart').getContext('2d');
        let chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: brandLabels,
                datasets: [{
                    label: 'Sales by Brand',
                    backgroundColor: '#007bff',
                    borderColor: '#007bff',
                    borderWidth: 1,
                    data: brandTotals
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { 
                        enabled: true,
                        displayColors: false,
                        bodyFont: {
                            size: window.innerWidth < 768 ? 12 : 14
                        },
                        titleFont: {
                            size: window.innerWidth < 768 ? 12 : 14
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#dee2e6' },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: window.innerWidth < 768 ? 10 : 12
                            }
                        }
                    }
                }
            }
        });
        
        // Handle window resize for better chart responsiveness
        window.addEventListener('resize', function() {
            if (chartInstance) {
                // Update font sizes based on screen width
                chartInstance.options.plugins.tooltip.bodyFont.size = window.innerWidth < 768 ? 12 : 14;
                chartInstance.options.plugins.tooltip.titleFont.size = window.innerWidth < 768 ? 12 : 14;
                chartInstance.options.scales.y.ticks.font.size = window.innerWidth < 768 ? 10 : 12;
                chartInstance.options.scales.x.ticks.font.size = window.innerWidth < 768 ? 10 : 12;
                chartInstance.update();
            }
        });
    });

  
</script>