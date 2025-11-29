<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</title>
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
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 30px;
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
            color: #007bff;
            font-size: 14px;
            margin-bottom: 10px;
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
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 50%;
        }

        .totals table td {
            padding: 8px;
        }

        .total-row {
            background: #007bff;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>INVOICE</h1>
    <p>Invoice Date: {{ $invoiceDate }}</p>
    <p><strong>Invoice #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
</div>

<div class="company-info">
    <h2>{{ $companyName }}</h2>
    <p>{{ $companyAddress }}</p>
    <p>Email: {{ $companyEmail }} | Phone: {{ $companyPhone }}</p>
</div>

<div class="invoice-details">
    <table style="border: none;">
        <tr>
            <td style="border: none;"><strong>Transaction ID:</strong></td>
            <td style="border: none;">#{{ $transaction->id }}</td>
            <td style="border: none;"><strong>Transaction Date:</strong></td>
            <td style="border: none;">{{ $transaction->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <td style="border: none;"><strong>Payment Method:</strong></td>
            <td style="border: none;">Stripe</td>
            <td style="border: none;"><strong>Status:</strong></td>
            <td style="border: none;">{{ ucfirst($transaction->status) }}</td>
        </tr>
    </table>
</div>

<div class="parties">
    <div class="party-box">
        <h3>BILLED TO</h3>
        <p><strong>{{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}</strong></p>
        <p>{{ $transaction->buyer->email ?? 'N/A' }}</p>
    </div>

    <div class="party-box" style="margin-left: 3%;">
        <h3>SERVICE BY</h3>
        <p><strong>{{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</strong></p>
        <p>{{ $transaction->seller->email ?? 'N/A' }}</p>
    </div>
</div>

<table>
    <thead>
    <tr>
        <th>Description</th>
        <th style="text-align: center;">Qty</th>
        <th style="text-align: right;">Price</th>
        <th style="text-align: right;">Amount</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <strong>{{ $transaction->bookOrder->title ?? 'Service' }}</strong>
            <br>
            <small>Order #{{ $transaction->bookOrder->id ?? 'N/A' }}</small>
        </td>
        <td style="text-align: center;">1</td>
        <td style="text-align: right;">${{ number_format($transaction->total_amount, 2) }}</td>
        <td style="text-align: right;">${{ number_format($transaction->total_amount, 2) }}</td>
    </tr>
    </tbody>
</table>

<div class="totals">
    <table>
        <tr>
            <td>Subtotal:</td>
            <td style="text-align: right;">${{ number_format($transaction->total_amount, 2) }}</td>
        </tr>
        @if($transaction->coupon_discount > 0)
            <tr>
                <td>Discount (Coupon):</td>
                <td style="text-align: right; color: #28a745;">-${{ number_format($transaction->coupon_discount, 2) }}</td>
            </tr>
        @endif
        @if($transaction->buyer_commission_amount > 0)
            <tr>
                <td>Service Fee ({{ $transaction->buyer_commission_rate }}%):</td>
                <td style="text-align: right;">${{ number_format($transaction->buyer_commission_amount, 2) }}</td>
            </tr>
        @endif
        <tr class="total-row">
            <td>TOTAL PAID:</td>
            <td style="text-align: right;">${{ number_format($transaction->total_amount + $transaction->buyer_commission_amount - $transaction->coupon_discount, 2) }}</td>
        </tr>
    </table>
</div>

<div style="clear: both;"></div>

<div class="footer">
    <p><strong>Thank you for your business!</strong></p>
    <p>This is an official invoice generated by {{ $companyName }}.</p>
    <p>For support, contact {{ $companyEmail }}</p>
    <p style="margin-top: 15px;">© {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
</div>

</body>
</html>
