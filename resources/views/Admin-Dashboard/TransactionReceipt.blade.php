<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .receipt-header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .receipt-header h1 {
            color: #007bff;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .receipt-header p {
            color: #666;
            font-size: 14px;
        }

        .company-info {
            text-align: center;
            margin-bottom: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .company-info h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .company-info p {
            color: #666;
            font-size: 13px;
            line-height: 1.6;
        }

        .transaction-id {
            text-align: center;
            font-size: 18px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 30px;
            padding: 15px;
            background: #e7f3ff;
            border-radius: 8px;
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-section h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e0e0e0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-weight: 600;
            font-size: 14px;
        }

        .info-value {
            color: #333;
            font-size: 14px;
            text-align: right;
        }

        .amount-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }

        .amount-section h2 {
            font-size: 16px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .amount-section .total-amount {
            font-size: 48px;
            font-weight: bold;
            margin: 15px 0;
        }

        .breakdown-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .breakdown-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            color: #333;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .breakdown-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            color: #666;
        }

        .breakdown-table tr:last-child td {
            border-bottom: none;
        }

        .breakdown-table .highlight {
            background: #fff3cd;
            font-weight: bold;
            color: #856404;
        }

        .breakdown-table .total-row {
            background: #e7f3ff;
            font-weight: bold;
            color: #007bff;
            font-size: 16px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 12px;
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
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #999;
            font-size: 12px;
        }

        .print-button {
            text-align: center;
            margin: 20px 0;
        }

        .print-button button {
            background: #007bff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .print-button button:hover {
            background: #0056b3;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                padding: 20px;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="receipt-container">

    <!-- Print Button (Hidden on Print) -->
    <div class="print-button">
        <button onclick="window.print()">
            <i class="fa-solid fa-print"></i> Print Receipt
        </button>
    </div>

    <!-- Receipt Header -->
    <div class="receipt-header">
        <h1>TRANSACTION RECEIPT</h1>
        <p>Official payment confirmation</p>
    </div>

    <!-- Company Information -->
    <div class="company-info">
        <h2>Dreamcrowd</h2>
        <p>
            Your Company Address<br>
            Email: support@dreamcrowd.com | Phone: +1 234 567 8900<br>
            Website: www.dreamcrowd.com
        </p>
    </div>

    <!-- Transaction ID -->
    <div class="transaction-id">
        Transaction ID: #{{ $transaction->id }}
    </div>

    <!-- Date & Status -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Transaction Date:</span>
            <span class="info-value">{{ $transaction->created_at->format('d M Y, h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Status:</span>
            <span class="info-value">
                    <span class="status-badge status-{{ $transaction->status }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method:</span>
            <span class="info-value">Stripe ({{ $transaction->stripe_transaction_id ?? 'N/A' }})</span>
        </div>
    </div>

    <!-- Buyer Information -->
    <div class="info-section">
        <h3>Buyer Information</h3>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $transaction->buyer->email ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer ID:</span>
            <span class="info-value">#{{ $transaction->buyer_id }}</span>
        </div>
    </div>

    <!-- Seller Information -->
    <div class="info-section">
        <h3>Seller Information</h3>
        <div class="info-row">
            <span class="info-label">Name:</span>
            <span class="info-value">{{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span class="info-value">{{ $transaction->seller->email ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Seller ID:</span>
            <span class="info-value">#{{ $transaction->seller_id }}</span>
        </div>
    </div>

    <!-- Service Information -->
    <div class="info-section">
        <h3>Service/Class Information</h3>
        <div class="info-row">
            <span class="info-label">Type:</span>
            <span class="info-value">{{ ucfirst($transaction->service_type) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Service ID:</span>
            <span class="info-value">#{{ $transaction->service_id }}</span>
        </div>
    </div>

    <!-- Total Amount Display -->
    <div class="amount-section">
        <h2>Total Transaction Amount</h2>
        <div class="total-amount">
            @currencyRaw($transaction->total_amount)
        </div>
        <p style="opacity: 0.9;">{{ $transaction->currency }}</p>
    </div>

    <!-- Payment Breakdown -->
    <table class="breakdown-table">
        <thead>
        <tr>
            <th>Description</th>
            <th style="text-align: right;">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Subtotal</td>
            <td style="text-align: right;">@currencyRaw($transaction->total_amount)</td>
        </tr>

        @if($transaction->coupon_discount > 0)
            <tr class="highlight">
                <td>Coupon Discount</td>
                <td style="text-align: right;">-@currencyRaw($transaction->coupon_discount)</td>
            </tr>
        @endif

        <tr>
            <td>Platform Commission ({{ $transaction->seller_commission_rate }}%)</td>
            <td style="text-align: right;">@currencyRaw($transaction->seller_commission_amount)</td>
        </tr>

        @if($transaction->buyer_commission_amount > 0)
            <tr>
                <td>Buyer Commission ({{ $transaction->buyer_commission_rate }}%)</td>
                <td style="text-align: right;">@currencyRaw($transaction->buyer_commission_amount)</td>
            </tr>
        @endif

        <tr style="height: 10px;"></tr>

        <tr class="total-row">
            <td><strong>Seller Receives</strong></td>
            <td style="text-align: right;"><strong>@currencyRaw($transaction->seller_earnings)</strong></td>
        </tr>

        <tr class="total-row">
            <td><strong>Platform Receives</strong></td>
            <td style="text-align: right;">
                <strong>@currencyRaw($transaction->total_admin_commission)</strong></td>
        </tr>
        </tbody>
    </table>

    <!-- Payout Information -->
    @if($transaction->payout_status == 'paid' && $transaction->payout_at)
        <div class="info-section">
            <h3>Payout Information</h3>
            <div class="info-row">
                <span class="info-label">Payout Status:</span>
                <span class="info-value">
                    <span class="status-badge status-completed">Paid</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Payout Date:</span>
                <span class="info-value">{{ $transaction->payout_at->format('d M Y, h:i A') }}</span>
            </div>
            @if($transaction->stripe_payout_id)
                <div class="info-row">
                    <span class="info-label">Payout ID:</span>
                    <span class="info-value">{{ $transaction->stripe_payout_id }}</span>
                </div>
            @endif
        </div>
    @endif

    <!-- Notes -->
    @if($transaction->notes)
        <div class="info-section">
            <h3>Additional Notes</h3>
            <p style="color: #666; padding: 10px; background: #f8f9fa; border-radius: 5px;">
                {{ $transaction->notes }}
            </p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Thank you for your business!</strong></p>
        <p>This is an official receipt generated by Dreamcrowd platform.</p>
        <p>For any queries, please contact support@dreamcrowd.com</p>
        <p style="margin-top: 15px;">© {{ date('Y') }} Dreamcrowd. All rights reserved.</p>
    </div>

</div>

<script>
    // Auto print on load (optional)
    // window.onload = function() { window.print(); }
</script>
</body>
</html>
