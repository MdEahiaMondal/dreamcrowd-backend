<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Report - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            background: #007bff;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 14px;
            opacity: 0.9;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info-row {
            display: inline-block;
            width: 48%;
            margin-bottom: 5px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #007bff;
        }
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-row {
            display: table-row;
        }
        .stat-cell {
            display: table-cell;
            width: 50%;
            padding: 10px;
            border: 1px solid #dee2e6;
            background: #fff;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #dee2e6;
        }
        th {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .status-pending { background: #ffc107; }
        .status-active { background: #007bff; }
        .status-delivered { background: #17a2b8; }
        .status-completed { background: #28a745; }
        .status-cancelled { background: #dc3545; }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Dashboard Report</h1>
        <p>{{ $user->name }} ({{ $user->email }})</p>
        <p>Report Period: {{ $dateRange['from'] }} to {{ $dateRange['to'] }}</p>
    </div>

    <!-- User Info Section -->
    <div class="info-section">
        <div class="info-row">
            <span class="label">User ID:</span> {{ $user->id }}
        </div>
        <div class="info-row">
            <span class="label">Member Since:</span> {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
        </div>
        <div class="info-row">
            <span class="label">Report Generated:</span> {{ $generatedAt }}
        </div>
        <div class="info-row">
            <span class="label">Days as Member:</span> {{ $stats['engagement']['days_as_member'] }} days
        </div>
    </div>

    <!-- Financial Statistics -->
    <div class="section-title">Financial Statistics</div>
    <div class="stats-grid">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Total Spent</div>
                <div class="stat-value">@currencyRaw($stats['financial']['total_spent'])</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">This Month Spent</div>
                <div class="stat-value">@currencyRaw($stats['financial']['month_spent'])</div>
            </div>
        </div>
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Average Order Value</div>
                <div class="stat-value">@currencyRaw($stats['financial']['avg_order_value'])</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Total Service Fees</div>
                <div class="stat-value">@currencyRaw($stats['financial']['total_service_fees'])</div>
            </div>
        </div>
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Total Coupon Savings</div>
                <div class="stat-value">@currencyRaw($stats['financial']['total_coupon_savings'])</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Total Refunded</div>
                <div class="stat-value">@currencyRaw($stats['financial']['total_refunded'])</div>
            </div>
        </div>
    </div>

    <!-- Order Statistics -->
    <div class="section-title">Order Statistics</div>
    <div class="stats-grid">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ $stats['orders']['total_orders'] }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Active Orders</div>
                <div class="stat-value">{{ $stats['orders']['active_orders'] }}</div>
            </div>
        </div>
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Completed Orders</div>
                <div class="stat-value">{{ $stats['orders']['completed_orders'] }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Cancelled Orders</div>
                <div class="stat-value">{{ $stats['orders']['cancelled_orders'] }}</div>
            </div>
        </div>
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Class Orders</div>
                <div class="stat-value">{{ $stats['orders']['class_orders'] }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Freelance Orders</div>
                <div class="stat-value">{{ $stats['orders']['freelance_orders'] }}</div>
            </div>
        </div>
    </div>

    <!-- Engagement Statistics -->
    <div class="section-title">Engagement Statistics</div>
    <div class="stats-grid">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Reviews Given</div>
                <div class="stat-value">{{ $stats['engagement']['reviews_given'] }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Coupons Used</div>
                <div class="stat-value">{{ $stats['engagement']['coupons_used'] }}</div>
            </div>
        </div>
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-label">Unique Sellers</div>
                <div class="stat-value">{{ $stats['engagement']['unique_sellers'] }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-label">Disputes Filed</div>
                <div class="stat-value">{{ $stats['engagement']['disputes_filed'] }}</div>
            </div>
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Recent Transactions -->
    <div class="section-title">Recent Transactions</div>
    @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 30%;">Service</th>
                    <th style="width: 20%;">Seller</th>
                    <th style="width: 15%;">Amount</th>
                    <th style="width: 10%;">Discount</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                    <td>{{ $transaction->gig->title ?? 'N/A' }}</td>
                    <td>{{ $transaction->teacher->name ?? 'N/A' }}</td>
                    <td>@currencyRaw($transaction->finel_price ?? 0)</td>
                    <td>@currencyRaw($transaction->discount ?? 0)</td>
                    <td>
                        @php
                            $statusLabels = ['0' => 'Pending', '1' => 'Active', '2' => 'Delivered', '3' => 'Completed', '4' => 'Cancelled'];
                            $statusClasses = ['0' => 'pending', '1' => 'active', '2' => 'delivered', '3' => 'completed', '4' => 'cancelled'];
                        @endphp
                        <span class="status-badge status-{{ $statusClasses[$transaction->status] ?? 'pending' }}">
                            {{ $statusLabels[$transaction->status] ?? 'Unknown' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="padding: 20px; text-align: center; color: #999;">No transactions found for the selected period.</p>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This report was generated automatically by DreamCrowd Platform</p>
        <p>Generated on {{ $generatedAt }}</p>
        <p>&copy; {{ date('Y') }} DreamCrowd. All rights reserved.</p>
    </div>
</body>
</html>
