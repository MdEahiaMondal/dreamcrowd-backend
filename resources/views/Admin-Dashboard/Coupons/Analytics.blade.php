<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Coupon Analytics</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/admin/asset/css/style.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .analytics-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .rank-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .top-coupon-item {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            transition: background 0.2s;
        }

        .top-coupon-item:hover {
            background: #f8f9fa;
        }

        .top-coupon-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

{{-- Admin Sidebar --}}
<x-admin-sidebar/>

<section class="home-section">
    {{-- Admin NavBar --}}
    <x-admin-nav/>

    <div class="container-fluid">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">

                    <!-- Breadcrumb -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dash-top">
                                <h1 class="dash-title">Dashboard</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <h1 class="dash-title">Coupon Management</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Analytics</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-chart-line" style="font-size: 40px; color: #007bff;"></i>
                                    <h2>Coupon Analytics & Insights</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left"></i> Back to Coupons
                        </a>
                    </div>

                    <div class="row">
                        <!-- Top 10 Most Used Coupons -->
                        <div class="col-md-6">
                            <div class="analytics-card">
                                <h5 style="margin-bottom: 20px;">
                                    <i class="fa-solid fa-trophy"></i> Top 10 Most Used Coupons
                                </h5>

                                @forelse($topCoupons as $index => $coupon)
                                    <div class="top-coupon-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="rank-badge"
                                                     style="background: {{ $index == 0 ? '#ffd700' : ($index == 1 ? '#c0c0c0' : ($index == 2 ? '#cd7f32' : 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)')) }};">
                                                    {{ $index + 1 }}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <strong style="font-size: 16px;">{{ $coupon->coupon_code }}</strong>
                                                <br>
                                                <small style="color: #666;">{{ $coupon->coupon_name }}</small>
                                            </div>
                                            <div class="col-auto text-end">
                                                <h4 style="margin: 0; color: #007bff;">{{ $coupon->usage_count }}</h4>
                                                <small style="color: #999;">uses</small>
                                                <br>
                                                <small style="color: #28a745; font-weight: bold;">
                                                    @currency($coupon->total_discount_given)
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center" style="padding: 40px 0; color: #999;">
                                        <i class="fa-solid fa-inbox" style="font-size: 48px;"></i>
                                        <p style="margin-top: 15px;">No coupon usage data available</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Recent Usage Activity -->
                        <div class="col-md-6">
                            <div class="analytics-card">
                                <h5 style="margin-bottom: 20px;">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Recent Coupon Usage
                                </h5>

                                <div style="max-height: 600px; overflow-y: auto;">
                                    @forelse($recentUsage as $usage)
                                        <div class="top-coupon-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                        <span
                                                            style="background: #f8f9fa; padding: 4px 10px; border-radius: 4px; font-family: 'Courier New', monospace; font-weight: bold; color: #007bff;">
                                                            {{ $usage->coupon_code }}
                                                        </span>
                                                    <br>
                                                    <small style="color: #666;">
                                                        by <strong>{{ $usage->buyer->name ?? 'N/A' }}</strong>
                                                    </small>
                                                    <br>
                                                    <small style="color: #999;">
                                                        {{ $usage->used_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                        <span style="color: #dc3545; font-weight: bold;">
                                                            -@currency($usage->discount_amount)
                                                        </span>
                                                    <br>
                                                    <small style="color: #666;">
                                                        on @currency($usage->original_amount)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center" style="padding: 40px 0; color: #999;">
                                            <i class="fa-solid fa-inbox" style="font-size: 48px;"></i>
                                            <p style="margin-top: 15px;">No recent usage activity</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Statistics Chart -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="analytics-card">
                                <h5 style="margin-bottom: 20px;">
                                    <i class="fa-solid fa-chart-area"></i> Monthly Coupon Usage & Discount Trends (Last
                                    12 Months)
                                </h5>

                                <canvas id="monthlyChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>
</section>

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script>
    // Sidebar script
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        // Function to toggle sidebar based on screen size
        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        // Call the function initially
        toggleSidebar();

        // Listen for resize events to adjust sidebar
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
<script>
    // Prepare monthly data
    const monthlyData = @json($monthlyStats);

    const labels = monthlyData.map(item => {
        const date = new Date(item.month + '-01');
        return date.toLocaleDateString('en-US', {month: 'short', year: 'numeric'});
    }).reverse();

    const usageData = monthlyData.map(item => item.count).reverse();
    const discountData = monthlyData.map(item => parseFloat(item.total_discount)).reverse();

    // Create chart
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Coupon Usage Count',
                    data: usageData,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    yAxisID: 'y',
                    tension: 0.4,
                },
                {
                    label: 'Total Discount ($)',
                    data: discountData,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    yAxisID: 'y1',
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Usage Count'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Discount Amount ($)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                },
            }
        }
    });
</script>
</body>
</html>
