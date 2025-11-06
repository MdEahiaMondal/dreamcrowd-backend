/**
 * User Dashboard JavaScript
 * Handles AJAX requests, chart rendering, and dynamic updates
 */

// Global variables
let spendingTrendChart = null;
let statusBreakdownChart = null;
let isLoadingData = false;
let currentFilters = {
    preset: 'all_time',
    dateFrom: null,
    dateTo: null
};

// CSRF Token setup for AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * Load dashboard statistics with filters
 */
function loadDashboardStatistics(preset, dateFrom = null, dateTo = null) {
    // Prevent multiple simultaneous requests
    if (isLoadingData) {
        console.log('Already loading data, skipping request');
        return;
    }

    isLoadingData = true;
    showLoading();

    // Update current filters
    currentFilters.preset = preset || 'all_time';
    currentFilters.dateFrom = dateFrom;
    currentFilters.dateTo = dateTo;

    $.ajax({
        url: '/user/dashboard/statistics',
        method: 'POST',
        data: {
            date_preset: preset,
            date_from: dateFrom,
            date_to: dateTo
        },
        success: function(response) {
            if (response.success) {
                updateStatistics(response.data);
                // Load charts after a small delay to ensure DOM is ready
                setTimeout(function() {
                    loadCharts();
                }, 100);
            } else {
                showError('Failed to load statistics');
            }
        },
        error: function(xhr) {
            console.error('Error loading statistics:', xhr);
            showError('Error loading dashboard data');
        },
        complete: function() {
            hideLoading();
            isLoadingData = false;
        }
    });
}

/**
 * Update all statistics on the page
 */
function updateStatistics(data) {
    try {
        // Financial Statistics
        $('#stat-total-spent').text('$' + formatNumber(data.financial.total_spent));
        $('#stat-month-spent').text('$' + formatNumber(data.financial.month_spent));
        $('#stat-avg-order').text('$' + formatNumber(data.financial.avg_order_value));
        $('#stat-service-fees').text('$' + formatNumber(data.financial.total_service_fees));
        $('#stat-coupon-savings').text('$' + formatNumber(data.financial.total_coupon_savings));

        // Order Statistics
        $('#stat-total-orders').text(data.orders.total_orders);
        $('#stat-active-orders').text(data.orders.active_orders);
        $('#stat-pending-orders').text(data.orders.pending_orders);
        $('#stat-completed-orders').text(data.orders.completed_orders);
        $('#stat-cancelled-orders').text(data.orders.cancelled_orders);
        $('#stat-upcoming-classes').text(data.orders.upcoming_classes);

        // Engagement Statistics
        $('#stat-reviews-given').text(data.engagement.reviews_given);
        $('#stat-coupons-used').text(data.engagement.coupons_used);
        $('#stat-unique-sellers').text(data.engagement.unique_sellers);
        $('#stat-days-member').text(data.engagement.days_as_member);

        // Add animation effect
        $('.stat-value').addClass('stat-updated');
        setTimeout(() => $('.stat-value').removeClass('stat-updated'), 500);
    } catch (error) {
        console.error('Error updating statistics:', error);
    }
}

/**
 * Load all charts (with safeguards)
 */
function loadCharts() {
    // Only load if charts haven't been loaded in the last 2 seconds
    if (window.lastChartLoad && (Date.now() - window.lastChartLoad) < 2000) {
        console.log('Charts loaded recently, skipping');
        return;
    }

    window.lastChartLoad = Date.now();

    loadSpendingTrendChart();
    loadStatusBreakdownChart();
}

/**
 * Load spending trend chart
 */
function loadSpendingTrendChart() {
    $.ajax({
        url: '/user/dashboard/chart-data',
        method: 'GET',
        data: {
            chart_type: 'spending_trend',
            months: 6
        },
        success: function(response) {
            if (response.success) {
                renderSpendingTrendChart(response.data);
            }
        },
        error: function(xhr) {
            console.error('Error loading spending trend:', xhr);
        }
    });
}

/**
 * Load status breakdown chart
 */
function loadStatusBreakdownChart() {
    $.ajax({
        url: '/user/dashboard/chart-data',
        method: 'GET',
        data: {
            chart_type: 'status_breakdown',
            date_from: currentFilters.dateFrom,
            date_to: currentFilters.dateTo
        },
        success: function(response) {
            if (response.success) {
                renderStatusBreakdownChart(response.data);
            }
        },
        error: function(xhr) {
            console.error('Error loading status breakdown:', xhr);
        }
    });
}

/**
 * Render spending trend chart
 */
