<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/sallermangement.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/seller-table.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <title>Super Admin Dashboard | Analytics</title>
    <style>
        .analytics-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-card.success { background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); }
        .stat-card.warning { background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); }
        .stat-card.danger { background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%); }
        .stat-card.info { background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%); }
        .stat-value { font-size: 32px; font-weight: bold; }
        .stat-label { font-size: 14px; opacity: 0.9; margin-top: 5px; }
        .chart-container { position: relative; height: 300px; margin: 20px 0; }
        .top-seller-item { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid #eee; }
        .top-seller-item:last-child { border-bottom: none; }
    </style>
  </head>
  <body>
    <!-- ========== Sidebar Section Start ========== -->
    @include('components.Admin.Sidebar')
    <!-- ========== Sidebar Section End ========== -->

    <!-- ========== Main Content Section Start ========== -->
    <section class="home-section">
      @include('components.Admin.Header')

      <div class="home-content">
        <div class="container-fluid px-3">

          <!-- Page Header -->
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h2><i class="fa fa-chart-line"></i> Analytics Dashboard</h2>
                  <p class="text-muted">Comprehensive insights into refunds, payouts, and revenue</p>
                </div>

                <!-- Date Range Filter -->
                <form method="GET" action="{{ route('admin.payment-analytics') }}" class="d-flex align-items-center gap-2">
                  <div>
                    <label class="small text-muted">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>
                  </div>
                  <div>
                    <label class="small text-muted">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>
                  </div>
                  <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Quick Stats Overview -->
          <div class="row mb-4">
            <div class="col-md-3">
              <div class="stat-card success">
                <div class="stat-value">${{ number_format($revenueStats['total_revenue'], 2) }}</div>
                <div class="stat-label"><i class="fa fa-dollar-sign"></i> Total Revenue</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card info">
                <div class="stat-value">${{ number_format($revenueStats['total_admin_commission'], 2) }}</div>
                <div class="stat-label"><i class="fa fa-percent"></i> Admin Commission</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card warning">
                <div class="stat-value">${{ number_format($payoutStats['pending_payout_amount'], 2) }}</div>
                <div class="stat-label"><i class="fa fa-clock"></i> Pending Payouts</div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="stat-card danger">
                <div class="stat-value">${{ number_format($refundStats['total_refund_amount'], 2) }}</div>
                <div class="stat-label"><i class="fa fa-undo"></i> Total Refunds</div>
              </div>
            </div>
          </div>

          <!-- Revenue & Commission Chart -->
          <div class="row">
            <div class="col-lg-8">
              <div class="analytics-card">
                <h4><i class="fa fa-chart-area"></i> Revenue & Commission Trends</h4>
                <div class="chart-container">
                  <canvas id="revenueChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Payout Distribution -->
            <div class="col-lg-4">
              <div class="analytics-card">
                <h4><i class="fa fa-chart-pie"></i> Payout Status Distribution</h4>
                <div class="chart-container">
                  <canvas id="payoutPieChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Refund Analytics -->
          <div class="row">
            <div class="col-lg-6">
              <div class="analytics-card">
                <h4><i class="fa fa-undo"></i> Refund Analytics</h4>
                <div class="row mt-3">
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-success">{{ $refundStats['approval_rate'] }}%</h3>
                      <small class="text-muted">Approval Rate</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-warning">{{ $refundStats['avg_processing_hours'] }}h</h3>
                      <small class="text-muted">Avg Processing Time</small>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-primary">{{ $refundStats['total_disputes'] }}</h3>
                      <small class="text-muted">Total Disputes</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-info">${{ number_format($refundStats['average_refund_amount'], 2) }}</h3>
                      <small class="text-muted">Avg Refund Amount</small>
                    </div>
                  </div>
                </div>
                <div class="chart-container mt-4">
                  <canvas id="refundTrendsChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Payout Analytics -->
            <div class="col-lg-6">
              <div class="analytics-card">
                <h4><i class="fa fa-money-bill-wave"></i> Payout Analytics</h4>
                <div class="row mt-3">
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-success">{{ $payoutStats['completion_rate'] }}%</h3>
                      <small class="text-muted">Completion Rate</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-primary">{{ $payoutStats['total_payouts'] }}</h3>
                      <small class="text-muted">Total Payouts</small>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-warning">{{ $payoutStats['pending'] }}</h3>
                      <small class="text-muted">Pending</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="text-center p-3 border rounded">
                      <h3 class="text-info">${{ number_format($payoutStats['average_payout_amount'], 2) }}</h3>
                      <small class="text-muted">Avg Payout Amount</small>
                    </div>
                  </div>
                </div>

                <!-- Top Sellers -->
                <div class="mt-4">
                  <h5>Top 10 Sellers by Earnings</h5>
                  <div class="top-sellers-list">
                    @forelse($payoutStats['top_sellers'] as $index => $seller)
                      <div class="top-seller-item">
                        <div>
                          <strong>{{ $index + 1 }}. {{ $seller->seller->name ?? 'Unknown' }}</strong>
                          <br><small class="text-muted">{{ $seller->payout_count }} payouts</small>
                        </div>
                        <div>
                          <strong class="text-success">${{ number_format($seller->total_earnings, 2) }}</strong>
                        </div>
                      </div>
                    @empty
                      <p class="text-muted text-center py-3">No sellers found in this date range</p>
                    @endforelse
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Analytics -->
          <div class="row">
            <div class="col-12">
              <div class="analytics-card">
                <h4><i class="fa fa-shopping-cart"></i> Order Analytics</h4>
                <div class="row mt-3">
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4>{{ $orderStats['total_orders'] }}</h4>
                      <small class="text-muted">Total Orders</small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4 class="text-success">{{ $orderStats['completed'] }}</h4>
                      <small class="text-muted">Completed</small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4 class="text-primary">{{ $orderStats['active'] }}</h4>
                      <small class="text-muted">Active</small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4 class="text-danger">{{ $orderStats['cancelled'] }}</h4>
                      <small class="text-muted">Cancelled</small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4 class="text-success">{{ $orderStats['completion_rate'] }}%</h4>
                      <small class="text-muted">Completion Rate</small>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="text-center p-3 border rounded">
                      <h4 class="text-warning">{{ $orderStats['dispute_rate'] }}%</h4>
                      <small class="text-muted">Dispute Rate</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- JavaScript -->
    <script src="/assets/admin/libs/jquery/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/admin/asset/js/sidebar.js"></script>

    <script>
      // Revenue & Commission Chart
      const revenueDates = {!! json_encode($chartData['daily_revenue']->pluck('date')->toArray()) !!};
      const revenueValues = {!! json_encode($chartData['daily_revenue']->pluck('revenue')->toArray()) !!};
      const commissionValues = {!! json_encode($chartData['daily_revenue']->pluck('commission')->toArray()) !!};

      new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
          labels: revenueDates,
          datasets: [
            {
              label: 'Revenue',
              data: revenueValues,
              borderColor: '#4CAF50',
              backgroundColor: 'rgba(76, 175, 80, 0.1)',
              fill: true,
              tension: 0.4
            },
            {
              label: 'Commission',
              data: commissionValues,
              borderColor: '#2196F3',
              backgroundColor: 'rgba(33, 150, 243, 0.1)',
              fill: true,
              tension: 0.4
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top' },
            tooltip: {
              callbacks: {
                label: (context) => `${context.dataset.label}: $${context.parsed.y.toFixed(2)}`
              }
            }
          }
        }
      });

      // Payout Pie Chart
      const payoutLabels = {!! json_encode($chartData['payout_distribution']->pluck('payout_status')->toArray()) !!};
      const payoutCounts = {!! json_encode($chartData['payout_distribution']->pluck('count')->toArray()) !!};

      new Chart(document.getElementById('payoutPieChart'), {
        type: 'doughnut',
        data: {
          labels: payoutLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
          datasets: [{
            data: payoutCounts,
            backgroundColor: ['#ff9800', '#4CAF50', '#f44336']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'bottom' }
          }
        }
      });

      // Refund Trends Chart
      const refundDates = {!! json_encode($chartData['refund_trends']->pluck('date')->toArray()) !!};
      const refundApproved = {!! json_encode($chartData['refund_trends']->pluck('approved')->toArray()) !!};
      const refundRejected = {!! json_encode($chartData['refund_trends']->pluck('rejected')->toArray()) !!};

      new Chart(document.getElementById('refundTrendsChart'), {
        type: 'bar',
        data: {
          labels: refundDates,
          datasets: [
            {
              label: 'Approved',
              data: refundApproved,
              backgroundColor: '#4CAF50'
            },
            {
              label: 'Rejected',
              data: refundRejected,
              backgroundColor: '#f44336'
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { position: 'top' }
          },
          scales: {
            x: { stacked: true },
            y: { stacked: true, beginAtZero: true }
          }
        }
      });
    </script>
  </body>
</html>
