<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Coupon</title>

    <link rel="stylesheet" href="assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="assets/admin/asset/css/style.css" />
</head>
<body>

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
                                <h1 class="dash-title">Coupon Management</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Edit Coupon</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <i class="fa-solid fa-edit" style="font-size: 40px; color: #ffc107;"></i>
                                    <h2>Edit Coupon: {{ $coupon->coupon_code }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="mb-3">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                            <i class="fa-solid fa-arrow-left"></i> Back to Coupons
                        </a>
                    </div>

                    <!-- Edit Coupon Form -->
                    <div class="form-section">
                        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Coupon Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="coupon_name" class="form-label">
                                        Coupon Name <span style="color: red;">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('coupon_name') is-invalid @enderror"
                                        id="coupon_name"
                                        name="coupon_name"
                                        value="{{ old('coupon_name', $coupon->coupon_name) }}"
                                        required
                                    />
                                    @error('coupon_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Coupon Code -->
                                <div class="col-md-6 mb-3">
                                    <label for="coupon_code" class="form-label">
                                        Coupon Code <span style="color: red;">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('coupon_code') is-invalid @enderror"
                                        id="coupon_code"
                                        name="coupon_code"
                                        value="{{ old('coupon_code', $coupon->coupon_code) }}"
                                        style="text-transform: uppercase;"
                                        required
                                    />
                                    <small class="text-muted">Current usage: {{ $coupon->usage_count }} times</small>
                                    @error('coupon_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Discount Type -->
                                <div class="col-md-4 mb-3">
                                    <label for="discount_type" class="form-label">
                                        Discount Type <span style="color: red;">*</span>
                                    </label>
                                    <select
                                        class="form-control @error('discount_type') is-invalid @enderror"
                                        id="discount_type"
                                        name="discount_type"
                                        onchange="updateDiscountLabel()"
                                        required
                                    >
                                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                        <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                    </select>
                                    @error('discount_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Discount Value -->
                                <div class="col-md-4 mb-3">
                                    <label for="discount_value" class="form-label">
                                        <span id="discount_label">Discount Value</span> <span style="color: red;">*</span>
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control @error('discount_value') is-invalid @enderror"
                                        id="discount_value"
                                        name="discount_value"
                                        value="{{ old('discount_value', $coupon->discount_value) }}"
                                        min="0"
                                        step="0.01"
                                        required
                                    />
                                    <small class="text-muted" id="discount_hint"></small>
                                    @error('discount_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Usage Limit -->
                                <div class="col-md-4 mb-3">
                                    <label for="usage_limit" class="form-label">
                                        Usage Limit (Optional)
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="usage_limit"
                                        name="usage_limit"
                                        value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                        min="1"
                                        placeholder="Leave empty for unlimited"
                                    />
                                    <small class="text-muted">Current: {{ $coupon->usage_count }} used</small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Start Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">
                                        Start Date <span style="color: red;">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date"
                                        name="start_date"
                                        value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}"
                                        required
                                    />
                                    @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Expiry Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="expiry_date" class="form-label">
                                        Expiry Date <span style="color: red;">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        class="form-control @error('expiry_date') is-invalid @enderror"
                                        id="expiry_date"
                                        name="expiry_date"
                                        value="{{ old('expiry_date', $coupon->expiry_date->format('Y-m-d')) }}"
                                        required
                                    />
                                    @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Coupon Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="coupon_type" class="form-label">
                                        Coupon Scope <span style="color: red;">*</span>
                                    </label>
                                    <select
                                        class="form-control @error('coupon_type') is-invalid @enderror"
                                        id="coupon_type"
                                        name="coupon_type"
                                        onchange="toggleSellerField()"
                                        required
                                    >
                                        <option value="seller-wide" {{ old('coupon_type', $coupon->coupon_type) == 'seller-wide' ? 'selected' : '' }}>All Sellers (Seller-Wide)</option>
                                        <option value="custom" {{ old('coupon_type', $coupon->coupon_type) == 'custom' ? 'selected' : '' }}>Specific Seller Only</option>
                                    </select>
                                    @error('coupon_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Seller Email -->
                                <div class="col-md-6 mb-3" id="seller_email_field" style="display: none;">
                                    <label for="seller_email" class="form-label">
                                        Seller Email <span style="color: red;">*</span>
                                    </label>
                                    <select
                                        class="form-control select2 @error('seller_email') is-invalid @enderror"
                                        id="seller_email"
                                        name="seller_email"
                                    >
                                        <option value="">-- Select Seller --</option>
                                        @foreach($sellers as $seller)
                                            <option value="{{ $seller->email }}" {{ old('seller_email', $coupon->seller_email) == $seller->email ? 'selected' : '' }}>
                                                {{ $seller->name }} ({{ $seller->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seller_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Active Status -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            id="is_active"
                                            name="is_active"
                                            value="1"
                                            {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                                        />
                                        <label class="form-check-label" for="is_active">
                                            <strong>Coupon is Active</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            id="one_time_use"
                                            name="one_time_use"
                                            value="1"
                                            {{ old('one_time_use', $coupon->one_time_use) ? 'checked' : '' }}
                                        />
                                        <label class="form-check-label" for="one_time_use">
                                            <strong>One-Time Use Per Customer</strong>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">
                                        Description (Optional)
                                    </label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        rows="3"
                                    >{{ old('description', $coupon->description) }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="api-buttons">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">
                                            <i class="fa-solid fa-times"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-warning float-end">
                                            <i class="fa-solid fa-save"></i> Update Coupon
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
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

<!-- Scripts -->
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script src="assets/admin/libs/select2/js/select2.min.js"></script>
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
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Search and select seller",
            allowClear: true
        });

        toggleSellerField();
        updateDiscountLabel();
    });

    function toggleSellerField() {
        const couponType = $('#coupon_type').val();
        if (couponType === 'custom') {
            $('#seller_email_field').show();
            $('#seller_email').attr('required', true);
        } else {
            $('#seller_email_field').hide();
            $('#seller_email').attr('required', false);
        }
    }

    function updateDiscountLabel() {
        const type = $('#discount_type').val();
        if (type === 'percentage') {
            $('#discount_label').text('Discount Percentage (%)');
            $('#discount_hint').text('Maximum 100%');
            $('#discount_value').attr('max', '100');
        } else {
            $('#discount_label').text('Discount Amount ($)');
            $('#discount_hint').text('Fixed dollar amount');
            $('#discount_value').removeAttr('max');
        }
    }

    $('#coupon_code').on('input', function() {
        this.value = this.value.toUpperCase();
    });
</script>
</body>
</html>
