<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .invoice-container {
            padding: 30px;
        }

        .invoice-header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }

        .company-details {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .company-details h1 {
            color: #007bff;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .company-details p {
            color: #666;
            font-size: 11px;
            line-height: 1.8;
        }

        .invoice-meta {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .invoice-meta h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .invoice-meta p {
            color: #666;
            font-size: 11px;
            margin: 5px 0;
        }

        .invoice-meta .invoice-number {
            background: #007bff;
            color: white;
            padding: 8px 15px;
            display: inline-block;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }

        .parties-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .party-box {
            display: table-cell;
            width: 48%;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            vertical-align: top;
        }

        .party-box:first-child {
            margin-right: 4%;
        }

        .party-box h3 {
            color: #007bff;
            font-size: 14px;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e0e0e0;
        }

        .party-box p {
            color: #666;
            font-size: 11px;
            margin: 5px 0;
        }

        .party-box strong {
            color: #333;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .details-table {
            width: 100%;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .details-table table {
            width: 100%;
        }

        .details-table td {
            padding: 8px 0;
            font-size: 11px;
        }

        .details-table td:first-child {
            color: #666;
            width: 40%;
        }

        .details-table td:last-child {
            color: #333;
            font-weight: bold;
            text-align: right;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table thead {
            background: #007bff;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 11px;
        }

        .items-table tbody tr:last-child td {
            border-bottom: 2px solid #007bff;
        }

        .totals-section {
            float: right;
            width: 50%;
            margin-top: 20px;
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 15px;
            font-size: 11px;
        }

        .totals-table td:first-child {
            text-align: left;
            color: #666;
        }

        .totals-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .totals-table .subtotal-row {
            background: #f8f9fa;
        }

        .totals-table .total-row {
            background: #007bff;
            color: white;
            font-size: 14px;
        }

        .totals-table .total-row td {
            padding: 12px 15px;
            color: white;
        }

        .commission-breakdown {
            clear: both;
            margin-top: 30px;
            padding: 20px;
            background: #fff3cd;
            border-radius: 5px;
            border-left: 4px solid #ffc107;
        }

        .commission-breakdown h3 {
            color: #856404;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .commission-breakdown table {
            width: 100%;
        }

        .commission-breakdown td {
            padding: 8px 0;
            font-size: 11px;
            color: #856404;
        }

        .commission-breakdown td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 10px;
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

        .notes-section {
            margin-top: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #17a2b8;
        }

        .notes-section h3 {
            color: #17a2b8;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .notes-section p {
            color: #666;
            font-size: 11px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
        }

        .footer p {
            color: #999;
            font-size: 10px;
            margin: 5px 0;
        }

        .footer .terms {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            text-align: left;
        }

        .footer .terms h4 {
            color: #666;
            font-size: 11px;
            margin-bottom: 8px;
        }

        .footer .terms ul {
            list-style: none;
            padding-left: 0;
        }

        .footer .terms li {
            color: #999;
            font-size: 9px;
            margin: 3px 0;
            padding-left: 15px;
            position: relative;
        }

        .footer .terms li:before {
            content: "•";
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
<div class="invoice-container">

    <!-- Invoice Header -->
    <div class="invoice-header">
        <div class="company-details">
            <h1>{{ $companyName }}</h1>
            <p>
                <strong>{{ $companyAddress }}</strong><br>
                Email: {{ $companyEmail }}<br>
                Phone: {{ $companyPhone }}<br>
                Website: www.dreamcrowd.com
            </p>
        </div>
        <div class="invoice-meta">
            <h2>INVOICE</h2>
            <p><strong>Invoice Date:</strong> {{ $invoiceDate }}</p>
            <p><strong>Transaction Date:</strong> {{ $transaction->created_at->format('d M Y') }}</p>
            <div class="invoice-number">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <!-- Parties Section -->
    <div class="parties-section">
        <div class="party-box">
            <h3>BILLED TO (Buyer)</h3>
            <p><strong>{{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}</strong></p>
            <p>Email: {{ $transaction->buyer->email ?? 'N/A' }}</p>
            <p>Customer ID: #{{ $transaction->buyer_id }}</p>
        </div>
        <div class="party-box">
            <h3>SERVICE PROVIDED BY (Seller)</h3>
            <p><strong>{{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</strong></p>
            <p>Email: {{ $transaction->seller->email ?? 'N/A' }}</p>
            <p>Seller ID: #{{ $transaction->seller_id }}</p>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="invoice-details">
        <div class="details-table">
            <table>
                <tr>
                    <td>Transaction ID:</td>
                    <td>#{{ $transaction->id }}</td>
                </tr>
                <tr>
                    <td>Payment Method:</td>
                    <td>Stripe</td>
                </tr>
                <tr>
                    <td>Stripe Transaction ID:</td>
                    <td>{{ $transaction->stripe_transaction_id ?? 'Pending' }}</td>
                </tr>
                <tr>
                    <td>Transaction Status:</td>
                    <td>
                            <span class="status-badge status-{{ $transaction->status }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                    </td>
                </tr>
                <tr>
                    <td>Currency:</td>
                    <td>{{ $transaction->currency }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
        <tr>
            <th>Description</th>
            <th style="text-align: center;">Type</th>
            <th style="text-align: center;">ID</th>
            <th style="text-align: right;">Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ ucfirst($transaction->service_type) }} Service/Class</td>
            <td style="text-align: center;">{{ ucfirst($transaction->service_type) }}</td>
            <td style="text-align: center;">#{{ $transaction->service_id }}</td>
            <td style="text-align: right;">@currencyRaw($transaction->total_amount)</td>
        </tr>
        </tbody>
    </table>

    <!-- Totals Section -->
    <div class="totals-section">
        <table class="totals-table">
            <tr class="subtotal-row">
                <td>Subtotal:</td>
                <td>@currencyRaw($transaction->total_amount)</td>
            </tr>

            @if($transaction->coupon_discount > 0)
                <tr>
                    <td>Discount (Coupon):</td>
                    <td>-@currencyRaw($transaction->coupon_discount)</td>
                </tr>
            @endif

            @if($transaction->buyer_commission_amount > 0)
                <tr>
                    <td>Buyer Commission ({{ $transaction->buyer_commission_rate }}%):</td>
                    <td>@currencyRaw($transaction->buyer_commission_amount)</td>
                </tr>
            @endif

            <tr class="total-row">
                <td><strong>TOTAL PAID:</strong></td>
                <td><strong>@currencyRaw($transaction->total_amount + $transaction->buyer_commission_amount)</strong></td>
            </tr>
        </table>
    </div>

    <!-- Commission Breakdown -->
    <div class="commission-breakdown">
        <h3>Platform Commission Breakdown</h3>
        <table>
            <tr>
                <td>Transaction Amount:</td>
                <td>@currencyRaw($transaction->total_amount)</td>
            </tr>
            <tr>
                <td>Seller Commission ({{ $transaction->seller_commission_rate }}%):</td>
                <td>@currencyRaw($transaction->seller_commission_amount)</td>
            </tr>
            @if($transaction->buyer_commission_amount > 0)
                <tr>
                    <td>Buyer Commission ({{ $transaction->buyer_commission_rate }}%):</td>
                    <td>@currencyRaw($transaction->buyer_commission_amount)</td>
                </tr>
            @endif
            <tr style="border-top: 2px solid #856404;">
                <td><strong>Total Platform Commission:</strong></td>
                <td><strong>@currencyRaw($transaction->total_admin_commission)</strong></td>
            </tr>
            <tr>
                <td><strong>Seller Receives:</strong></td>
                <td><strong>@currencyRaw($transaction->seller_earnings)</strong></td>
            </tr>
        </table>
    </div>

    <!-- Payout Information (if completed) -->
    @if($transaction->payout_status == 'paid' && $transaction->payout_at)
        <div class="notes-section">
            <h3>Payout Information</h3>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; color: #666;">Payout Status:</td>
                    <td style="width: 50%; text-align: right; font-weight: bold; color: #28a745;">Completed</td>
                </tr>
                <tr>
                    <td style="color: #666;">Payout Date:</td>
                    <td style="text-align: right; font-weight: bold;">{{ $transaction->payout_at->format('d M Y, h:i A') }}</td>
                </tr>
                @if($transaction->stripe_payout_id)
                    <tr>
                        <td style="color: #666;">Stripe Payout ID:</td>
                        <td style="text-align: right; font-weight: bold;">{{ $transaction->stripe_payout_id }}</td>
                    </tr>
                @endif
            </table>
        </div>
    @endif

    <!-- Additional Notes -->
    @if($transaction->notes)
        <div class="notes-section">
            <h3>Additional Notes</h3>
            <p>{{ $transaction->notes }}</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Thank you for using {{ $companyName }}!</strong></p>
        <p>This is an official invoice generated by the {{ $companyName }} platform.</p>
        <p>For any questions or concerns, please contact us at {{ $companyEmail }}</p>

        <div class="terms">
            <h4>Terms & Conditions:</h4>
            <ul>
                <li>All transactions are processed securely through Stripe payment gateway.</li>
                <li>Platform commission is deducted from the transaction amount as per the agreed rate.</li>
                <li>Seller payouts are processed within 3-5 business days after transaction completion.</li>
                <li>Refund requests must be submitted within 14 days of the transaction date.</li>
                <li>All prices are in {{ $transaction->currency }} unless otherwise stated.</li>
                <li>This invoice is valid without signature as it is electronically generated.</li>
            </ul>
        </div>

        <p style="margin-top: 20px; font-weight: bold;">© {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
    </div>

</div>
</body>
</html>
