<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="assets/admin/libs/animate/css/animate.css"/>
    <link rel="stylesheet" href="assets/admin/libs/aos/css/aos.css"/>
    <link rel="stylesheet" href="assets/admin/libs/datatable/css/datatable.css"/>

    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
    @endif

    <link href="assets/admin/libs/select2/css/select2.min.css" rel="stylesheet"/>
    <link href="assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet"/>
    <link href="assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/bootstrap.min.css"/>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="assets/admin/asset/css/sidebar.css"/>
    <link rel="stylesheet" href="assets/admin/asset/css/style.css"/>
    <link rel="stylesheet" href="assets/user/asset/css/style.css"/>

    <title>Super Admin Dashboard | Commission Management</title>

    <style>
        .commission-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .stats-box {
            background: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            transition: transform 0.2s;
        }

        .stats-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .stats-box h3 {
            margin: 10px 0;
            font-size: 28px;
        }

        .stats-box p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .feature-toggle {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #6c757d;
            margin-bottom: 15px;
        }

        .feature-toggle.active {
            border-left-color: #28a745;
            background: #d4edda;
        }

        .currency-info {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #ffc107;
            margin-bottom: 20px;
        }

        .manage-link {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 15px;
            background: #007bff;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            transition: background 0.2s;
        }

        .manage-link:hover {
            background: #0056b3;
            color: white;
        }
    </style>
</head>
<body>

