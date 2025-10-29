<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Coupon Details - {{ $coupon->coupon_code }}</title>

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

        .coupon-code-display {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .coupon-code-display h2 {
            font-size: 48px;
            margin: 10px 0;
            letter-spacing: 5px;
            font-family: 'Courier New', monospace;
        }

        .stat-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
        }

        .stat-box h3 {
            margin: 5px 0;
            font-size: 28px;
        }

        .stat-box p {
            margin: 0;
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>

@if (Session::has('success'))
    <script>
        toastr.success("{{ session('success') }}");
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
                                <h1 class="dash-title">Coupon Management</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Coupon Details</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-ticket" style="font-size: 40px; color: #007bff;"></i>
                                    <h2>Coupon Details & Usage History</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left"></i> Back to Coupons
                        </a>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-warning">
                            <i class="fa-solid fa-edit"></i> Edit Coupon
                        </a>
                    </div>

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">

                            <!-- Coupon Code Display -->
                            <div class="coupon-code-display">
                                <p style="margin: 0; opacity: 0.9;">Coupon Code</p>
                                <h2>{{ $coupon->coupon_code }}</h2>
                                <p style="margin: 0; opacity: 0.9;">{{ $coupon->coupon_name }}</p>
                            </div>

                            <!-- Coupon Details -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px;">
                                    <i class="fa-solid fa-info-circle"></i> Coupon Information
                                </h5>

                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 30%; color: #666;"><strong>Coupon ID:</strong></td>
                                        <td>#{{ $coupon->id }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #666;"><strong>Discount Type:</strong></td>
                                        <td>
                                            {{ ucfirst($coupon->discount_type) }}
                                            @if($coupon->discount_type == 'percentage')
                                                <span style="color: #28a745; font-size: 20px; font-weight: bold;">({{ $coupon->discount_value }}%)</span>
                                            @else
                                                <span style="color: #28a745; font-size: 20px; font-weight: bold;">(${{ number_format($coupon->discount_value, 2) }})</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #666;"><strong>Coupon Scope:</strong></td>
                                        <td>
                                            @if($coupon->coupon_type == 'seller-wide')
                                                <span class="badge bg-primary">All Sellers</span>
                                            @else
                                                <span class="badge bg-info">Specific Seller</span>
                                                <br>{{ $coupon->seller->name ?? 'N/A' }} ({{ $coupon->seller_email }})
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #666;"><strong>Valid Period:</strong></td>
                                        <td>
                                            {{ $coupon->start_date->format('d M Y') }}
                                            to {{ $coupon->expiry_date->format('d M Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #666;"><strong>Status:</strong></td>
                                        <td>
                                                <span class="badge bg-{{ $coupon->getStatusBadgeColor() }}">
                                                    {{ ucfirst($coupon->getStatus()) }}
                                                </span>
                                            @if(!$coupon->is_active)
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color: #666;"><strong>Usage Restrictions:</strong></td>
                                        <td>
                                            @if($coupon->one_time_use)
                                                <span class="badge bg-warning">One-Time Use Per Customer</span>
                                            @endif
                                            @if($coupon->usage_limit)
                                                <span class="badge bg-info">Max {{ $coupon->usage_limit }} Uses</span>
                                            @else
                                                <span class="badge bg-success">Unlimited Uses</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($coupon->description)
                                        <tr>
                                            <td style="color: #666;"><strong>Description:</strong></td>
                                            <td>{{ $coupon->description }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td style="color: #666;"><strong>Created:</strong></td>
                                        <td>{{ $coupon->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Usage History -->
                            <div class="detail-card">
                                <h5 style="margin-bottom: 20px;">
                                    <i class="fa-solid fa-history"></i> Usage History
                                </h5>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead style="background: #f8f9fa;">
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Buyer</th>
                                            <th>Seller</th>
                                            <th>Original</th>
                                            <th>Discount</th>
                                            <th>Final</th>
                                            <th>Transaction</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($usages as $usage)
                                            <tr>
                                                <td>{{ $usages->firstItem() + $loop->index }}</td>
                                                <td>
                                                    <small>{{ $usage->used_at->format('d M Y') }}
                                                        <br>{{ $usage->used_at->format('h:i A') }}</small>
                                                </td>
                                                <td>{{ $usage->buyer->name ?? 'N/A' }}</td>
                                                <td>{{ $usage->seller->name ?? 'N/A' }}</td>
                                                <td>${{ number_format($usage->original_amount, 2) }}</td>
                                                <td style="color: #dc3545; font-weight: bold;">
                                                    -${{ number_format($usage->discount_amount, 2) }}</td>
                                                <td style="color: #28a745; font-weight: bold;">
                                                    ${{ number_format($usage->final_amount, 2) }}</td>
                                                <td>
                                                    @if($usage->transaction_id)
                                                        <a href="/admin/transaction/details/{{ $usage->transaction_id }}"
                                                           class="btn btn-sm btn-info">
                                                            #{{ $usage->transaction_id }}
                                                        </a>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    <i class="fa-solid fa-inbox"></i> No usage history yet
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $usages->links() }}
                                </div>
                            </div>

                        </div>

                        <!-- Right Column - Statistics -->
                        <div class="col-md-4">

                            <!-- Usage Statistics -->
                            <div class="detail-card">
                                <h6 style="margin-bottom: 15px;">
                                    <i class="fa-solid fa-chart-bar"></i> Usage Statistics
                                </h6>

                                <div class="stat-box" style="border-left: 4px solid #007bff;">
                                    <p>Times Used</p>
                                    <h3 style="color: #007bff;">{{ $coupon->usage_count }}</h3>
                                    @if($coupon->usage_limit)
                                        <small style="color: #999;">of {{ $coupon->usage_limit }} limit</small>
                                    @else
                                        <small style="color: #999;">Unlimited</small>
                                    @endif
                                </div>

                                <div class="stat-box" style="border-left: 4px solid #dc3545;">
                                    <p>Total Discount Given</p>
                                    <h3 style="color: #dc3545;">
                                        ${{ number_format($coupon->total_discount_given, 2) }}</h3>
                                    <small style="color: #999;">All time</small>
                                </div>

                                <div class="stat-box" style="border-left: 4px solid #28a745;">
                                    <p>Average Discount</p>
                                    <h3 style="color: #28a745;">
                                        @if($coupon->usage_count > 0)
                                            ${{ number_format($coupon->total_discount_given / $coupon->usage_count, 2) }}
                                        @else
                                            $0.00
                                        @endif
                                    </h3>
                                    <small style="color: #999;">Per use</small>
                                </div>

                                <div class="stat-box" style="border-left: 4px solid #ffc107;">
                                    <p>Days Until Expiry</p>
                                    <h3 style="color: #ffc107;">
                                        @php
                                            $daysLeft = now()->diffInDays($coupon->expiry_date, false);
                                        @endphp
                                        @if($daysLeft > 0)
                                            {{ $daysLeft }}
                                        @elseif($daysLeft == 0)
                                            Today
                                        @else
                                            Expired
                                        @endif
                                    </h3>
                                    <small style="color: #999;">
                                        Expires: {{ $coupon->expiry_date->format('d M Y') }}
                                    </small>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="detail-card">
                                <h6 style="margin-bottom: 15px;">
                                    <i class="fa-solid fa-bolt"></i> Quick Actions
                                </h6>

                                @if($coupon->is_active)
                                    <a href="{{ route('admin.coupons.toggle', $coupon->id) }}"
                                       class="btn btn-primary w-100 mb-2">
                                        <i class="fa-solid fa-ban"></i> Deactivate Coupon
                                    </a>
                                @else
                                    <a href="{{ route('admin.coupons.toggle', $coupon->id) }}"
                                       class="btn btn-success w-100 mb-2">
                                        <i class="fa-solid fa-check"></i> Activate Coupon
                                    </a>
                                @endif

                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                   class="btn btn-warning w-100 mb-2">
                                    <i class="fa-solid fa-edit"></i> Edit Details
                                </a>

                                <button class="btn btn-danger w-100" onclick="deleteCoupon({{ $coupon->id }})">
                                    <i class="fa-solid fa-trash"></i> Delete Coupon
                                </button>
                            </div>

                            <!-- Share Coupon Code -->
                            <div class="detail-card" style="background: #e7f3ff;">
                                <h6 style="margin-bottom: 15px; color: #007bff;">
                                    <i class="fa-solid fa-share-nodes"></i> Share Coupon Code
                                </h6>

                                <div class="input-group mb-2">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="couponCodeCopy"
                                        value="{{ $coupon->coupon_code }}"
                                        readonly
                                    />
                                    <button class="btn btn-primary" type="button" onclick="copyCouponCode()">
                                        <i class="fa-solid fa-copy"></i> Copy
                                    </button>
                                </div>
                                <small style="color: #666;">Share this code with customers</small>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fa-solid fa-trash"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this coupon?</p>
                <p><strong>Code:</strong> {{ $coupon->coupon_code }}</p>
                <p><strong>Warning:</strong> This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script>
    // Sidebar script
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement; // Selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        // Function to toggle sidebar based on screen size
        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        // Call the function initially
        toggleSidebar();

        // Listen for resize events to adjust sidebar
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
<script>
    function deleteCoupon(id) {
        $('#deleteForm').attr('action', '/admin/coupons/' + id);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    function copyCouponCode() {
        const copyText = document.getElementById("couponCodeCopy");
        copyText.select();
        copyText.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(copyText.value).then(function () {
            toastr.success('Coupon code copied to clipboard!');
        }, function (err) {
            toastr.error('Failed to copy coupon code');
        });
    }
</script>
</body>
</html>
