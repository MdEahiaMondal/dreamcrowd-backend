<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Transaction Details #{{ $transaction->id }}</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/admin/asset/css/style.css"/>

    <style>
        .detail-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .detail-row {
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #666;
            font-size: 14px;
        }

        .detail-value {
            color: #333;
            font-size: 15px;
        }

        .amount-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .amount-box h2 {
            margin: 0;
            font-size: 36px;
        }

        .commission-breakdown {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .status-badge-large {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .timeline-item {
            padding: 15px;
            border-left: 3px solid #007bff;
            margin-left: 20px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
        }

        .action-buttons {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
        }
    </style>
</head>
<body>

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (Session::has('error'))
    <script>
        toastr.error("{{ session('error') }}");
    </script>
@endif

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
                                <h1 class="dash-title">Commission Report</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Transaction #{{ $transaction->id }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-file-invoice-dollar"
                                       style="font-size: 40px; color: #007bff;"></i>
                                    <h2>Transaction Details</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="/admin/commission-report" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left"></i> Back to Report
                        </a>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">

                            <!-- Transaction Overview -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px; color: #333;">
                                    <i class="fa-solid fa-info-circle"></i> Transaction Overview
                                </h5>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Transaction ID</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span class="detail-value">
                                                    <strong style="color: #007bff;">#{{ $transaction->id }}</strong>
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Date & Time</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->created_at->format('d M Y, h:i A') }}
                                                    <small style="color: #999;">({{ $transaction->created_at->diffForHumans() }})</small>
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Status</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span
                                                    class="status-badge-large bg-{{ $transaction->status_badge_color }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Payout Status</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span
                                                    class="status-badge-large bg-{{ $transaction->payout_status_badge_color }}">
                                                    {{ ucfirst($transaction->payout_status) }}
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buyer & Seller Information -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px; color: #333;">
                                    <i class="fa-solid fa-users"></i> Parties Involved
                                </h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div style="background: #e3f2fd; padding: 15px; border-radius: 6px;">
                                            <h6 style="color: #1976d2; margin-bottom: 10px;">
                                                <i class="fa-solid fa-shopping-cart"></i> Buyer
                                            </h6>
                                            <p style="margin: 5px 0;">
                                                <strong>Name:</strong> {{ $transaction->buyer->first_name ?? 'N/A' }}
                                            </p>
                                            <p style="margin: 5px 0;">
                                                <strong>Email:</strong> {{ $transaction->buyer->email ?? 'N/A' }}
                                            </p>
                                            <p style="margin: 5px 0;">
                                                <strong>ID:</strong> #{{ $transaction->buyer_id }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div style="background: #e8f5e9; padding: 15px; border-radius: 6px;">
                                            <h6 style="color: #388e3c; margin-bottom: 10px;">
                                                <i class="fa-solid fa-store"></i> Seller
                                            </h6>
                                            <p style="margin: 5px 0;">
                                                <strong>Name:</strong> {{ $transaction->seller->first_name ?? 'N/A' }}
                                            </p>
                                            <p style="margin: 5px 0;">
                                                <strong>Email:</strong> {{ $transaction->seller->email ?? 'N/A' }}
                                            </p>
                                            <p style="margin: 5px 0;">
                                                <strong>ID:</strong> #{{ $transaction->seller_id }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Service/Class Information -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px; color: #333;">
                                    <i class="fa-solid fa-box"></i> Service/Class Information
                                </h5>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Type</span>
                                        </div>
                                        <div class="col-md-8">
                                            <span
                                                class="badge bg-primary">{{ ucfirst($transaction->service_type) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Service/Class ID</span>
                                        </div>
                                        <div class="col-md-8">
                                            <span class="detail-value">#{{ $transaction->service_id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stripe Information -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px; color: #333;">
                                    <i class="fa-brands fa-stripe"></i> Stripe Payment Details
                                </h5>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Stripe Transaction ID</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->stripe_transaction_id ?? 'N/A' }}
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Stripe Payout ID</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->stripe_payout_id ?? 'Pending' }}
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-row">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="detail-label">Stripe Amount</span>
                                        </div>
                                        <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->stripe_currency }} {{ number_format($transaction->stripe_amount, 2) }}
                                                    @if($transaction->currency != $transaction->stripe_currency)
                                                        <small style="color: #999;">(Converted from {{ $transaction->currency }})</small>
                                                    @endif
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                @if($transaction->paid_at)
                                    <div class="detail-row">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="detail-label">Paid At</span>
                                            </div>
                                            <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->paid_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($transaction->payout_at)
                                    <div class="detail-row">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span class="detail-label">Payout At</span>
                                            </div>
                                            <div class="col-md-8">
                                                <span class="detail-value">
                                                    {{ $transaction->payout_at->format('d M Y, h:i A') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Notes -->
                            @if($transaction->notes)
                                <div class="detail-card">
                                    <h5 style="margin-bottom: 15px; color: #333;">
                                        <i class="fa-solid fa-note-sticky"></i> Notes
                                    </h5>
                                    <p style="background: #fff3cd; padding: 15px; border-radius: 6px; margin: 0;">
                                        {{ $transaction->notes }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">

                            <!-- Amount Summary -->
                            <div class="amount-box">
                                <p style="margin: 0; opacity: 0.9; font-size: 14px;">Total Amount</p>
                                <h2>@currency($transaction->total_amount)</h2>
                                <small>{{ $transaction->currency }}</small>
                            </div>

                            <!-- Commission Breakdown -->
                            <div class="detail-card">
                                <h6 style="margin-bottom: 15px; color: #333;">
                                    <i class="fa-solid fa-chart-pie"></i> Commission Breakdown
                                </h6>

                                <div class="commission-breakdown">
                                    <div style="margin-bottom: 15px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span style="color: #666;">Seller Commission Rate:</span>
                                            <strong style="color: #dc3545;">{{ $transaction->seller_commission_rate }}
                                                %</strong>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="color: #666;">Amount:</span>
                                            <strong
                                                style="color: #dc3545;">@currency($transaction->seller_commission_amount)</strong>
                                        </div>
                                    </div>

                                    @if($transaction->buyer_commission_amount > 0)
                                        <div
                                            style="margin-bottom: 15px; padding-top: 15px; border-top: 1px solid #dee2e6;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span style="color: #666;">Buyer Commission Rate:</span>
                                                <strong
                                                    style="color: #fd7e14;">{{ $transaction->buyer_commission_rate }}
                                                    %</strong>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span style="color: #666;">Amount:</span>
                                                <strong
                                                    style="color: #fd7e14;">@currency($transaction->buyer_commission_amount)</strong>
                                            </div>
                                        </div>
                                    @endif

                                    <div style="padding-top: 15px; border-top: 2px solid #dee2e6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="font-weight: 600; color: #333;">Total Admin Commission:</span>
                                            <strong style="color: #28a745; font-size: 18px;">
                                                @currency($transaction->total_admin_commission)
                                            </strong>
                                        </div>
                                    </div>

                                    <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #dee2e6;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="font-weight: 600; color: #333;">Seller Earnings:</span>
                                            <strong style="color: #007bff; font-size: 18px;">
                                                @currency($transaction->seller_earnings)
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                @if($transaction->coupon_discount > 0)
                                    <div
                                        style="margin-top: 15px; padding: 10px; background: #fff3cd; border-radius: 6px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="font-size: 13px;">
                                                <i class="fa-solid fa-tag"></i> Coupon Discount:
                                            </span>
                                            <strong style="color: #856404;">
                                                @currency($transaction->coupon_discount)
                                            </strong>
                                        </div>
                                        @if($transaction->admin_absorbed_discount)
                                            <small style="color: #856404; display: block; margin-top: 5px;">
                                                ⚠️ Discount absorbed by admin
                                            </small>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Transaction Timeline -->
                            <div class="detail-card">
                                <h6 style="margin-bottom: 15px; color: #333;">
                                    <i class="fa-solid fa-clock"></i> Transaction Timeline
                                </h6>

                                <div class="timeline-item">
                                    <i class="fa-solid fa-plus-circle" style="color: #007bff;"></i>
                                    <strong style="display: block; margin: 5px 0;">Created</strong>
                                    <small>{{ $transaction->created_at->format('d M Y, h:i A') }}</small>
                                </div>

                                @if($transaction->paid_at)
                                    <div class="timeline-item" style="border-left-color: #28a745;">
                                        <i class="fa-solid fa-check-circle" style="color: #28a745;"></i>
                                        <strong style="display: block; margin: 5px 0;">Payment Completed</strong>
                                        <small>{{ $transaction->paid_at->format('d M Y, h:i A') }}</small>
                                    </div>
                                @endif

                                @if($transaction->payout_at)
                                    <div class="timeline-item" style="border-left-color: #17a2b8;">
                                        <i class="fa-solid fa-money-bill-transfer" style="color: #17a2b8;"></i>
                                        <strong style="display: block; margin: 5px 0;">Payout Completed</strong>
                                        <small>{{ $transaction->payout_at->format('d M Y, h:i A') }}</small>
                                    </div>
                                @endif

                                @if($transaction->status == 'refunded')
                                    <div class="timeline-item" style="border-left-color: #dc3545;">
                                        <i class="fa-solid fa-rotate-left" style="color: #dc3545;"></i>
                                        <strong style="display: block; margin: 5px 0;">Refunded</strong>
                                        <small>{{ $transaction->updated_at->format('d M Y, h:i A') }}</small>
                                    </div>
                                @endif
                            </div>

                            <!-- Quick Actions -->
                            <div class="detail-card">
                                <h6 style="margin-bottom: 15px; color: #333;">
                                    <i class="fa-solid fa-bolt"></i> Quick Actions
                                </h6>

                                @if($transaction->status == 'completed' && $transaction->payout_status == 'pending')
                                    <button class="btn btn-success w-100 mb-2"
                                            onclick="markPayoutCompleted({{ $transaction->id }})">
                                        <i class="fa-solid fa-money-bill-transfer"></i> Mark Payout as Completed
                                    </button>
                                @endif

                                @if($transaction->status == 'completed' && $transaction->status != 'refunded')
                                    <button class="btn btn-warning w-100 mb-2"
                                            onclick="initiateRefund({{ $transaction->id }})">
                                        <i class="fa-solid fa-rotate-left"></i> Initiate Refund
                                    </button>
                                @endif

                                <a href="/admin/commission-report/print/{{ $transaction->id }}"
                                   class="btn btn-primary w-100 mb-2" target="_blank">
                                    <i class="fa-solid fa-print"></i> Print Receipt
                                </a>

                                <a href="/admin/commission-report/download-invoice/{{ $transaction->id }}"
                                   class="btn btn-info w-100">
                                    <i class="fa-solid fa-download"></i> Download Invoice
                                </a>
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

<!-- Mark Payout Completed Modal -->
<div class="modal fade" id="payoutModal" tabindex="-1" aria-labelledby="payoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="payoutModalLabel">
                    <i class="fa-solid fa-money-bill-transfer"></i> Mark Payout as Completed
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="payoutForm" action="/admin/transaction/mark-payout-completed/{{ $transaction->id }}"
                  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="stripe_payout_id" class="form-label">Stripe Payout ID (Optional)</label>
                        <input type="text" class="form-control" id="stripe_payout_id" name="stripe_payout_id"
                               placeholder="po_xxxxxxxxxxxxx">
                        <small class="text-muted">Enter the Stripe payout ID if available</small>
                    </div>

                    <div class="alert alert-info" role="alert">
                        <strong>Seller Earnings:</strong> @currency($transaction->seller_earnings)
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check"></i> Confirm Payout
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Refund Confirmation Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="refundModalLabel">
                    <i class="fa-solid fa-rotate-left"></i> Confirm Refund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/transaction/refund/{{ $transaction->id }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p><strong>Are you sure you want to refund this transaction?</strong></p>

                    <div class="alert alert-warning" role="alert">
                        <ul style="margin: 0; padding-left: 20px;">
                            <li>Refund Amount: <strong>@currency($transaction->total_amount)</strong></li>
                            <li>Admin commission will be reversed</li>
                            <li>Seller earnings will be deducted</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label for="refund_reason" class="form-label">Reason for Refund</label>
                        <textarea class="form-control" id="refund_reason" name="refund_reason" rows="3"
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-rotate-left"></i> Process Refund
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script>
    function markPayoutCompleted(transactionId) {
        var payoutModal = new bootstrap.Modal(document.getElementById('payoutModal'));
        payoutModal.show();
    }

    function initiateRefund(transactionId) {
        var refundModal = new bootstrap.Modal(document.getElementById('refundModal'));
        refundModal.show();
    }
</script>
</body>
</html>
