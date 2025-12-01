<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Earnings Invoice #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #28a745;
            margin: 0;
            font-size: 28px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .company-info h2 {
            color: #333;
            margin-bottom: 5px;
        }

        .invoice-details {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .parties {
            margin-bottom: 30px;
        }

        .party-box {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .party-box h3 {
            color: #28a745;
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 5px;
        }

        .party-box p {
            margin: 5px 0;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.main-table th {
            background: #28a745;
            color: white;
            padding: 12px;
            text-align: left;
        }

        table.main-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .earnings-summary {
            margin-top: 30px;
            border: 2px solid #28a745;
            border-radius: 8px;
            overflow: hidden;
        }

        .earnings-summary h3 {
            background: #28a745;
            color: white;
            padding: 12px;
            margin: 0;
            font-size: 16px;
        }

        .earnings-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .earnings-summary table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .earnings-summary table tr:last-child td {
            border-bottom: none;
        }

        .earnings-row {
            background: #d4edda;
            font-weight: bold;
            font-size: 18px;
        }

        .commission-row {
            color: #dc3545;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-primary {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>EARNINGS INVOICE</h1>
    <p>Invoice #INV-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
    <p>Generated: {{ now()->format('F d, Y h:i A') }}</p>
</div>

<div class="company-info">
    <h2>{{ config('app.name', 'DreamCrowd') }}</h2>
    <p>Online Marketplace Platform</p>
</div>

<div class="invoice-details">
    <table style="width: 100%; border: none;">
        <tr>
            <td style="border: none; padding: 5px;"><strong>Transaction ID:</strong></td>
            <td style="border: none; padding: 5px;">#{{ $transaction->id }}</td>
            <td style="border: none; padding: 5px;"><strong>Transaction Date:</strong></td>
            <td style="border: none; padding: 5px;">{{ $transaction->created_at->format('F d, Y') }}</td>
        </tr>
        <tr>
            <td style="border: none; padding: 5px;"><strong>Payment Reference:</strong></td>
            <td style="border: none; padding: 5px;">{{ $transaction->stripe_transaction_id ?? 'N/A' }}</td>
            <td style="border: none; padding: 5px;"><strong>Status:</strong></td>
            <td style="border: none; padding: 5px;">
                @if(in_array($transaction->payout_status, ['completed', 'paid']))
                    <span class="badge badge-success">PAID</span>
                @elseif($transaction->payout_status == 'pending')
                    <span class="badge badge-warning">PENDING</span>
                @else
                    <span class="badge badge-primary">{{ strtoupper($transaction->payout_status) }}</span>
                @endif
            </td>
        </tr>
    </table>
</div>

<div class="parties">
    <div class="party-box">
        <h3>SELLER (YOU)</h3>
        <p><strong>{{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</strong></p>
        <p>{{ $transaction->seller->email ?? 'N/A' }}</p>
    </div>

    <div class="party-box" style="margin-left: 3%;">
        <h3>BUYER</h3>
        <p><strong>{{ $transaction->buyer->first_name ?? 'N/A' }} {{ strtoupper(substr($transaction->buyer->last_name ?? '', 0, 1)) }}.</strong></p>
        <p><em>(Privacy protected)</em></p>
    </div>
</div>

<table class="main-table">
    <thead>
    <tr>
        <th>Description</th>
        <th style="text-align: center;">Type</th>
        <th style="text-align: right;">Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <strong>{{ $transaction->bookOrder->title ?? $transaction->service->title ?? 'Service' }}</strong>
            <br>
            <small style="color: #666;">Order #{{ $transaction->bookOrder->id ?? 'N/A' }}</small>
        </td>
        <td style="text-align: center;">
            <span class="badge badge-primary">{{ ucfirst($transaction->service_type ?? 'Service') }}</span>
        </td>
        <td style="text-align: right;">@currencyRaw($transaction->total_amount)</td>
    </tr>
    </tbody>
</table>

<div class="earnings-summary">
    <h3>Earnings Breakdown</h3>
    <table>
        <tr>
            <td>Order Amount:</td>
            <td style="text-align: right;">@currencyRaw($transaction->total_amount)</td>
        </tr>
        <tr class="commission-row">
            <td>Platform Commission ({{ $transaction->seller_commission_rate }}%):</td>
            <td style="text-align: right;">-@currencyRaw($transaction->seller_commission_amount)</td>
        </tr>
        <tr class="earnings-row">
            <td><strong>YOUR NET EARNINGS:</strong></td>
            <td style="text-align: right;"><strong>@currencyRaw($transaction->seller_earnings)</strong></td>
        </tr>
    </table>
</div>

@if($transaction->payout_at)
<div style="margin-top: 20px; padding: 15px; background: #d4edda; border-radius: 5px; text-align: center;">
    <p style="margin: 0; color: #155724;">
        <strong>Payment Processed:</strong> {{ $transaction->payout_at->format('F d, Y h:i A') }}
    </p>
</div>
@endif

<div class="footer">
    <p><strong>Thank you for being a valued seller on {{ config('app.name', 'DreamCrowd') }}!</strong></p>
    <p>This is an automatically generated earnings statement.</p>
    <p>For any questions about this invoice, please contact our support team.</p>
    <p style="margin-top: 15px;">&copy; {{ date('Y') }} {{ config('app.name', 'DreamCrowd') }}. All rights reserved.</p>
</div>

</body>
</html>