function renderSpendingTrendChart(data) {
    const ctx = document.getElementById('spendingTrendChart');
    if (!ctx) {
        console.error('Spending trend chart canvas not found');
        return;
    }

    try {
        // Destroy existing chart
        if (spendingTrendChart) {
            spendingTrendChart.destroy();
            spendingTrendChart = null;
        }

        // Get container dimensions with safety limits
        const containerWidth = Math.min(ctx.parentElement.offsetWidth || 600, 1200);
        const containerHeight = 300;

        // Set explicit canvas dimensions (capped at safe maximums)
        ctx.width = containerWidth;
        ctx.height = containerHeight;

        // Force canvas attributes
        ctx.setAttribute('width', containerWidth);
        ctx.setAttribute('height', containerHeight);

        spendingTrendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Spending ($)',
                    data: data.spent,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Spent: $' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toFixed(0);
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error rendering spending trend chart:', error);
    }
}

/**
 * Render status breakdown chart
 */
function renderStatusBreakdownChart(data) {
    const ctx = document.getElementById('statusBreakdownChart');
    if (!ctx) {
        console.error('Status breakdown chart canvas not found');
        return;
    }

    try {
        // Destroy existing chart
        if (statusBreakdownChart) {
            statusBreakdownChart.destroy();
            statusBreakdownChart = null;
        }

        // Get container dimensions with safety limits
        const containerWidth = Math.min(ctx.parentElement.offsetWidth || 300, 600);
        const containerHeight = 300;

        // Set explicit canvas dimensions (capped at safe maximums)
        ctx.width = containerWidth;
        ctx.height = containerHeight;

        // Force canvas attributes
        ctx.setAttribute('width', containerWidth);
        ctx.setAttribute('height', containerHeight);

        statusBreakdownChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: data.backgroundColor,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 11
                            },
                            padding: 10
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error rendering status breakdown chart:', error);
    }
}

/**
 * Apply custom date filter
 */
function applyCustomDateFilter() {
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();

    if (!dateFrom || !dateTo) {
        showError('Please select both start and end dates');
        return;
    }

    // Remove active class from preset buttons
    $('.filter-preset').removeClass('active');

    loadDashboardStatistics('custom', dateFrom, dateTo);
}

/**
 * Export dashboard to PDF
 */
function exportPDF() {
    showLoading();

    // Create a form and submit
    const form = $('<form>', {
        method: 'POST',
        action: '/user/dashboard/export/pdf'
    });

    form.append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: $('meta[name="csrf-token"]').attr('content')
    }));

    form.append($('<input>', {
        type: 'hidden',
        name: 'date_preset',
        value: currentFilters.preset
    }));

    if (currentFilters.dateFrom) {
        form.append($('<input>', {
            type: 'hidden',
            name: 'date_from',
            value: currentFilters.dateFrom
        }));
    }

    if (currentFilters.dateTo) {
        form.append($('<input>', {
            type: 'hidden',
            name: 'date_to',
            value: currentFilters.dateTo
        }));
    }

    form.appendTo('body').submit();

    setTimeout(() => {
        form.remove();
        hideLoading();
    }, 1000);
}

/**
 * Export dashboard to Excel
 */
function exportExcel() {
    showLoading();

    // Create a form and submit
    const form = $('<form>', {
        method: 'POST',
        action: '/user/dashboard/export/excel'
    });

    form.append($('<input>', {
        type: 'hidden',
        name: '_token',
        value: $('meta[name="csrf-token"]').attr('content')
    }));

    form.append($('<input>', {
        type: 'hidden',
        name: 'date_preset',
        value: currentFilters.preset
    }));

    if (currentFilters.dateFrom) {
        form.append($('<input>', {
            type: 'hidden',
            name: 'date_from',
            value: currentFilters.dateFrom
        }));
    }

    if (currentFilters.dateTo) {
        form.append($('<input>', {
            type: 'hidden',
            name: 'date_to',
            value: currentFilters.dateTo
        }));
    }

    form.appendTo('body').submit();

    setTimeout(() => {
        form.remove();
        hideLoading();
    }, 1000);
}

/**
 * Format number with commas
 */
function formatNumber(num) {
    return parseFloat(num).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

/**
 * Show loading overlay
 */
function showLoading() {
    $('#dashboardLoading').addClass('active');
}

/**
 * Hide loading overlay
 */
function hideLoading() {
    $('#dashboardLoading').removeClass('active');
}

/**
 * Show error message
 */
function showError(message) {
    alert(message);
}

/**
 * Show success message
 */
function showSuccess(message) {
    console.log('Success:', message);
}
