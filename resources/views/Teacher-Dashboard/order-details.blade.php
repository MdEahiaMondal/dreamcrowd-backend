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

    <title>Order Details - {{ $order->order_number }} | Teacher Dashboard</title>

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
    {{-- ===========Teacher Sidebar Start==================== --}}
    <x-teacher-sidebar />
    {{-- ===========Teacher Sidebar End==================== --}}

    <section class="home-section">
        <div class="order-details-container">
            <!-- Order Header -->
            <div class="order-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div>
                        <h1><i class='bx bx-receipt'></i> {{ $order->order_number }}</h1>
                        <p style="margin: 0; opacity: 0.9;">Complete order information</p>
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

            <!-- Pending Refund Request Alert (Buyer disputed, seller hasn't responded yet) -->
            @if($order->user_disputed && !$order->teacher_disputed && $order->disputeOrder)
                @php
                    $disputeCreated = \Carbon\Carbon::parse($order->disputeOrder->created_at);
                    $hoursElapsed = $disputeCreated->diffInHours(now());
                    $hoursRemaining = max(0, 48 - $hoursElapsed);
                    $minutesRemaining = max(0, (48 * 60) - $disputeCreated->diffInMinutes(now())) % 60;
                @endphp
                <div class="info-card" style="border: 3px solid #dc3545; background: linear-gradient(to right, #fff5f5, #fff);">
                    <div class="d-flex align-items-start gap-3">
                        <div style="font-size: 48px; color: #dc3545;">
                            <i class='bx bx-error-circle'></i>
                        </div>
                        <div style="flex: 1;">
                            <h3 style="color: #dc3545; margin-bottom: 10px;">
                                <i class='bx bx-bell-ring' style="animation: shake 0.5s infinite;"></i> Urgent: Refund Request Pending
                            </h3>
                            <p style="font-size: 16px; margin-bottom: 15px; color: #333;">
                                The buyer has requested a <strong>{{ $order->disputeOrder->refund_type == 0 ? 'FULL' : 'PARTIAL' }} REFUND</strong>
                                of <strong style="color: #dc3545;">@currency($order->disputeOrder->amount ?? $order->finel_price)</strong>.
                            </p>

                            <!-- Countdown Timer -->
                            <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107; margin-bottom: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <i class='bx bx-time-five' style="font-size: 24px; color: #856404;"></i>
                                    <strong style="font-size: 18px; color: #856404;">Time Remaining to Respond:</strong>
                                </div>
                                <div style="font-size: 28px; font-weight: bold; color: #dc3545; font-family: monospace;">
                                    {{ $hoursRemaining }}h {{ $minutesRemaining }}m
                                </div>
                                <small style="color: #856404;">
                                    ⚠️ If you don't respond within 48 hours, the refund will be processed automatically
                                </small>
                            </div>

                            <!-- Buyer's Reason -->
                            @if($order->disputeOrder->user_reason)
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #007bff; margin-bottom: 15px;">
                                    <strong style="color: #007bff; display: block; margin-bottom: 8px;">
                                        <i class='bx bx-user-circle'></i> Buyer's Refund Reason:
                                    </strong>
                                    <p style="margin: 0; color: #333; font-style: italic;">"{{ $order->disputeOrder->user_reason }}"</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="button"
                                        class="btn btn-success btn-lg"
                                        onclick="acceptRefund()"
                                        style="flex: 1; min-width: 200px;">
                                    <i class='bx bx-check-circle'></i> Accept Refund & Process
                                </button>
                                <button type="button"
                                        class="btn btn-danger btn-lg"
                                        data-bs-toggle="modal"
                                        data-bs-target="#counterDisputeModal"
                                        style="flex: 1; min-width: 200px;">
                                    <i class='bx bx-shield-x'></i> Counter-Dispute with Reason
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes shake {
                        0%, 100% { transform: translateX(0); }
                        25% { transform: translateX(-5px); }
                        75% { transform: translateX(5px); }
                    }
                </style>
            @endif

            <!-- Dispute Alert -->
            @if($order->user_disputed || $order->teacher_disputed)
                <div class="alert-custom alert-danger-custom">
                    <i class='bx bx-error-circle' style="font-size: 24px;"></i>
                    <div>
                        <strong>Dispute Active!</strong>
                        @if($order->user_disputed && $order->teacher_disputed)
                            Both buyer and you have raised disputes on this order.
                        @elseif($order->user_disputed)
                            Buyer has raised a dispute on this order.
                        @else
                            You have raised a dispute on this order.
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class='bx bx-dollar-circle' style="color: #28a745;"></i>
                    <div class="stat-value">@currency($order->service_price)</div>
                    <div class="stat-label">Service Price</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-calendar-event' style="color: #667eea;"></i>
                    <div class="stat-value">{{ $order->classDates->count() }}</div>
                    <div class="stat-label">Total Classes</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-check-circle' style="color: #17a2b8;"></i>
                    <div class="stat-value">{{ $order->classDates->where('status', 1)->count() }}</div>
                    <div class="stat-label">Completed Classes</div>
                </div>
                <div class="stat-card">
                    <i class='bx bx-time-five' style="color: #ffc107;"></i>
                    <div class="stat-value">{{ $order->classDates->where('status', 0)->count() }}</div>
                    <div class="stat-label">Pending Classes</div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- Order Timeline -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-chart'></i>
                            <h3>Order Timeline</h3>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item completed">
                                <strong>Order Created</strong>
                                <p style="color: #666; margin: 5px 0 0 0;">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            @if($order->status >= 1)
                                <div class="timeline-item completed">
                                    <strong>Payment Confirmed</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Order activated and ready to start</p>
                                </div>
                            @endif
                            @if($order->status >= 2)
                                <div class="timeline-item completed">
                                    <strong>Order Delivered</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">{{ $order->action_date ? \Carbon\Carbon::parse($order->action_date)->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                            @endif
                            @if($order->status == 3)
                                <div class="timeline-item completed">
                                    <strong>Order Completed</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Transaction finalized</p>
                                </div>
                            @elseif($order->status == 4)
                                <div class="timeline-item" style="border-color: #dc3545;">
                                    <strong>Order Cancelled</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Order has been cancelled</p>
                                </div>
                            @else
                                <div class="timeline-item active">
                                    <strong>In Progress</strong>
                                    <p style="color: #666; margin: 5px 0 0 0;">Order is currently active</p>
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

                    <!-- Buyer Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-user'></i>
                            <h3>Buyer Information</h3>
                        </div>
                        <div class="participant-card">
                            <img src="{{ $order->user->profile ? asset('assets/admin/asset/img/upload/' . $order->user->profile) : '/assets/admin/asset/img/default-avatar.png' }}"
                                 alt="Buyer" class="participant-avatar">
                            <div class="participant-info">
                                <h4>{{ $order->user->first_name }} {{ $order->user->last_name }}</h4>
                                <p><i class='bx bx-envelope'></i> {{ $order->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Offer Milestones Management -->
                    @if($order->custom_offer_id && $order->customOffer)
                        @php
                            $milestones = $order->customOffer->milestones;
                            $completedMilestones = $milestones->whereIn('status', ['completed', 'released'])->count();
                            $totalMilestones = $milestones->count();
                            $milestoneProgress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;
                            $actionNeeded = $milestones->whereIn('status', ['pending', 'in_progress'])->count();
                        @endphp
                        <div class="info-card" style="border: 2px solid #667eea;">
                            <div class="info-card-header">
                                <i class='bx bx-list-check' style="color: #667eea;"></i>
                                <h3>Manage Milestones</h3>
                                @if($actionNeeded > 0)
                                    <span class="badge bg-warning text-dark ms-2">{{ $actionNeeded }} needs action</span>
                                @endif
                            </div>

                            {{-- Progress Bar --}}
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span style="font-weight: 600; color: #333;">Overall Progress</span>
                                    <span style="color: #667eea; font-weight: 600;">{{ $completedMilestones }}/{{ $totalMilestones }} Completed</span>
                                </div>
                                <div class="progress" style="height: 12px; border-radius: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $milestoneProgress }}%; border-radius: 6px;"
                                         aria-valuenow="{{ $milestoneProgress }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>

                            {{-- Milestones List --}}
                            @foreach($milestones as $index => $milestone)
                                <div class="milestone-card-seller milestone-{{ $milestone->status }}"
                                     style="border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; margin-bottom: 15px;
                                            @if($milestone->status == 'pending') border-left: 5px solid #6c757d; background: #fafafa;
                                            @elseif($milestone->status == 'in_progress') border-left: 5px solid #007bff; background: #f0f7ff;
                                            @elseif($milestone->status == 'delivered') border-left: 5px solid #17a2b8; background: #e8f7fa;
                                            @elseif($milestone->status == 'completed' || $milestone->status == 'released') border-left: 5px solid #28a745; background: #e8f5e9;
                                            @endif">

                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 10px;">
                                        <div>
                                            <span style="background: #667eea; color: white; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; margin-right: 10px;">
                                                Milestone #{{ $index + 1 }}
                                            </span>
                                            <strong style="font-size: 18px;">{{ $milestone->title }}</strong>
                                        </div>
                                        <span class="badge
                                            @if($milestone->status == 'pending') bg-secondary
                                            @elseif($milestone->status == 'in_progress') bg-primary
                                            @elseif($milestone->status == 'delivered') bg-info
                                            @elseif($milestone->status == 'completed' || $milestone->status == 'released') bg-success
                                            @endif"
                                            style="padding: 6px 12px; font-size: 13px;">
                                            {{ ucfirst(str_replace('_', ' ', $milestone->status)) }}
                                        </span>
                                    </div>

                                    @if($milestone->description)
                                        <p style="margin: 15px 0 0 0; color: #555;">{{ $milestone->description }}</p>
                                    @endif

                                    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 15px; color: #666; font-size: 14px;">
                                        @if($milestone->date)
                                            <span><i class='bx bx-calendar'></i> {{ $milestone->date->format('M d, Y') }}</span>
                                        @endif
                                        @if($milestone->start_time && $milestone->end_time)
                                            <span><i class='bx bx-time'></i> {{ $milestone->start_time }} - {{ $milestone->end_time }}</span>
                                        @endif
                                        @if($milestone->revisions > 0)
                                            <span><i class='bx bx-revision'></i> {{ $milestone->revisions_used }}/{{ $milestone->revisions }} Revisions Used</span>
                                        @endif
                                        @if($milestone->delivery_days)
                                            <span><i class='bx bx-package'></i> {{ $milestone->delivery_days }} days delivery</span>
                                        @endif
                                    </div>

                                    <div style="margin-top: 15px; font-weight: 700; color: #28a745; font-size: 18px;">
                                        Milestone Value: @currency($milestone->price)
                                    </div>

                                    {{-- Revision Request Alert --}}
                                    @if($milestone->revision_note && $milestone->status == 'in_progress')
                                        <div style="margin-top: 15px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                                            <strong style="color: #856404;"><i class='bx bx-info-circle'></i> Buyer Requested Revision:</strong>
                                            <p style="margin: 8px 0 0 0; color: #856404;">{{ $milestone->revision_note }}</p>
                                        </div>
                                    @endif

                                    {{-- Seller Actions Based on Status --}}
                                    <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
                                        @if($milestone->status === 'pending')
                                            <button class="btn btn-primary start-milestone-btn"
                                                    data-milestone-id="{{ $milestone->id }}"
                                                    style="padding: 10px 24px;">
                                                <i class='bx bx-play'></i> Start Working on This Milestone
                                            </button>

                                        @elseif($milestone->status === 'in_progress')
                                            <button class="btn btn-success deliver-milestone-btn"
                                                    data-milestone-id="{{ $milestone->id }}"
                                                    data-milestone-title="{{ $milestone->title }}"
                                                    style="padding: 10px 24px;">
                                                <i class='bx bx-check-double'></i> Mark as Delivered
                                            </button>
                                            <small class="d-block text-muted mt-2">
                                                <i class='bx bx-info-circle'></i> Click to deliver this milestone to the buyer for approval
                                            </small>

                                        @elseif($milestone->status === 'delivered')
                                            <div class="d-flex align-items-center" style="background: #e8f7fa; padding: 12px 16px; border-radius: 6px;">
                                                <i class='bx bx-time-five' style="font-size: 24px; color: #17a2b8; margin-right: 12px;"></i>
                                                <div>
                                                    <strong style="color: #0c5460;">Awaiting Buyer Approval</strong>
                                                    <p style="margin: 0; color: #666; font-size: 13px;">The buyer will review and approve, or request revisions</p>
                                                </div>
                                            </div>
                                            @if($milestone->delivery_note)
                                                <div style="margin-top: 10px; padding: 10px; background: #f8f9fa; border-radius: 6px;">
                                                    <small class="text-muted"><strong>Your delivery note:</strong> {{ $milestone->delivery_note }}</small>
                                                </div>
                                            @endif

                                        @elseif($milestone->status === 'completed' || $milestone->status === 'released')
                                            <div class="d-flex align-items-center" style="background: #d4edda; padding: 12px 16px; border-radius: 6px;">
                                                <i class='bx bx-check-circle' style="font-size: 24px; color: #28a745; margin-right: 12px;"></i>
                                                <div>
                                                    <strong style="color: #155724;">Milestone Completed!</strong>
                                                    <p style="margin: 0; color: #666; font-size: 13px;">
                                                        Completed on {{ $milestone->completed_at ? $milestone->completed_at->format('M d, Y H:i') : 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Class Schedule -->
                    @if($order->classDates->count() > 0)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class='bx bx-calendar-check'></i>
                                <h3>Class Schedule ({{ $order->classDates->count() }} Classes)</h3>
                            </div>
                            @foreach($order->classDates as $classDate)
                                <div class="class-schedule-item {{ $classDate->status == 1 ? 'completed' : 'upcoming' }}">
                                    <div>
                                        <strong>{{ \Carbon\Carbon::parse($classDate->date)->format('M d, Y') }}</strong><br>
                                        <small>{{ \Carbon\Carbon::parse($classDate->date)->format('h:i A') }} - {{ \Carbon\Carbon::parse($classDate->end_time)->format('h:i A') }}</small>
                                    </div>
                                    <div>
                                        @if($classDate->status == 1)
                                            <span class="badge bg-success">Completed</span>
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
                                    <span class="info-value"><strong>@currency($order->disputeOrder->amount)</strong></span>
                                </div>
                            @endif

                            <!-- Timeline Style Display -->
                            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                @if($order->disputeOrder->user_reason)
                                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <i class='bx bx-user-circle' style="font-size: 20px; color: #007bff; margin-right: 8px;"></i>
                                            <strong style="color: #007bff;">Buyer's Dispute Reason</strong>
                                        </div>
                                        <p style="margin: 0; padding-left: 28px; color: #333;">{{ $order->disputeOrder->user_reason }}</p>
                                    </div>
                                @endif

                                @if($order->disputeOrder->teacher_reason)
                                    <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            <i class='bx bx-store' style="font-size: 20px; color: #fd7e14; margin-right: 8px;"></i>
                                            <strong style="color: #fd7e14;">Your Counter-Reason</strong>
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
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Payment Information -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class='bx bx-dollar-circle'></i>
                            <h3>Payment Information</h3>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Service Price</span>
                            <span class="info-value">@currency($order->service_price)</span>
                        </div>
                        @if($order->coupon_discount > 0)
                            <div class="info-row">
                                <span class="info-label">Coupon Discount</span>
                                <span class="info-value" style="color: #28a745;">-@currency($order->coupon_discount)</span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Commission</span>
                            <span class="info-value">@currency($order->commission)</span>
                        </div>
                        <div class="payment-total">
                            <h3>Your Earnings</h3>
                            <div class="amount">@currency($order->transaction->seller_payout ?? ($order->service_price - $order->commission))</div>
                            @if($order->transaction && $order->transaction->payout_status == 1)
                                <small style="opacity: 0.9;">Payout Completed</small>
                            @else
                                <small style="opacity: 0.9;">Payout Pending</small>
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
                                <a href="{{ route('seller.transaction.invoice', $order->transaction->id) }}" class="btn btn-info btn-action">
                                    <i class='bx bx-download'></i> Download Invoice
                                </a>
                            @endif
                            <a href="/teacher-messages" class="btn btn-primary-custom btn-action">
                                <i class='bx bx-message-dots'></i> Message Buyer
                            </a>
                        </div>
                    </div>

                    <!-- Review Section -->
                    @if($order->reviews->count() > 0)
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class='bx bx-star'></i>
                                <h3>Reviews</h3>
                            </div>
                            @foreach($order->reviews as $review)
                                <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                        <strong>{{ $review->user->first_name ?? 'User' }}</strong>
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
            </div>
        </div>
    </section>

    <!-- Counter-Dispute Modal -->
    @if($order->user_disputed && !$order->teacher_disputed && $order->disputeOrder)
    <div class="modal fade" id="counterDisputeModal" tabindex="-1" aria-labelledby="counterDisputeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #fd7e14 0%, #e8590c 100%); color: white;">
                    <h5 class="modal-title" id="counterDisputeModalLabel">
                        <i class='bx bx-shield-x'></i> Counter-Dispute for Order #{{ $order->order_number }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('DisputeOrder') }}" method="POST" id="counterDisputeForm">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                    <div class="modal-body">
                        <div class="alert alert-warning d-flex align-items-start gap-2" style="font-size: 14px;">
                            <i class='bx bx-info-circle' style="font-size: 20px; flex-shrink: 0;"></i>
                            <div>
                                <strong>Important:</strong> By submitting a counter-dispute, this case will be escalated to admin review.
                                The admin will review both sides and make the final decision.
                            </div>
                        </div>

                        <!-- Buyer's Original Reason (Read-only) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Buyer's Refund Request Reason</label>
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #007bff;">
                                <p style="margin: 0; font-style: italic; color: #333;">
                                    "{{ $order->disputeOrder->user_reason }}"
                                </p>
                            </div>
                        </div>

                        <!-- Seller's Counter Reason -->
                        <div class="mb-3">
                            <label for="counterReason" class="form-label fw-bold">
                                Your Counter-Reason <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control"
                                      id="counterReason"
                                      name="reason"
                                      rows="6"
                                      required
                                      placeholder="Explain why you believe the refund request is not justified. Provide specific details about the service delivered, evidence of completion, communication records, etc."></textarea>
                            <small class="text-muted">
                                Be specific and professional. Include any evidence that supports your case (e.g., proof of delivery, completion screenshots, communication logs).
                            </small>
                        </div>

                        <!-- Order Information Summary -->
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #fd7e14;">
                            <h6 class="mb-2"><i class='bx bx-info-circle'></i> Order Information</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Service:</small>
                                <small><strong>{{ $order->gig->teacherGigData->title ?? 'N/A' }}</strong></small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Requested Refund:</small>
                                <small><strong style="color: #dc3545;">@currency($order->disputeOrder->amount ?? $order->finel_price)</strong></small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Your Potential Loss:</small>
                                <small><strong style="color: #dc3545;">@currency(($order->disputeOrder->amount ?? $order->finel_price) - $order->commission)</strong></small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger" id="submitCounterDisputeBtn">
                            <i class='bx bx-send'></i> Submit Counter-Dispute
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delivery Modal for Milestones -->
    @if($order->custom_offer_id && $order->customOffer)
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                    <h5 class="modal-title" id="deliveryModalLabel">
                        <i class='bx bx-check-double'></i> Deliver Milestone
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deliveryMilestoneId" value="">

                    <div class="alert alert-info d-flex align-items-start gap-2" style="font-size: 14px;">
                        <i class='bx bx-info-circle' style="font-size: 20px; flex-shrink: 0;"></i>
                        <div>
                            <strong>Delivering: </strong><span id="deliveryMilestoneTitle"></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deliveryNote" class="form-label fw-bold">Delivery Note (Optional)</label>
                        <textarea class="form-control"
                                  id="deliveryNote"
                                  rows="4"
                                  placeholder="Add any notes about your delivery, instructions for the buyer, or what was completed..."></textarea>
                        <small class="text-muted">This note will be visible to the buyer.</small>
                    </div>

                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745;">
                        <strong><i class='bx bx-info-circle'></i> What happens next?</strong>
                        <ul style="margin: 10px 0 0 0; padding-left: 20px; color: #666;">
                            <li>The buyer will be notified about your delivery</li>
                            <li>They can approve the milestone or request revisions</li>
                            <li>Once approved, the milestone will be marked as complete</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x'></i> Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="confirmDeliveryBtn">
                        <i class='bx bx-check-double'></i> Confirm Delivery
                    </button>
                </div>
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
        // ===== Milestone Management =====

        // Start milestone
        $(document).on('click', '.start-milestone-btn', function() {
            const milestoneId = $(this).data('milestone-id');
            const $btn = $(this);
            const originalText = $btn.html();

            if(confirm('Start working on this milestone? The status will change to "In Progress".')) {
                $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Starting...');

                $.ajax({
                    url: `/milestones/${milestoneId}/start`,
                    type: 'POST',
                    data: { _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        if (response.success) {
                            alert('Milestone started! You can now work on this milestone.');
                            location.reload();
                        } else {
                            alert(response.error || 'Failed to start milestone');
                            $btn.prop('disabled', false).html(originalText);
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Failed to start milestone';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        alert(errorMsg);
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            }
        });

        // Show delivery modal
        $(document).on('click', '.deliver-milestone-btn', function() {
            const milestoneId = $(this).data('milestone-id');
            const milestoneTitle = $(this).data('milestone-title');
            $('#deliveryMilestoneId').val(milestoneId);
            $('#deliveryMilestoneTitle').text(milestoneTitle);
            $('#deliveryNote').val('');
            $('#deliveryModal').modal('show');
        });

        // Confirm delivery
        $('#confirmDeliveryBtn').on('click', function() {
            const milestoneId = $('#deliveryMilestoneId').val();
            const deliveryNote = $('#deliveryNote').val().trim();
            const $btn = $(this);
            const originalText = $btn.html();

            $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Delivering...');

            $.ajax({
                url: `/milestones/${milestoneId}/deliver`,
                type: 'POST',
                data: {
                    delivery_note: deliveryNote,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert('Milestone delivered successfully! The buyer has been notified.');
                        $('#deliveryModal').modal('hide');
                        location.reload();
                    } else {
                        alert(response.error || 'Failed to deliver milestone');
                        $btn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Failed to deliver milestone';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    alert(errorMsg);
                    $btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Accept refund function
        function acceptRefund() {
            const confirmed = confirm(
                '⚠️ Are you sure you want to ACCEPT this refund request?\n\n' +
                'By accepting, you agree to:\n' +
                '• Refund @currencyRaw($order->disputeOrder->amount ?? $order->finel_price) to the buyer\n' +
                '• Forfeit your earnings from this order\n\n' +
                'This action CANNOT be undone!'
            );

            if (!confirmed) {
                return false;
            }

            // Create and submit form to accept disputed order
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("AcceptDisputedOrder") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add order ID
            const orderIdInput = document.createElement('input');
            orderIdInput.type = 'hidden';
            orderIdInput.name = 'order_id';
            orderIdInput.value = '{{ $order->id }}';
            form.appendChild(orderIdInput);

            document.body.appendChild(form);
            form.submit();
        }

        // Counter-dispute form validation
        document.getElementById('counterDisputeForm')?.addEventListener('submit', function(e) {
            const reason = document.getElementById('counterReason').value.trim();

            if (reason.length < 20) {
                e.preventDefault();
                alert('Please provide a more detailed explanation (at least 20 characters).');
                document.getElementById('counterReason').focus();
                return false;
            }

            // Confirm submission
            const confirmed = confirm(
                '⚠️ Submit Counter-Dispute?\n\n' +
                'This will escalate the case to admin review. The admin will review both your reason and the buyer\'s reason before making a decision.\n\n' +
                'Do you want to proceed?'
            );

            if (!confirmed) {
                e.preventDefault();
                return false;
            }

            // Disable submit button to prevent double submission
            document.getElementById('submitCounterDisputeBtn').disabled = true;
        });
    </script>
</body>

</html>