@if (Session::has('error'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "10000",
            "extendedTimeOut": "4410000"
        }
        toastr.error("{{ session('error') }}");
    </script>
@endif

@if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "10000",
            "extendedTimeOut": "4410000"
        }
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
                                <h1 class="dash-title">Seller Setting</h1>
                                <i class="fa-solid fa-chevron-right"></i>
                                <span class="min-title">Commission Management</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Section -->
                    <div class="user-notification">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify">
                                    <img src="assets/admin/asset/img/dynamic-management.svg" alt=""/>
                                    <h2>Commission Management System</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ COMMISSION OVERVIEW DASHBOARD ============ -->
                    <div class="commission-card">
                        <h5 style="margin-bottom: 20px; color: #333;">
                            <i class="fa-solid fa-chart-line"></i> Current Commission Settings Overview
                        </h5>

                        <div class="row">
                            <!-- Default Seller Commission -->
                            <div class="col-md-3">
                                <div class="stats-box" style="border-left: 4px solid #007bff;">
                                    <p>Default Seller Commission</p>
                                    <h3 style="color: #007bff;">{{ $tag->commission ?? 15 }}%</h3>
                                    <span class="status-badge status-active">● Active</span>
                                </div>
                            </div>

                            <!-- Buyer Commission -->
                            <div class="col-md-3">
                                <div class="stats-box"
                                     style="border-left: 4px solid {{ ($tag && $tag->buyer_commission == 1) ? '#28a745' : '#dc3545' }};">
                                    <p>Buyer Commission</p>
                                    @if($tag && $tag->buyer_commission == 1)
                                        <h3 style="color: #28a745;">{{ $tag->buyer_commission_rate }}%</h3>
                                        <span class="status-badge status-active">● Active</span>
                                    @else
                                        <h3 style="color: #dc3545;">0%</h3>
                                        <span class="status-badge status-inactive">● Disabled</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Commission Type -->
                            <div class="col-md-3">
                                <div class="stats-box" style="border-left: 4px solid #ffc107;">
                                    <p>Commission Source</p>
                                    <h3 style="color: #ffc107; text-transform: capitalize; font-size: 20px;">
                                        {{ $tag->commission_type ?? 'Seller' }}
                                    </h3>
                                    <small style="color: #666;">Current Mode</small>
                                </div>
                            </div>

                            <!-- Currency -->
                            <div class="col-md-3">
                                <div class="stats-box" style="border-left: 4px solid #17a2b8;">
                                    <p>Platform Currency</p>
                                    <h3 style="color: #17a2b8;">{{ $tag->currency ?? 'USD' }}</h3>
                                    <small style="color: #666;">Stripe: {{ $tag->stripe_currency ?? 'GBP' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ CURRENCY SETTINGS ============ -->
                    <div class="currency-info">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 style="margin: 0 0 5px 0;">
                                    <i class="fa-solid fa-dollar-sign"></i> Currency Configuration
                                </h6>
                                <p style="margin: 0; font-size: 14px; color: #856404;">
                                    <strong>Platform Currency:</strong> {{ $tag->currency ?? 'USD' }} |
                                    <strong>Stripe Account Currency:</strong> {{ $tag->stripe_currency ?? 'GBP' }}
                                    <br>
                                    <small>⚠️ Automatic currency conversion will apply when currencies differ (1 USD ≈
                                        0.79 GBP)</small>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#currencyModal">
                                    <i class="fa-solid fa-gear"></i> Change Currency
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- ============ CUSTOM COMMISSION FEATURES ============ -->
                    <div class="commission-card">
                        <h5 style="margin-bottom: 15px;">
                            <i class="fa-solid fa-sliders"></i> Advanced Commission Features
                        </h5>

                        <div class="row">
                            <!-- Custom Seller Commission Feature -->
                            <div class="col-md-6">
                                <div class="feature-toggle {{ $tag->enable_custom_seller_commission ? 'active' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 style="margin: 0 0 5px 0;">
                                                <i class="fa-solid fa-user-tie"></i> Custom Commission Per Seller
                                            </h6>
                                            <small>Set different commission rates for specific sellers</small>
                                            @if($tag->enable_custom_seller_commission)
                                                <br><small><strong>{{ $customSellersCount ?? 0 }}</strong> sellers with
                                                    custom rates</small>
                                            @endif
                                        </div>
                                        <div style="margin-right: 57px">
                                            <input
                                                type="checkbox"
                                                id="toggle_seller_custom"
                                                class="add-page-check"
                                                {{ $tag->enable_custom_seller_commission ? 'checked' : '' }}
                                                onchange="toggleCustomFeature('seller')"
                                            >
                                            <label for="toggle_seller_custom"><span></span></label>
                                        </div>
                                    </div>
                                    @if($tag->enable_custom_seller_commission)
                                        <a href="/admin/manage-seller-commissions" class="manage-link">
                                            <i class="fa-solid fa-gear"></i> Manage Seller Commissions
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Custom Service Commission Feature -->
                            <div class="col-md-6">
                                <div
                                    class="feature-toggle {{ $tag->enable_custom_service_commission ? 'active' : '' }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 style="margin: 0 0 5px 0;">
                                                <i class="fa-solid fa-box"></i> Custom Commission Per Service/Class
                                            </h6>
                                            <small>Set different commission rates for specific services</small>
                                            @if($tag->enable_custom_service_commission)
                                                <br><small><strong>{{ $customServicesCount ?? 0 }}</strong> services
                                                    with custom rates</small>
                                            @endif
                                        </div>
                                        <div style="margin-right: 57px">
                                            <input
                                                type="checkbox"
                                                id="toggle_service_custom"
                                                class="add-page-check"
                                                {{ $tag->enable_custom_service_commission ? 'checked' : '' }}
                                                onchange="toggleCustomFeature('service')"
                                            >
                                            <label for="toggle_service_custom"><span></span></label>
                                        </div>
                                    </div>
                                    @if($tag->enable_custom_service_commission)
                                        <a href="/admin/manage-service-commissions" class="manage-link">
                                            <i class="fa-solid fa-gear"></i> Manage Service Commissions
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ============ DEFAULT SELLER COMMISSION FORM ============ -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                        <h5><i class="fa-solid fa-percent"></i> Default Seller Commission Rate</h5>
                    </div>

                    <div class="form-section">
                        <div class="row">
                            <form action="/update-commission-re" method="POST">
                                @csrf

                                <div class="col-12 mt-0">
                                    <label for="commission" class="form-label">
                                        Default Commission Rate (5-30%)
                                        <small class="text-muted">This rate applies to all sellers unless custom rate is
                                            set</small>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('commission') is-invalid @enderror"
                                        value="{{ old('commission', $tag->commission ?? '') }}"
                                        id="commission"
                                        name="commission"
                                        placeholder="Min: 5, Max: 30"
                                        required
                                    />

                                    @error('commission')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="api-buttons">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn float-end update-btn">
                                                <i class="fa-solid fa-floppy-disk"></i> Update Default Rate
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ============ BUYER COMMISSION FORM ============ -->
                    <div class="col-md-12 manage-profile-faq-sec edit-faqs">
                        <h5><i class="fa-solid fa-user-check"></i> Buyer Commission Rate (Optional)</h5>
                    </div>

                    <div class="form-section">
                        <div class="row">
                            <form id="buyer_commission_form" action="/update-buyer-commission-re" method="POST">
                                @csrf

                                <div class="col-12" style="display: flex; align-items: center; margin-bottom: 15px;">
                                    <label for="inputAddress" class="form-label mx-2">Enable/Disable Buyer
                                        Commission</label>
                                    <input type="hidden" name="buyer_commission" id="buyer_commission"
                                           value="@if($tag){{$tag->buyer_commission}}@endif">
                                    <input type="checkbox" name="" id="aa1" onclick="UpdateBuyerCommissionToggle()"
                                           class="add-page-check">
                                    <label for="aa1"><span></span></label>
                                </div>

                                <div class="col-12 mt-0" id="buyer_main_div">
                                    <label for="buyer_commission_rate" class="form-label">
                                        Buyer Commission Rate (1-15%)
                                        <small class="text-muted">Additional commission charged to buyers</small>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('buyer_commission_rate') is-invalid @enderror"
                                        value="{{ old('buyer_commission_rate', $tag->buyer_commission_rate ?? '') }}"
                                        id="buyer_commission_rate"
                                        name="buyer_commission_rate"
                                        placeholder="Min: 1, Max: 15"
                                    />

                                    @error('buyer_commission_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="api-buttons">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="buyer_commission_submit" type="button"
                                                    class="btn float-end update-btn">
                                                <i class="fa-solid fa-floppy-disk"></i> Update Buyer Commission
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
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>Copyright Dreamcrowd © 2021. All Rights Reserved.</p>
    </div>
</section>

<!-- ============ CURRENCY SETTINGS MODAL ============ -->
<div class="modal fade" id="currencyModal" tabindex="-1" aria-labelledby="currencyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="currencyModalLabel">
                    <i class="fa-solid fa-dollar-sign"></i> Currency Settings
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/update-currency-settings" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currency" class="form-label">Platform Currency</label>
                        <select class="form-control" id="currency" name="currency" required>
                            <option value="USD" {{ ($tag->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US
                                Dollar
                            </option>
                            <option value="GBP" {{ ($tag->currency ?? 'USD') == 'GBP' ? 'selected' : '' }}>GBP - British
                                Pound
                            </option>
                            <option value="EUR" {{ ($tag->currency ?? 'USD') == 'EUR' ? 'selected' : '' }}>EUR - Euro
                            </option>
                        </select>
                        <small class="text-muted">Currency shown to users on the platform</small>
                    </div>

                    <div class="mb-3">
                        <label for="stripe_currency" class="form-label">Stripe Account Currency</label>
                        <select class="form-control" id="stripe_currency" name="stripe_currency" required>
                            <option value="USD" {{ ($tag->stripe_currency ?? 'GBP') == 'USD' ? 'selected' : '' }}>USD -
                                US Dollar
                            </option>
                            <option value="GBP" {{ ($tag->stripe_currency ?? 'GBP') == 'GBP' ? 'selected' : '' }}>GBP -
                                British Pound
                            </option>
                            <option value="EUR" {{ ($tag->stripe_currency ?? 'GBP') == 'EUR' ? 'selected' : '' }}>EUR -
                                Euro
                            </option>
                        </select>
                        <small class="text-muted">Currency configured in your Stripe account</small>
                    </div>

                    <div class="alert alert-warning" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <strong>Note:</strong> If platform and Stripe currencies differ, automatic conversion will
                        apply.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Currency Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="assets/admin/libs/jquery/jquery.js"></script>
<script src="assets/admin/libs/datatable/js/datatable.js"></script>
<script src="assets/admin/libs/datatable/js/datatablebootstrap.js"></script>
<script src="assets/admin/libs/select2/js/select2.min.js"></script>
<script src="assets/admin/libs/owl-carousel/js/owl.carousel.min.js"></script>
<script src="assets/admin/libs/aos/js/aos.js"></script>
<script src="assets/admin/asset/js/bootstrap.min.js"></script>
<script src="assets/admin/asset/js/script.js"></script>

<script>
    // Initialize buyer commission toggle on page load
    $(document).ready(function () {
        var buyer_commission = @json($tag->buyer_commission);
        if (buyer_commission == 1) {
            $('#buyer_main_div').show();
            $('#aa1').attr('checked', true);
            $('#buyer_commission').val(1);
        } else {
            $('#buyer_main_div').hide();
            $('#aa1').removeAttr('checked');
            $('#buyer_commission').val(0);
        }
    });

    // Toggle buyer commission visibility
    function UpdateBuyerCommissionToggle() {
        if (!$('#aa1').attr('checked')) {
            $('#aa1').attr('checked', true);
            $('#buyer_commission').val(1);
            $('#buyer_main_div').show();
        } else {
            $('#aa1').removeAttr('checked');
            $('#buyer_commission').val(0);
            $('#buyer_main_div').hide();
        }
    }

    // Handle buyer commission form submission
    $('#buyer_commission_submit').click(function () {
        if ($('#aa1').attr('checked')) {
            $('#buyer_commission').val(1);
            var buyer_commission_rate = $('#buyer_commission_rate').val();

            if (buyer_commission_rate === '' || isNaN(buyer_commission_rate) || buyer_commission_rate < 1 || buyer_commission_rate > 15) {
                toastr.error("Please enter a valid commission rate between 1 and 15.");
                return false;
            }
        } else {
            $('#buyer_commission').val(0);
            $('#buyer_commission_rate').val('');
        }

        $('#buyer_commission_form').submit();
    });

    // Restrict inputs to numbers only
    const numberInputs = ['commission', 'buyer_commission_rate'];
    numberInputs.forEach(input => {
        document.getElementById(input).addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });

    // Toggle custom commission features (Seller/Service)
    function toggleCustomFeature(type) {
        const isChecked = $('#toggle_' + type + '_custom').is(':checked');

        $.ajax({
            url: '/admin/toggle-custom-' + type + '-commission',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                enable: isChecked ? 1 : 0
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    toastr.error(response.message);
                    $('#toggle_' + type + '_custom').prop('checked', !isChecked);
                }
            },
            error: function () {
                toastr.error('Failed to toggle feature. Please try again.');
                $('#toggle_' + type + '_custom').prop('checked', !isChecked);
            }
        });
    }
</script>

<!-- Sidebar Toggle Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", function (e) {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");

        sidebarBtn.addEventListener("click", function () {
            sidebar.classList.toggle("close");
        });

        function toggleSidebar() {
            let screenWidth = window.innerWidth;
            if (screenWidth < 992) {
                sidebar.classList.add("close");
            } else {
                sidebar.classList.remove("close");
            }
        }

        toggleSidebar();
        window.addEventListener("resize", function () {
            toggleSidebar();
        });
    });
</script>
</body>
</html>
