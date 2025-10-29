<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Commission Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .summary {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .summary-item {
            display: inline-block;
            width: 32%;
            text-align: center;
            padding: 10px;
        }

        .summary-item h3 {
            margin: 0;
            color: #007bff;
            font-size: 20px;
        }

        .summary-item p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        table tr:hover {
            background: #f8f9fa;
        }

        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-refunded {
            background: #f8d7da;
            color: #721c24;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Commission Report</h1>
    <p>Generated on: {{ $exportDate }}</p>
    @if($dateRange['from'] || $dateRange['to'])
        <p>
            Period:
            {{ $dateRange['from'] ? date('d M Y', strtotime($dateRange['from'])) : 'Beginning' }}
            to
            {{ $dateRange['to'] ? date('d M Y', strtotime($dateRange['to'])) : 'Present' }}
        </p>
    @endif
</div>

<div class="summary">
    <div class="summary-item">
        <h3>${{ number_format($totalAmount, 2) }}</h3>
        <p>Total Transaction Amount</p>
    </div>
    <div class="summary-item">
        <h3>${{ number_format($totalCommission, 2) }}</h3>
        <p>Total Admin Commission</p>
    </div>
    <div class="summary-item">
        <h3>${{ number_format($totalSellerEarnings, 2) }}</h3>
        <p>Total Seller Earnings</p>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Buyer</th>
        <th>Seller</th>
        <th>Amount</th>
        <th>Commission</th>
        <th>Seller Earning</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td><strong>#{{ $transaction->id }}</strong></td>
            <td>{{ $transaction->created_at->format('d M Y') }}</td>
            <td>{{ $transaction->buyer->name ?? 'N/A' }}</td>
            <td>{{ $transaction->seller->name ?? 'N/A' }}</td>
            <td><strong>${{ number_format($transaction->total_amount, 2) }}</strong></td>
            <td style="color: #28a745;">${{ number_format($transaction->total_admin_commission, 2) }}</td>
            <td style="color: #007bff;">${{ number_format($transaction->seller_earnings, 2) }}</td>
            <td>
                    <span class="status status-{{ $transaction->status }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    <p><strong>Dreamcrowd</strong> - Commission Management System</p>
    <p>Copyright © {{ date('Y') }}. All Rights Reserved.</p>
</div>
</body>
</html>
