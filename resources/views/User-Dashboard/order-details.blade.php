<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Animate css -->
    <link rel="stylesheet" href="/assets/admin/libs/animate/css/animate.css" />
    <!-- AOS Animation css-->
    <link rel="stylesheet" href="/assets/admin/libs/aos/css/aos.css" />

    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{ $home->fav_icon }}" type="image/x-icon">
    @endif

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />

    <title>Order Details - {{ $order->order_number }} | My Dashboard</title>

    <style>
        .order-details-container {
            padding: 30px;
            background: #f8f9fa;
            min-height: 100vh;
        }

        .order-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .order-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .order-header .order-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .order-meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .order-meta-item i {
            font-size: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-pending { background-color: #ffc107; color: #000; }
        .status-active { background-color: #28a745; color: white; }
        .status-delivered { background-color: #17a2b8; color: white; }
        .status-completed { background-color: #007bff; color: white; }
        .status-cancelled { background-color: #dc3545; color: white; }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-card-header i {
            font-size: 24px;
            color: #667eea;
        }

        .info-card-header h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
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
            font-weight: 600;
            color: #666;
        }

        .info-value {
            color: #333;
            text-align: right;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e0e0e0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -26px;
            top: 5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: white;
            border: 3px solid #667eea;
        }

        .timeline-item.completed::before {
            background: #28a745;
            border-color: #28a745;
        }

        .timeline-item.active::before {
            background: #667eea;
            border-color: #667eea;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
        }

        .participant-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .participant-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .participant-info h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
        }

        .participant-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .payment-total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        .payment-total h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }

        .payment-total .amount {
            font-size: 32px;
            font-weight: 700;
        }

        .class-schedule-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .class-schedule-item.completed {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }

        .class-schedule-item.upcoming {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
        }

        .btn-action {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-danger-custom {
            background: #dc3545;
            color: white;
        }

        .btn-success-custom {
            background: #28a745;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
        }

        .stat-card i {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .stat-card .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .stat-card .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .alert-custom {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-danger-custom {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .alert-success-custom {
            background: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }

        @media (max-width: 768px) {
            .order-details-container {
                padding: 15px;
            }

            .order-header h1 {
                font-size: 22px;
            }

            .order-header .order-meta {
                flex-direction: column;
                gap: 15px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }

            .class-schedule-item {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    {{-- ===========User Sidebar Start==================== --}}
    <x-user-sidebar />
    {{-- ===========User Sidebar End==================== --}}

    <section class="home-section">
        <div class="order-details-container">
            <!-- Order Header -->
            <div class="order-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h1><i class='bx bx-receipt'></i> {{ $order->order_number }}</h1>
                        <p style="margin: 0; opacity: 0.9;">Your order details and class schedule</p>
                    </div>
                    <div>
                        @php
                            $statusClasses = [
                                0 => 'status-pending',
                                1 => 'status-active',
                                2 => 'status-delivered',
                                3 => 'status-completed',
                                4 => 'status-cancelled'
                            ];
                            $statusNames = [
                                0 => 'Pending',
                                1 => 'Active',
                                2 => 'Delivered',
                                3 => 'Completed',
                                4 => 'Cancelled'
                            ];
                        @endphp
                        <span class="status-badge {{ $statusClasses[$order->status] ?? 'status-pending' }}">
                            {{ $statusNames[$order->status] ?? 'Unknown' }}
                        </span>
                    </div>
                </div>

                <div class="order-meta">
                    <div class="order-meta-item">
                        <i class='bx bx-calendar'></i>
                        <div>
                            <small style="opacity: 0.8;">Order Date</small><br>
                            <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                        </div>
                    </div>
                    <div class="order-meta-item">
                        <i class='bx bx-time'></i>
                        <div>
                            <small style="opacity: 0.8;">Last Updated</small><br>
                            <strong>{{ $order->updated_at->format('M d, Y H:i') }}</strong>
                        </div>
                    </div>
                    <div class="order-meta-item">
                        <i class='bx bx-book'></i>
                        <div>
                            <small style="opacity: 0.8;">Service Type</small><br>
                            <strong>{{ ucfirst($order->gig->service_type ?? 'N/A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Alerts -->
            @if($order->user_disputed || $order->teacher_disputed)
                <div class="alert-custom alert-danger-custom">
                    <i class='bx bx-error-circle' style="font-size: 24px;"></i>
                    <div>
                        <strong>Dispute Active!</strong>
                        @if($order->user_disputed && $order->teacher_disputed)
                            Both you and the seller have raised disputes on this order.
                        @elseif($order->user_disputed)
                            You have raised a dispute on this order.
                        @else
                            Seller has raised a dispute on this order.
                        @endif
                    </div>
                </div>
            @endif

            @if($order->status == 3)
                <div class="alert-custom alert-success-custom">
                    <i class='bx bx-check-circle' style="font-size: 24px;"></i>
                    <div>
                        <strong>Order Completed!</strong>
                        This order has been successfully completed. Thank you for your purchase!
                    </div>
                </div>
            @endif

            <!-- Quick Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class='bx bx-dollar-circle' style="color: #28a745;"></i>
                    <div class="stat-value">${{ number_format($order->service_price + $order->commission + $order->tex_percent, 2) }}</div>
                    <div class="stat-label">Total Paid</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-calendar-event' style="color: #667eea;"></i>
                    <div class="stat-value">{{ $order->classDates->count() }}</div>
                    <div class="stat-label">Total Classes</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-check-circle' style="color: #17a2b8;"></i>
                    <div class="stat-value">{{ $order->classDates->where('status', 1)->count() }}</div>
                    <div class="stat-label">Attended Classes</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-time-five' style="color: #ffc107;"></i>
                    <div class="stat-value">{{ $order->classDates->where('status', 0)->count() }}</div>
                    <div class="stat-label">Upcoming Classes</div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Order Timeline -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-chart'></i>
                            <h3>Order Progress</h3>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item completed">
                                <strong>Order Created</strong>
                                <p style="color: #666; margin: 5px 0 0 0;">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            @if($order->status >= 1)
                                <div class="timeline-item completed">
                                    <strong>Payment Confirmed</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Your payment was successful</p>
                                </div>
                            @endif
                            @if($order->status >= 2)
                                <div class="timeline-item completed">
                                    <strong>Service Delivered</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">{{ $order->action_date ? \Carbon\Carbon::parse($order->action_date)->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                            @endif
                            @if($order->status == 3)
                                <div class="timeline-item completed">
                                    <strong>Order Completed</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Thank you for your business!</p>
                                </div>
                            @elseif($order->status == 4)
                                <div class="timeline-item" style="border-color: #dc3545;">
                                    <strong>Order Cancelled</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">This order has been cancelled</p>
                                </div>
                            @else
                                <div class="timeline-item active">
                                    <strong>In Progress</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Your order is currently active</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Service Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-package'></i>
                            <h3>Service Information</h3>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Service Title</span>
                            <span class="info-value"><strong>{{ $order->gig->teacherGigData->title ?? 'N/A' }}</strong></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Category</span>
                            <span class="info-value">{{ $order->gig->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Sub-Category</span>
                            <span class="info-value">{{ $order->gig->subCategory->name ?? 'N/A' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Service Type</span>
                            <span class="info-value">{{ ucfirst($order->gig->service_type ?? 'N/A') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Payment Mode</span>
                            <span class="info-value">{{ ucfirst($order->payment_type ?? 'N/A') }}</span>
                        </div>
                    </div>

                    <!-- Teacher Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-user'></i>
                            <h3>Your Teacher</h3>
                        </div>
                        <div class="participant-card">
                            <img src="{{ $order->teacher->profile ? asset('assets/admin/asset/img/upload/' . $order->teacher->profile) : '/assets/admin/asset/img/default-avatar.png' }}"
                                 alt="Teacher" class="participant-avatar">
                            <div class="participant-info">
                                <h4>{{ $order->teacher->first_name }} {{ $order->teacher->last_name }}</h4>
                                <p><i class='bx bx-envelope'></i> {{ $order->teacher->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Class Schedule -->
                    @if($order->classDates->count() > 0)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class='bx bx-calendar-check'></i>
                                <h3>Your Class Schedule ({{ $order->classDates->count() }} Classes)</h3>
                            </div>
                            @foreach($order->classDates as $classDate)
                                <div class="class-schedule-item {{ $classDate->status == 1 ? 'completed' : 'upcoming' }}">
                                    <div>
                                        <strong>{{ \Carbon\Carbon::parse($classDate->date)->format('M d, Y') }}</strong><br>
                                        <small>{{ \Carbon\Carbon::parse($classDate->date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($classDate->end_time)->format('h:i A') }}</small>
                                    </div>
                                    <div>
                                        @if($classDate->status == 1)
                                            <span class="badge bg-success">Attended</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Upcoming</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Reschedule Requests -->
                    @if($order->classReschedules->count() > 0)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class='bx bx-calendar-edit'></i>
                                <h3>Reschedule Requests</h3>
                            </div>
                            @foreach($order->classReschedules as $reschedule)
                                <div class="info-row">
                                    <div>
                                        <strong>Reschedule Request</strong><br>
                                        <small>{{ \Carbon\Carbon::parse($reschedule->created_at)->format('M d, Y H:i') }}</small>
                                    </div>
                                    <div>
                                        @if($reschedule->status == 0)
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($reschedule->status == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Dispute Information -->
                    @if($order->disputeOrder)
                        <div class="info-card" style="border-left: 4px solid #dc3545;">
                            <div class="info-card-header">
                                <i class='bx bx-error-circle' style="color: #dc3545;"></i>
                                <h3>Dispute Details</h3>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Dispute Filed</span>
                                <span class="info-value">
                                    {{ $order->disputeOrder->created_at->format('M d, Y') }}
                                    <small style="color: #666;">at {{ $order->disputeOrder->created_at->format('h:i A') }}</small>
                                </span>
                            </div>
                            @if($order->disputeOrder->created_at != $order->disputeOrder->updated_at)
                                <div class="info-row">
                                    <span class="info-label">Last Updated</span>
                                    <span class="info-value">
                                        {{ $order->disputeOrder->updated_at->format('M d, Y') }}
                                        <small style="color: #666;">at {{ $order->disputeOrder->updated_at->format('h:i A') }}</small>
                                    </span>
                                </div>
                            @endif
                            <div class="info-row">
                                <span class="info-label">Refund Type</span>
                                <span class="info-value">
                                    @if($order->disputeOrder->refund_type == 0)
                                        <span class="badge bg-danger">Full Refund</span>
                                    @else
                                        <span class="badge bg-warning">Partial Refund</span>
                                    @endif
                                </span>
                            </div>
                            @if($order->disputeOrder->amount)
                                <div class="info-row">
                                    <span class="info-label">Refund Amount</span>
                                    <span class="info-value"><strong>${{ number_format($order->disputeOrder->amount, 2) }}</strong></span>
                                </div>
                            @endif

                            <!-- Timeline Style Display -->
                            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                @if($order->disputeOrder->user_reason)
                                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <i class='bx bx-user-circle' style="font-size: 20px; color: #007bff; margin-right: 8px;"></i>
                                            <strong style="color: #007bff;">Your Dispute Reason</strong>
                                        </div>
                                        <p style="margin: 0; padding-left: 28px; color: #333;">{{ $order->disputeOrder->user_reason }}</p>
                                    </div>
                                @endif

                                @if($order->disputeOrder->teacher_reason)
                                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <i class='bx bx-store' style="font-size: 20px; color: #fd7e14; margin-right: 8px;"></i>
                                            <strong style="color: #fd7e14;">Seller's Counter-Reason</strong>
                                        </div>
                                        <p style="margin: 0; padding-left: 28px; color: #333;">{{ $order->disputeOrder->teacher_reason }}</p>
                                    </div>
                                @endif

                                @if($order->disputeOrder->admin_notes)
                                    <div style="margin-bottom: 0;">
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <i class='bx bx-shield-alt' style="font-size: 20px; color: #6f42c1; margin-right: 8px;"></i>
                                            <strong style="color: #6f42c1;">Admin Decision & Notes</strong>
                                        </div>
                                        <p style="margin: 0; padding-left: 28px; color: #333;">{{ $order->disputeOrder->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="info-row" style="margin-top: 15px;">
                                <span class="info-label">Current Status</span>
                                <span class="info-value">
                                    @if($order->disputeOrder->status == 0)
                                        <span class="badge bg-warning">⏳ Pending Admin Review</span>
                                    @elseif($order->disputeOrder->status == 1)
                                        <span class="badge bg-success">✓ Approved - Refunded</span>
                                    @else
                                        <span class="badge bg-danger">✗ Rejected</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Review Section -->
                    @if($order->reviews->count() > 0)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class='bx bx-star'></i>
                                <h3>Your Review</h3>
                            </div>
                            @foreach($order->reviews as $review)
                                <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <strong>Your Rating</strong>
                                        <div>
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class='bx {{ $i <= $review->rating ? "bxs-star" : "bx-star" }}' style="color: #ffc107;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <p style="margin: 0; color: #666;">{{ $review->cmnt }}</p>
                                    <small style="color: #999;">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Payment Breakdown -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-dollar-circle'></i>
                            <h3>Payment Summary</h3>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Service Price</span>
                            <span class="info-value">${{ number_format($order->service_price, 2) }}</span>
                        </div>
                        @if($order->coupon_discount > 0)
                            <div class="info-row">
                                <span class="info-label">Coupon Discount</span>
                                <span class="info-value" style="color: #28a745;">-${{ number_format($order->coupon_discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Commission</span>
                            <span class="info-value">${{ number_format($order->commission, 2) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tax</span>
                            <span class="info-value">${{ number_format($order->tex_percent, 2) }}</span>
                        </div>
                        <div class="payment-total">
                            <h3>Total Paid</h3>
                            <div class="amount">${{ number_format($order->service_price + $order->commission + $order->tex_percent, 2) }}</div>
                            @if($order->transaction)
                                <small style="opacity: 0.9;">Payment ID: {{ $order->transaction->payment_id ?? 'N/A' }}</small>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-cog'></i>
                            <h3>Quick Actions</h3>
                        </div>
                        <div class="d-grid gap-3">
                            <a href="/order-management" class="btn btn-secondary">
                                <i class='bx bx-arrow-back'></i> Back to Orders
                            </a>
                            @if($order->transaction)
                                <a href="{{ route('transaction.invoice', $order->transaction->id) }}" class="btn btn-info btn-action">
                                    <i class='bx bx-download'></i> Download Invoice
                                </a>
                            @endif
                            <a href="/user-messages" class="btn btn-primary-custom btn-action">
                                <i class='bx bx-message-dots'></i> Message Teacher
                            </a>
                            @if($order->status == 3 && $order->reviews->count() == 0)
                                <a href="/reviews" class="btn btn-success-custom btn-action">
                                    <i class='bx bx-star'></i> Leave a Review
                                </a>
                            @endif
                            @if(($order->status == 1 || $order->status == 2) && !$order->user_disputed && $order->status != 4)
                                <button type="button" class="btn btn-danger-custom btn-action" data-bs-toggle="modal" data-bs-target="#disputeModal">
                                    <i class='bx bx-error-circle'></i> Request Refund
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Need Help? -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-help-circle'></i>
                            <h3>Need Help?</h3>
                        </div>
                        <p style="color: #666; margin-bottom: 15px;">If you have any issues with your order, please contact support.</p>
                        <div class="d-grid gap-2">
                            <a href="/user-contact-us" class="btn btn-outline-primary">
                                <i class='bx bx-envelope'></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dispute/Refund Request Modal -->
    @if(($order->status == 1 || $order->status == 2) && !$order->user_disputed && $order->status != 4)
    <div class="modal fade" id="disputeModal" tabindex="-1" aria-labelledby="disputeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
                    <h5 class="modal-title" id="disputeModalLabel">
                        <i class='bx bx-error-circle'></i> Request Refund for Order #{{ $order->order_number }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('DisputeOrder') }}" method="POST" id="disputeForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-start gap-2" style="font-size: 14px;">
                            <i class='bx bx-info-circle' style="font-size: 20px; flex-shrink: 0;"></i>
                            <div>
                                <strong>Important:</strong> If the seller doesn't respond within 48 hours, your refund will be processed automatically.
                                Please provide a clear reason for your refund request.
                            </div>
                        </div>

                        <!-- Refund Type Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Refund Type <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="refund_type" id="fullRefund" value="0" checked onchange="toggleAmountField()">
                                    <label class="form-check-label" for="fullRefund">
                                        <strong>Full Refund</strong><br>
                                        <small class="text-muted">Get back the entire amount (${{ number_format($order->finel_price, 2) }})</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="refund_type" id="partialRefund" value="1" onchange="toggleAmountField()">
                                    <label class="form-check-label" for="partialRefund">
                                        <strong>Partial Refund</strong><br>
                                        <small class="text-muted">Request a specific amount</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Amount (shown for partial refund) -->
                        <div class="mb-3" id="amountField" style="display: none;">
                            <label for="refundAmount" class="form-label fw-bold">Refund Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       class="form-control"
                                       id="refundAmount"
                                       name="amount"
                                       step="0.01"
                                       min="0.01"
                                       max="{{ $order->finel_price }}"
                                       placeholder="Enter amount">
                            </div>
                            <small class="text-muted">Maximum refund amount: ${{ number_format($order->finel_price, 2) }}</small>
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label for="disputeReason" class="form-label fw-bold">Reason for Refund Request <span class="text-danger">*</span></label>
                            <textarea class="form-control"
                                      id="disputeReason"
                                      name="reason"
                                      rows="5"
                                      required
                                      placeholder="Please provide a detailed explanation for your refund request. Include specific details about why the service did not meet your expectations."></textarea>
                            <small class="text-muted">Provide a clear and detailed explanation to help us process your request faster.</small>
                        </div>

                        <!-- Order Information Summary -->
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #667eea;">
                            <h6 class="mb-2"><i class='bx bx-info-circle'></i> Order Information</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Service:</small>
                                <small><strong>{{ $order->gig->teacherGigData->title ?? 'N/A' }}</strong></small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Order Date:</small>
                                <small>{{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Total Paid:</small>
                                <small><strong>${{ number_format($order->finel_price, 2) }}</strong></small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger" id="submitDisputeBtn">
                            <i class='bx bx-send'></i> Submit Refund Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery -->
    <script src="/assets/admin/libs/jquery/js/jquery.min.js"></script>
    <!-- Bootstrap js -->
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/asset/js/sidebar.js"></script>

    <script>
        // Toggle amount field visibility based on refund type selection
        function toggleAmountField() {
            const partialRefund = document.getElementById('partialRefund');
            const amountField = document.getElementById('amountField');
            const refundAmountInput = document.getElementById('refundAmount');

            if (partialRefund && partialRefund.checked) {
                amountField.style.display = 'block';
                refundAmountInput.required = true;
            } else {
                amountField.style.display = 'none';
                refundAmountInput.required = false;
                refundAmountInput.value = ''; // Clear value when hidden
            }
        }

        // Form validation before submission
        document.getElementById('disputeForm')?.addEventListener('submit', function(e) {
            const partialRefund = document.getElementById('partialRefund');
            const refundAmount = document.getElementById('refundAmount');
            const maxAmount = {{ $order->finel_price }};

            if (partialRefund && partialRefund.checked) {
                const amount = parseFloat(refundAmount.value);

                if (!amount || amount <= 0) {
                    e.preventDefault();
                    alert('Please enter a valid refund amount.');
                    refundAmount.focus();
                    return false;
                }

                if (amount > maxAmount) {
                    e.preventDefault();
                    alert('Refund amount cannot exceed $' + maxAmount.toFixed(2));
                    refundAmount.focus();
                    return false;
                }
            }

            // Confirm submission
            const confirmed = confirm('Are you sure you want to submit this refund request? This action cannot be undone.');
            if (!confirmed) {
                e.preventDefault();
                return false;
            }

            // Disable submit button to prevent double submission
            document.getElementById('submitDisputeBtn').disabled = true;
        });
    </script>
</body>

</html>
