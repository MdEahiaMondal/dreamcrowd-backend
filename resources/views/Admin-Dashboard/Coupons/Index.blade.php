<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coupon Management</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />

    <style>
        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .stats-card h3 {
            margin: 10px 0;
            font-size: 28px;
        }

        .stats-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .coupon-code {
            background: #f8f9fa;
            padding: 8px 15px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            font-size: 14px;
            color: #007bff;
            border: 2px dashed #007bff;
        }

        .action-buttons .btn {
            margin: 2px;
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
                                <h1 class="dash-title">Marketing</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Coupon Management</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-ticket" style="font-size: 40px; color: #28a745;"></i>
                                    <h2>Coupon & Discount Management</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stats-card" style="border-left-color: #007bff;">
                                <p>Total Coupons</p>
                                <h3 style="color: #007bff;">{{ $stats['total_coupons'] }}</h3>
                                <small style="color: #999;">All time</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="stats-card" style="border-left-color: #28a745;">
                                <p>Active Coupons</p>
                                <h3 style="color: #28a745;">{{ $stats['active_coupons'] }}</h3>
                                <small style="color: #999;">Currently valid</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="stats-card" style="border-left-color: #dc3545;">
                                <p>Total Discount Given</p>
                                <h3 style="color: #dc3545;">@currency($stats['total_discount_given'])</h3>
                                <small style="color: #999;">All time</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="stats-card" style="border-left-color: #ffc107;">
                                <p>Total Usage</p>
                                <h3 style="color: #ffc107;">{{ $stats['total_usage'] }}</h3>
                                <small style="color: #999;">Times used</small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a href="{{ route('admin.coupons.create') }}" class="btn btn-success">
                                <i class="fa-solid fa-plus"></i> Create New Coupon
                            </a>
                            <a href="{{ route('admin.coupons.analytics') }}" class="btn btn-info">
                                <i class="fa-solid fa-chart-line"></i> View Analytics
                            </a>
                        </div>
                    </div>

                    <!-- Coupons Table -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                        <h5><i class="fa-solid fa-list"></i> All Coupons</h5>
                    </div>

                    <div class="form-section">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background: #f8f9fa;">
                                <tr>
                                    <th>ID</th>
                                    <th>Coupon Name</th>
                                    <th>Code</th>
                                    <th>Discount</th>
                                    <th>Type</th>
                                    <th>Valid Period</th>
                                    <th>Usage</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($coupons as $coupon)
                                    <tr>
                                        <td><strong>#{{ $coupon->id }}</strong></td>
                                        <td>
                                            <strong>{{ $coupon->coupon_name }}</strong>
                                            @if($coupon->description)
                                                <br><small style="color: #999;">{{ Str::limit($coupon->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="coupon-code">{{ $coupon->coupon_code }}</span>
                                        </td>
                                        <td>
                                            @if($coupon->discount_type == 'percentage')
                                                <strong style="color: #28a745;">{{ $coupon->discount_value }}%</strong>
                                            @else
                                                <strong style="color: #28a745;">@currency($coupon->discount_value)</strong>
                                            @endif
                                            <br>
                                            <small style="color: #999;">{{ ucfirst($coupon->discount_type) }}</small>
                                        </td>
                                        <td>
                                            @if($coupon->coupon_type == 'seller-wide')
                                                <span class="badge bg-primary">Seller-Wide</span>
                                            @else
                                                <span class="badge bg-info">Custom</span>
                                                <br>
                                                <small>{{ $coupon->seller->name ?? 'N/A' }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                <strong>Start:</strong> {{ $coupon->start_date->format('d M Y') }}<br>
                                                <strong>End:</strong> {{ $coupon->expiry_date->format('d M Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <strong>{{ $coupon->usage_count }}</strong>
                                            @if($coupon->usage_limit)
                                                / {{ $coupon->usage_limit }}
                                            @else
                                                / ∞
                                            @endif
                                            <br>
                                            <small style="color: #999;">
                                                @currency($coupon->total_discount_given) saved
                                            </small>
                                        </td>
                                        <td>
                                                    <span class="badge bg-{{ $coupon->getStatusBadgeColor() }}">
                                                        {{ ucfirst($coupon->getStatus()) }}
                                                    </span>
                                            @if($coupon->one_time_use)
                                                <br><small class="badge bg-warning mt-1">One-Time</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.coupons.show', $coupon->id) }}" class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa-solid fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.coupons.toggle', $coupon->id) }}" class="btn btn-sm btn-{{ $coupon->is_active ? 'secondary' : 'success' }}" title="{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fa-solid fa-{{ $coupon->is_active ? 'ban' : 'check' }}"></i>
                                                </a>

                                                <button class="btn btn-sm btn-danger" onclick="deleteCoupon({{ $coupon->id }})" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <i class="fa-solid fa-inbox"></i> No coupons found. Create your first coupon!
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $coupons->links() }}
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
                <p><strong>Warning:</strong> This action cannot be undone. Usage history will be preserved.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
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
</script>
</body>
</html>
