<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction #{{ $transaction->id }}</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>

    <style>
        .detail-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .detail-row {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .amount-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-box h2 {
            margin: 0;
            font-size: 48px;
        }

        .breakdown-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ Auth::user()->role == 1 ? '/seller/transactions' : '/user/transactions' }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Transactions
        </a>
    </div>

    <!-- Transaction Header -->
    <div class="row">
        <div class="col-md-12">
            <h2>
                <i class="fa-solid fa-file-invoice-dollar"></i>
                Transaction #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
            </h2>
            <p class="text-muted">{{ $transaction->created_at->format('l, F d, Y - h:i A') }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">

            <!-- Transaction Status -->
            <div class="detail-card">
                <h5 class="mb-3"><i class="fa-solid fa-info-circle"></i> Transaction Status</h5>

                <div class="detail-row">
                    <div class="row">
                        <div class="col-md-4"><strong>Transaction ID:</strong></div>
                        <div class="col-md-8">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="row">
                        <div class="col-md-4"><strong>Status:</strong></div>
                        <div class="col-md-8">
                                <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->role == 1)
                    <div class="detail-row">
                        <div class="row">
                            <div class="col-md-4"><strong>Payout Status:</strong></div>
                            <div class="col-md-8">
                                <span class="badge bg-{{ $transaction->payout_status == 'paid' ? 'success' : ($transaction->payout_status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($transaction->payout_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="detail-row">
                    <div class="row">
                        <div class="col-md-4"><strong>Payment Method:</strong></div>
                        <div class="col-md-8">
                            <i class="fa-brands fa-stripe"></i> Stripe
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="row">
                        <div class="col-md-4"><strong>Stripe ID:</strong></div>
                        <div class="col-md-8">
                            <code>{{ $transaction->stripe_transaction_id ?? 'N/A' }}</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Parties Information -->
            <div class="detail-card">
                <h5 class="mb-3"><i class="fa-solid fa-users"></i> Transaction Parties</h5>

                <div class="row">
                    <div class="col-md-6">
                        <div style="background: #e3f2fd; padding: 15px; border-radius: 6px;">
                            <h6 style="color: #1976d2;"><i class="fa-solid fa-shopping-cart"></i> Buyer</h6>
                            <p style="margin: 5px 0;"><strong>Name:</strong> {{ ($transaction->buyer->first_name ?? '') . ' ' . ($transaction->buyer->last_name ?? '') ?: 'N/A' }}</p>
                            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $transaction->buyer->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="background: #e8f5e9; padding: 15px; border-radius: 6px;">
                            <h6 style="color: #388e3c;"><i class="fa-solid fa-user-tie"></i> Seller</h6>
                            <p style="margin: 5px 0;"><strong>Name:</strong> {{ ($transaction->seller->first_name ?? '') . ' ' . ($transaction->seller->last_name ?? '') ?: 'N/A' }}</p>
                            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $transaction->seller->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            @if($transaction->bookOrder)
                <div class="detail-card">
                    <h5 class="mb-3"><i class="fa-solid fa-box"></i> Order Information</h5>

                    <div class="detail-row">
                        <div class="row">
                            <div class="col-md-4"><strong>Order ID:</strong></div>
                            <div class="col-md-8">
                                <a href="/order/{{ $transaction->bookOrder->id }}">#{{ $transaction->bookOrder->id }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="row">
                            <div class="col-md-4"><strong>Service:</strong></div>
                            <div class="col-md-8">{{ $transaction->bookOrder->title ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="row">
                            <div class="col-md-4"><strong>Order Status:</strong></div>
                            <div class="col-md-8">
                                @php
                                    $orderStatus = ['Pending', 'Active', 'Delivered', 'Completed', 'Cancelled'];
                                    $statusColors = ['secondary', 'warning', 'info', 'success', 'danger'];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$transaction->bookOrder->status] ?? 'secondary' }}">
                                    {{ $orderStatus[$transaction->bookOrder->status] ?? 'Unknown' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        @endif

        <!-- Payment Timeline -->
            <div class="detail-card">
                <h5 class="mb-3"><i class="fa-solid fa-clock"></i> Payment Timeline</h5>

                <div style="border-left: 3px solid #007bff; padding-left: 20px;">
                    <div style="margin-bottom: 20px;">
                        <i class="fa-solid fa-plus-circle" style="color: #007bff;"></i>
                        <strong style="margin-left: 10px;">Created</strong>
                        <br>
                        <small style="margin-left: 30px; color: #666;">
                            {{ $transaction->created_at->format('d M Y, h:i A') }}
                        </small>
                    </div>

                    @if($transaction->paid_at)
                        <div style="margin-bottom: 20px;">
                            <i class="fa-solid fa-check-circle" style="color: #28a745;"></i>
                            <strong style="margin-left: 10px;">Payment Completed</strong>
                            <br>
                            <small style="margin-left: 30px; color: #666;">
                                {{ $transaction->paid_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    @endif

                    @if($transaction->payout_at && Auth::user()->role == 1)
                        <div style="margin-bottom: 20px;">
                            <i class="fa-solid fa-money-bill-transfer" style="color: #17a2b8;"></i>
                            <strong style="margin-left: 10px;">Payout Completed</strong>
                            <br>
                            <small style="margin-left: 30px; color: #666;">
                                {{ $transaction->payout_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    @endif

                    @if($transaction->status == 'refunded')
                        <div>
                            <i class="fa-solid fa-rotate-left" style="color: #dc3545;"></i>
                            <strong style="margin-left: 10px;">Refunded</strong>
                            <br>
                            <small style="margin-left: 30px; color: #666;">
                                {{ $transaction->updated_at->format('d M Y, h:i A') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="col-md-4">

            <!-- Amount Display -->
            <div class="amount-box">
                <p style="margin: 0; opacity: 0.9;">
                    @if(Auth::user()->role == 1)
                        Your Earnings
                    @else
                        Total Paid
                    @endif
                </p>
                <h2>
                    @if(Auth::user()->role == 1)
                        @currency($transaction->seller_earnings)
                    @else
                        @currency($transaction->total_amount + $transaction->buyer_commission_amount)
                    @endif
                </h2>
                <small style="opacity: 0.9;">{{ $transaction->currency }}</small>
            </div>

            <!-- Breakdown -->
            <div class="detail-card">
                <h6 class="mb-3"><i class="fa-solid fa-chart-pie"></i> Payment Breakdown</h6>

                <div class="breakdown-card">
                @if(Auth::user()->role == 1)
                    <!-- Seller View -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service Amount:</span>
                            <strong>@currency($transaction->total_amount)</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #dc3545;">Platform Commission ({{ $transaction->seller_commission_rate }}%):</span>
                            <strong style="color: #dc3545;">-@currency($transaction->seller_commission_amount)</strong>
                        </div>
                        @if($transaction->coupon_discount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #ffc107;">Coupon Discount (absorbed):</span>
                                <strong style="color: #ffc107;">-@currency($transaction->coupon_discount)</strong>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Your Earnings:</strong>
                            <strong style="color: #28a745; font-size: 18px;">
                                @currency($transaction->seller_earnings)
                            </strong>
                        </div>
                    @else
                    <!-- Buyer View -->
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service Price:</span>
                            <strong>@currency($transaction->total_amount)</strong>
                        </div>
                        @if($transaction->coupon_discount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span style="color: #28a745;">Coupon Discount:</span>
                                <strong style="color: #28a745;">-@currency($transaction->coupon_discount)</strong>
                            </div>
                        @endif
                        @if($transaction->buyer_commission_amount > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Service Fee ({{ $transaction->buyer_commission_rate }}%):</span>
                                <strong>@currency($transaction->buyer_commission_amount)</strong>
                            </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Paid:</strong>
                            <strong style="color: #007bff; font-size: 18px;">
                                @currency($transaction->total_amount + $transaction->buyer_commission_amount - $transaction->coupon_discount)
                            </strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="detail-card">
                <h6 class="mb-3"><i class="fa-solid fa-bolt"></i> Actions</h6>
                @if(Auth::user()->role == 0 && $transaction->status == 'completed')
                    <a href="/transaction/{{ $transaction->id }}/invoice" class="btn btn-primary w-100 mb-2">
                        <i class="fa-solid fa-download"></i> Download Invoice
                    </a>
                @endif

                @if($transaction->bookOrder)
                    <a href="/order/{{ $transaction->bookOrder->id }}" class="btn btn-secondary w-100 mb-2">
                        <i class="fa-solid fa-box"></i> View Order
                    </a>
                @endif

                <button onclick="window.print()" class="btn btn-outline-primary w-100">
                    <i class="fa-solid fa-print"></i> Print Receipt
                </button>
            </div>

            <!-- Additional Info -->
            @if($transaction->notes)
                <div class="detail-card">
                    <h6 class="mb-3"><i class="fa-solid fa-note-sticky"></i> Notes</h6>
                    <div style="background: #fff3cd; padding: 15px; border-radius: 6px; font-size: 13px;">
                        {{ $transaction->notes }}
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

<script src="assets/admin/asset/js/bootstrap.min.js"></script>
</body>
</html>
