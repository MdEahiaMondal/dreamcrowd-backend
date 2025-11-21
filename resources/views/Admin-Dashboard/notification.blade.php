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
    <!-- Datatable css  -->
    <link rel="stylesheet" href="/assets/admin/libs/datatable/css/datatable.css" />

    {{-- Fav Icon --}}
    @php  $home = \App\Models\HomeDynamic::first(); @endphp
    @if ($home)
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{ $home->fav_icon }}" type="image/x-icon">
    @endif

    <!-- Select2 css -->
    <link href="/assets/admin/libs/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Owl carousel css -->
    <link href="/assets/admin/libs/owl-carousel/css/owl.carousel.css" rel="stylesheet" />
    <link href="/assets/admin/libs/owl-carousel/css/owl.theme.green.css" rel="stylesheet" />
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/bootstrap.min.css" />
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <!-- Fontawesome CDN -->
    <script src="https://kit.fontawesome.com/be69b59144.js" crossorigin="anonymous"></script>
    <!-- Default css -->
    <link rel="stylesheet" type="text/css" href="/assets/admin/asset/css/sidebar.css" />
    <link rel="stylesheet" href="/assets/admin/asset/css/style.css" />
    <link rel="stylesheet" href="/assets/user/asset/css/style.css" />

    <title>Super Admin Dashboard | Notification</title>

    <style>
        .notification-item {
            transition: all 0.3s ease;
        }

        .notification-item.unread {
            background-color: #f0f7ff;
            border-left: 4px solid #007bff;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .notification-actions button {
            padding: 5px 15px;
            font-size: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-mark-read {
            background-color: #28a745;
            color: white;
        }

        .btn-mark-read:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Tooltip styling */
        .tooltip-wrapper {
            position: relative;
            display: inline-block;
        }

        .tooltip-wrapper .tooltiptext {
            visibility: hidden;
            width: 220px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -110px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 12px;
        }

        .tooltip-wrapper .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .tooltip-wrapper:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .loading {
            text-align: center;
            padding: 20px;
        }

        .filters {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .filter-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-filter {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .notification-meta {
            display: flex;
            gap: 15px;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .notification-type {
            display: inline-block;
            padding: 2px 8px;
            background-color: #e9ecef;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        .modal-content{
            width: 100% !important;
        }

        /* Statistics Cards */
        .statistics-section {
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .stat-card.total {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card.unread {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-card.emergency {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card.today {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card.week {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card.email {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
            transition: all 0.5s ease;
        }

        .stat-card:hover::before {
            top: -60%;
            right: -60%;
        }

        .stat-icon {
            font-size: 36px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0 5px 0;
        }

        .stat-label {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
        }

        .stat-change {
            font-size: 12px;
            margin-top: 5px;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Fix Select2 dropdown positioning inside modal */
        .select2-container {
            z-index: 9999 !important;
        }

        .select2-dropdown {
            z-index: 9999 !important;
        }

        /* Ensure Select2 dropdown appears in correct position */
        .select2-container--open .select2-dropdown--below {
            border-top: none;
            margin-top: 2px;
        }

        .select2-container--open .select2-dropdown--above {
            border-bottom: none;
            margin-bottom: 2px;
        }

        /* Style Select2 inside modal */
        .modal .select2-container .select2-selection--multiple {
            min-height: 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 5px;
        }

        .modal .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #667eea;
            border: 1px solid #667eea;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            margin: 3px;
        }

        .modal .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 5px;
        }

        .modal .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #dc3545;
        }

        /* Fix dropdown positioning - make it relative to parent */
        .modal .select2-container--default.select2-container--open {
            position: relative;
        }
    </style>
</head>

<body>
    {{-- ===========Admin Sidebar Start==================== --}}
    <x-admin-sidebar />
    {{-- ===========Admin Sidebar End==================== --}}

    <section class="home-section">
        {{-- ===========Admin NavBar Start==================== --}}
        <x-admin-nav />
        {{-- ===========Admin NavBar End==================== --}}

        <!-- =============================== MAIN CONTENT START HERE =========================== -->
        <div class="container-fluid">
            <div class="row dash-notification">
                <div class="col-md-12">
                    <div class="dash">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dash-top">
                                    <h1 class="dash-title">Dashboard</h1>
                                    <i class="fa-solid fa-chevron-right"></i>
                                    <span class="min-title">Notifications</span>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Section -->
                        <div class="statistics-section">
                            <div class="stats-grid">
                                <div class="stat-card total">
                                    <div class="stat-icon">
                                        <i class="bx bx-bell"></i>
                                    </div>
                                    <div class="stat-value" id="stat-total">0</div>
                                    <div class="stat-label">Total Notifications</div>
                                </div>

                                <div class="stat-card unread">
                                    <div class="stat-icon">
                                        <i class="bx bx-bell-off"></i>
                                    </div>
                                    <div class="stat-value" id="stat-unread">0</div>
                                    <div class="stat-label">Unread</div>
                                </div>

                                <div class="stat-card emergency">
                                    <div class="stat-icon">
                                        <i class="bx bx-error-circle"></i>
                                    </div>
                                    <div class="stat-value" id="stat-emergency">0</div>
                                    <div class="stat-label">Emergency</div>
                                </div>

                                <div class="stat-card today">
                                    <div class="stat-icon">
                                        <i class="bx bx-calendar-star"></i>
                                    </div>
                                    <div class="stat-value" id="stat-today">0</div>
                                    <div class="stat-label">Today</div>
                                </div>

                                <div class="stat-card week">
                                    <div class="stat-icon">
                                        <i class="bx bx-calendar-week"></i>
                                    </div>
                                    <div class="stat-value" id="stat-week">0</div>
                                    <div class="stat-label">This Week</div>
                                </div>

                                <div class="stat-card email">
                                    <div class="stat-icon">
                                        <i class="bx bx-envelope"></i>
                                    </div>
                                    <div class="stat-value" id="stat-email">0</div>
                                    <div class="stat-label">Email Sent</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="filters">
                            <div class="filter-row">
                                <div class="filter-group">
                                    <label>Type:</label>
                                    <select id="filter-type">
                                        <option value="">All Types</option>
                                        <option value="order">Order</option>
                                        <option value="order_cancelled">Cancelled</option>
                                        <option value="order_delivered">Delivered</option>
                                        <option value="order_completed">Completed</option>
                                        <option value="class_reminder">Class Reminder</option>
                                        <option value="class_started">Class Started</option>
                                        <option value="class_ended">Class Ended</option>
                                        <option value="review_received">Review</option>
                                        <option value="zoom_connected">Zoom</option>
                                        <option value="zoom_token_expired">Zoom Token</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Status:</label>
                                    <select id="filter-read">
                                        <option value="">All</option>
                                        <option value="0">Unread</option>
                                        <option value="1">Read</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Priority:</label>
                                    <select id="filter-emergency">
                                        <option value="">All</option>
                                        <option value="0">Normal</option>
                                        <option value="1">Emergency</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Date From:</label>
                                    <input type="date" id="filter-date-from">
                                </div>
                                <div class="filter-group">
                                    <label>Date To:</label>
                                    <input type="date" id="filter-date-to">
                                </div>
                                <div class="filter-group">
                                    <button class="btn-filter" onclick="applyFilters()">Apply Filters</button>
                                    <button class="btn-filter" style="background-color: #6c757d; margin-left: 5px;"
                                        onclick="clearFilters()">Clear</button>
                                </div>
                            </div>
                        </div>

                        <!-- Send Notification Button -->
                        <div class="send-notify">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-end filter-group">
                                        <button type="button" class="btn-filter" style="background-color: #28a745;"
                                            onclick="markAllAsRead()">
                                            Mark All as Read
                                        </button>
                                        <button type="button" class="btn-filter" data-bs-target="#exampleModalToggle"
                                            data-bs-toggle="modal">
                                            Send new notification
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading State -->
                        <div id="loading" class="loading">
                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                            <p>Loading notifications...</p>
                        </div>

                        <!-- Notifications List -->
                        <div id="notifications-container" style="display: none;">
                            <!-- Notifications will be loaded here dynamically -->
                        </div>

                        <!-- Pagination -->
                        <div class="demo">
                            <nav class="pagination-outer" aria-label="Page navigation">
                                <ul class="pagination" id="pagination-container">
                                    <!-- Pagination will be loaded here dynamically -->
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- =============================== MAIN CONTENT END HERE =========================== -->
    </section>

    <!-- Send Notification Modal - Professional Redesign -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15);">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px 12px 0 0; padding: 20px 30px;">
                    <div>
                        <h5 class="modal-title" id="exampleModalToggleLabel" style="font-size: 20px; font-weight: 600; margin-bottom: 5px;">
                            <i class="bx bx-bell-plus"></i> Send New Notification
                        </h5>
                        <small style="opacity: 0.9;">Send notification to users</small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 30px;">
                    <form id="send-notification-form">
                        <!-- Emergency Notification -->
                        <div class="mb-4" style="background: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is-emergency" name="is_emergency" value="1">
                                <label class="form-check-label" for="is-emergency" style="cursor: pointer;">
                                    <strong style="color: #dc3545;">
                                        <i class="bx bx-error-circle"></i>
                                        Emergency Notification
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        Mark as high priority alert
                                    </small>
                                </label>
                            </div>
                        </div>

                        <!-- Send Email -->
                        <div class="mb-4" style="background: #d1ecf1; padding: 20px; border-radius: 8px; border-left: 4px solid #17a2b8;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="send-email" name="send_email" value="1" checked>
                                <label class="form-check-label" for="send-email" style="cursor: pointer;">
                                    <strong>
                                        <i class="bx bx-envelope"></i>
                                        Send Email Notification
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        Website notification always shown
                                    </small>
                                </label>
                            </div>
                        </div>

                        <!-- Target Audience -->
                        <div class="mb-4" style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
                            <label style="font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bx bx-group"></i>
                                <span>Target Audience</span>
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check" style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e9ecef; height: 100%;">
                                        <input class="form-check-input" type="radio" name="targetUser" id="target-all" value="all">
                                        <label class="form-check-label" for="target-all" style="cursor: pointer; width: 100%;">
                                            <div style="font-weight: 500;">All Users</div>
                                            <small class="text-muted">Send to all buyers and sellers</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check" style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e9ecef; height: 100%;">
                                        <input class="form-check-input" type="radio" name="targetUser" id="target-seller" value="seller">
                                        <label class="form-check-label" for="target-seller" style="cursor: pointer; width: 100%;">
                                            <div style="font-weight: 500;">Sellers Only</div>
                                            <small class="text-muted">Send to sellers only</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check" style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e9ecef; height: 100%;">
                                        <input class="form-check-input" type="radio" name="targetUser" id="target-buyer" value="buyer">
                                        <label class="form-check-label" for="target-buyer" style="cursor: pointer; width: 100%;">
                                            <div style="font-weight: 500;">Buyers Only</div>
                                            <small class="text-muted">Send to buyers only</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check" style="background: white; padding: 15px; border-radius: 8px; border: 2px solid #e9ecef; height: 100%;">
                                        <input class="form-check-input" type="radio" name="targetUser" id="target-specific" value="specific" checked>
                                        <label class="form-check-label" for="target-specific" style="cursor: pointer; width: 100%;">
                                            <div style="font-weight: 500;">Specific Users</div>
                                            <small class="text-muted">Select specific users</small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Recipient Count Badge -->
                            <div class="mt-3 text-center" style="background: white; padding: 12px; border-radius: 8px; border: 2px solid #007bff;">
                                <strong style="color: #007bff; font-size: 16px;">
                                    <i class="bx bx-user-check"></i>
                                    <span id="recipient-count">0</span> Recipients Selected
                                </strong>
                            </div>
                        </div>

                        <!-- User Selection (for specific users) -->
                        <div class="mb-4" id="userSelectDiv" style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #6f42c1;">
                            <label style="font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                                <i class="bx bx-search-alt"></i>
                                <span>Search & Select Users</span>
                            </label>
                            <select multiple="multiple" style="width: 100%" id="notificationUserId" required>
                                <!-- Options will be loaded via AJAX -->
                            </select>
                            <small class="text-muted mt-2 d-block"><i class="bx bx-info-circle"></i> Search by name or email</small>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label style="font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <i class="bx bx-text"></i>
                                <span>Notification Title</span>
                            </label>
                            <input type="text" class="form-control" id="notification-title" placeholder="Enter notification title" required style="padding: 12px; border-radius: 8px;" maxlength="100">
                            <small class="text-muted"><span id="title-char-count">0</span> / 100 characters</small>
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label style="font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <i class="bx bx-message-square-detail"></i>
                                <span>Message</span>
                            </label>
                            <textarea class="form-control" id="notification-message" rows="4" placeholder="Enter your message" required style="padding: 12px; border-radius: 8px;"></textarea>
                            <small class="text-muted"><span id="char-count">0</span> / 1000 characters</small>
                        </div>

                        <!-- Validation Errors -->
                        <div id="validation-errors" class="alert alert-danger" style="display: none; border-radius: 8px;"></div>
                    </form>
                </div>
                <div class="modal-footer" style="padding: 20px 30px; background: #f8f9fa; border-radius: 0 0 12px 12px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 30px; border-radius: 8px;">
                        <i class="bx bx-x"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary sndButton" onclick="sendNotification()" style="padding: 10px 30px; border-radius: 8px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                        <i class="bx bx-send"></i> Send Notification
                    </button>
                    <button type="button" class="btn btn-primary" id="loading-button" style="display: none; padding: 10px 30px; border-radius: 8px;">
                        <i class="fas fa-spinner fa-spin"></i> Sending...
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/admin/libs/jquery/jquery.js"></script>
    <!-- Fallback to CDN if local jQuery fails -->
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
    </script>
    <script src="/assets/admin/asset/js/bootstrap.min.js"></script>
    <script src="/assets/admin/libs/aos/js/aos.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 with AJAX search
            $('#notificationUserId').select2({
                placeholder: "Search by name or email",
                width: "100%",
                dropdownParent: $('#userSelectDiv'),
                dropdownAutoWidth: true,
                ajax: {
                    url: '/notifications/search-users',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        console.log('Search term:', params.term);
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        console.log('API Response:', data);
                        console.log('Results count:', data.results ? data.results.length : 0);
                        return {
                            results: data.results
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('Status:', status);
                        console.error('Response:', xhr.responseText);
                    },
                    cache: true
                },
                minimumInputLength: 1,
                templateResult: formatUserOption,
                templateSelection: formatUserSelection
            });

            // Format Select2 options with role badges
            function formatUserOption(user) {
                if (!user.id) {
                    return user.text;
                }

                // Build DOM elements programmatically for better compatibility
                var $container = $('<div></div>');
                var $name = $('<strong></strong>').text(user.name || user.text);
                var $badge = $('<span></span>')
                    .addClass('badge')
                    .css({
                        'background-color': user.role === 'Seller' ? '#007bff' : '#28a745',
                        'color': 'white',
                        'padding': '2px 8px',
                        'border-radius': '3px',
                        'font-size': '11px',
                        'margin-left': '8px'
                    })
                    .text(user.role || '');
                var $email = $('<small></small>')
                    .addClass('text-muted')
                    .css('display', 'block')
                    .text(user.email || '');

                $container.append($name);
                $container.append($badge);
                $container.append($email);

                return $container;
            }

            function formatUserSelection(user) {
                return user.name || user.text;
            }

            // Handle target audience changes
            $('input[name="targetUser"]').on('change', function() {
                const selectedValue = $(this).val();

                if (selectedValue === 'specific') {
                    $('#userSelectDiv').show();
                } else {
                    $('#userSelectDiv').hide();
                }

                // Update recipient count
                updateRecipientCount();
            });

            // Handle user selection changes
            $('#notificationUserId').on('change', function() {
                updateRecipientCount();
            });

            // Character counter for title
            $('#notification-title').on('input', function() {
                const length = $(this).val().length;
                $('#title-char-count').text(length);
                if (length > 100) {
                    $(this).val($(this).val().substring(0, 100));
                    $('#title-char-count').text(100);
                }
            });

            // Character counter for message
            $('#notification-message').on('input', function() {
                const length = $(this).val().length;
                $('#char-count').text(length);
                if (length > 1000) {
                    $(this).val($(this).val().substring(0, 1000));
                    $('#char-count').text(1000);
                }
            });

            // Initial state: show userSelectDiv since "specific" is checked by default
            $('#userSelectDiv').show();
            updateRecipientCount();
        });

        // Update recipient count function
        function updateRecipientCount() {
            const targetUser = $('input[name="targetUser"]:checked').val();
            const userIds = $('#notificationUserId').val() || [];

            $.ajax({
                url: '/notifications/count-recipients',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    targetUser: targetUser,
                    user_ids: userIds
                },
                success: function(response) {
                    $('#recipient-count').text(response.count);
                }
            });
        }
    </script>
    <script>
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
            alert('Error: jQuery library failed to load. Please refresh the page or check your internet connection.');
        }

        // Current admin user ID - injected from backend
        const CURRENT_ADMIN_ID = {{ auth()->id() }};

        let currentPage = 1;
        let currentFilters = {};

        // Load notifications on page load
        $(document).ready(function() {
            loadNotifications(1);
            updateUnreadCount();

            // Setup Pusher real-time updates
            setupPusher();

            // Add click handlers to stat cards for quick filtering
            $('.stat-card.unread').on('click', function() {
                $('#filter-read').val('0');
                applyFilters();
            });

            $('.stat-card.emergency').on('click', function() {
                $('#filter-emergency').val('1');
                applyFilters();
            });
        });

        // Update statistics display
        function updateStatistics(stats) {
            // Animate the number changes
            animateValue('stat-total', 0, stats.total, 800);
            animateValue('stat-unread', 0, stats.unread, 800);
            animateValue('stat-emergency', 0, stats.emergency, 800);
            animateValue('stat-today', 0, stats.today, 800);
            animateValue('stat-week', 0, stats.this_week, 800);
            animateValue('stat-email', 0, stats.email_sent, 800);
        }

        // Animate number counting
        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            if (!obj) return;

            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;

            const timer = setInterval(function() {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                obj.textContent = Math.floor(current);
            }, 16);
        }

        // Load notifications with pagination
        function loadNotifications(page = 1) {
            currentPage = page;
            $('#loading').show();
            $('#notifications-container').hide();

            let url = '/notifications?page=' + page;

            // Add filters
            if (currentFilters.type) url += '&type=' + currentFilters.type;
            if (currentFilters.is_read !== undefined && currentFilters.is_read !== '') url += '&is_read=' + currentFilters.is_read;
            if (currentFilters.is_emergency !== undefined && currentFilters.is_emergency !== '') url += '&is_emergency=' + currentFilters.is_emergency;
            if (currentFilters.date_from) url += '&date_from=' + currentFilters.date_from;
            if (currentFilters.date_to) url += '&date_to=' + currentFilters.date_to;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#loading').hide();
                    $('#notifications-container').show();
                    renderNotifications(response.notifications.data);
                    renderPagination(response.notifications);
                    $('#total-count').text(response.notifications.total);

                    // Update statistics
                    if (response.statistics) {
                        updateStatistics(response.statistics);
                    }
                },
                error: function(xhr) {
                    $('#loading').hide();
                    alert('Error loading notifications');
                    console.error(xhr);
                }
            });
        }

        // Render notifications
        function renderNotifications(notifications) {
            const container = $('#notifications-container');
            container.empty();

            if (notifications.length === 0) {
                container.html(
                    '<div class="empty-state"><i class="bx bx-bell-off" style="font-size: 48px;"></i><p>No notifications found</p></div>'
                );
                return;
            }

            notifications.forEach(function(notification) {
                const isUnread = !notification.is_read;
                const createdAt = new Date(notification.created_at).toLocaleString();
                const userName = notification.user ? (notification.user.first_name + ' ' + notification.user
                    .last_name) : 'N/A';

                // Build actor → target display - WITH ARROW →
                let actorTargetDisplay = '';
                if (notification.actor && notification.target) {
                    const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
                    const targetName = (notification.target.first_name + ' ' + notification.target.last_name).trim();

                    // Short format: "Shaki A → Gabriel A"
                    const actorShort = actorName.split(' ')[0] + ' ' + (actorName.split(' ')[1]?.[0] || '');
                    const targetShort = targetName.split(' ')[0] + ' ' + (targetName.split(' ')[1]?.[0] || '');

                    actorTargetDisplay = `<span><i class="bx bx-transfer"></i> ${actorShort} → ${targetShort}</span>`;
                } else if (notification.actor) {
                    const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
                    actorTargetDisplay = `<span><i class="bx bx-user"></i> Actor: ${actorName}</span>`;
                } else if (notification.target) {
                    const targetName = (notification.target.first_name + ' ' + notification.target.last_name).trim();
                    actorTargetDisplay = `<span><i class="bx bx-user"></i> Target: ${targetName}</span>`;
                }

                // Emergency badge
                const emergencyBadge = notification.is_emergency ?
                    '<span class="badge bg-danger ml-2"><i class="bx bx-error-circle"></i> EMERGENCY</span>' : '';

                // Email sent indicator
                const emailIndicator = notification.sent_email ?
                    '<i class="bx bx-envelope text-success" title="Email sent"></i>' :
                    '<i class="bx bx-globe text-primary" title="Website only"></i>';

                // Service information
                let serviceInfo = '';
                if (notification.service && notification.service.title) {
                    const serviceTitle = notification.service.title.length > 50
                        ? notification.service.title.substring(0, 50) + '...'
                        : notification.service.title;
                    serviceInfo = `<span><i class="bx bx-book-content"></i> Service: ${serviceTitle}</span>`;
                }

                // Order information
                let orderInfo = '';
                if (notification.order && notification.order.order_number) {
                    orderInfo = `<span><i class="bx bx-receipt"></i> Order: #${notification.order.order_number}</span>`;
                }

                // View Order Details button
                let viewOrderBtn = '';
                if (notification.order_id && notification.order && notification.order.order_number) {
                    viewOrderBtn = `<a href="/admin/order-details/${notification.order_id}" class="btn btn-sm" style="background-color: #007bff; color: white; margin-top: 5px;"><i class="bx bx-show"></i> View Order Details</a>`;
                }

                // Check if this notification belongs to the current admin
                const belongsToAdmin = notification.user_id === CURRENT_ADMIN_ID;
                const tooltipText = "This notification was sent to another user. You can only delete/mark as read notifications sent to you.";

                // Build action buttons with conditional disabling
                let markAsReadBtn = '';
                let deleteBtn = '';

                if (isUnread) {
                    if (belongsToAdmin) {
                        markAsReadBtn = `<button class="btn-mark-read" onclick="markAsRead(${notification.id})">Mark as Read</button>`;
                    } else {
                        markAsReadBtn = `
                            <div class="tooltip-wrapper">
                                <button class="btn-mark-read" disabled>Mark as Read</button>
                                <span class="tooltiptext">${tooltipText}</span>
                            </div>
                        `;
                    }
                }

                if (belongsToAdmin) {
                    deleteBtn = `<button class="btn-delete" onclick="deleteNotification(${notification.id})">Delete</button>`;
                } else {
                    deleteBtn = `
                        <div class="tooltip-wrapper">
                            <button class="btn-delete" disabled>Delete</button>
                            <span class="tooltiptext">${tooltipText}</span>
                        </div>
                    `;
                }

                const html = `
                    <div class="manu-notification notification-item ${isUnread ? 'unread' : ''}" id="notification-${notification.id}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify-1">
                                    <div class="bel-icon">
                                        <i class="${isUnread ? 'fa-solid' : 'fa-regular'} fa-bell"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h5 style="margin-bottom: 5px;">
                                            ${notification.title}
                                            ${emergencyBadge}
                                        </h5>
                                        <p style="margin-bottom: 5px;">${notification.message}</p>
                                        <div class="notification-meta">
                                            <span class="notification-type">${notification.type}</span>
                                            ${actorTargetDisplay || '<span><i class="bx bx-user"></i> ' + userName + '</span>'}
                                            ${serviceInfo}
                                            ${orderInfo}
                                            ${emailIndicator}
                                            <span><i class="bx bx-time"></i> ${createdAt}</span>
                                            ${notification.read_at ? '<span style="color: #28a745;"><i class="bx bx-check"></i> Read</span>' : '<span style="color: #dc3545;"><i class="bx bx-x"></i> Unread</span>'}
                                        </div>
                                        ${viewOrderBtn}
                                        <div class="notification-actions">
                                            ${markAsReadBtn}
                                            ${deleteBtn}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                container.append(html);
            });
        }

        // Render pagination
        function renderPagination(response) {
            const container = $('#pagination-container');
            container.empty();

            if (response.last_page <= 1) return;

            // Previous button
            if (response.current_page > 1) {
                container.append(`
                    <li class="page-item">
                        <a href="javascript:void(0)" class="page-link" onclick="loadNotifications(${response.current_page - 1})">«</a>
                    </li>
                `);
            }

            // Page numbers
            for (let i = 1; i <= response.last_page; i++) {
                const active = i === response.current_page ? 'active' : '';
                container.append(`
                    <li class="page-item ${active}">
                        <a href="javascript:void(0)" class="page-link" onclick="loadNotifications(${i})">${i}</a>
                    </li>
                `);
            }

            // Next button
            if (response.current_page < response.last_page) {
                container.append(`
                    <li class="page-item">
                        <a href="javascript:void(0)" class="page-link" onclick="loadNotifications(${response.current_page + 1})">»</a>
                    </li>
                `);
            }
        }

        // Mark notification as read
        function markAsRead(notificationId) {
            $.ajax({
                url: '/notifications/' + notificationId + '/read',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    // Update UI
                    $('#notification-' + notificationId).removeClass('unread');
                    $('#notification-' + notificationId).find('.btn-mark-read').remove();
                    updateUnreadCount();
                },
                error: function(xhr) {
                    alert('Error marking notification as read');
                    console.error(xhr);
                }
            });
        }

        // Delete notification
        function deleteNotification(notificationId) {
            if (!confirm('Are you sure you want to delete this notification?')) return;

            $.ajax({
                url: '/notifications/' + notificationId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $('#notification-' + notificationId).fadeOut(300, function() {
                        $(this).remove();
                        updateUnreadCount();
                    });
                },
                error: function(xhr) {
                    alert('Error deleting notification');
                    console.error(xhr);
                }
            });
        }

        // Mark all as read
        function markAllAsRead() {
            if (!confirm('Mark all notifications as read?')) return;

            $.ajax({
                url: '/notifications/mark-all-read',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    $('.notification-item').removeClass('unread');
                    $('.btn-mark-read').remove();
                    updateUnreadCount();
                    alert('All notifications marked as read');
                },
                error: function(xhr) {
                    alert('Error marking all as read');
                    console.error(xhr);
                }
            });
        }

        // Update unread count
        function updateUnreadCount() {
            $.ajax({
                url: '/notifications/unread-count',
                method: 'GET',
                success: function(response) {
                    $('#unread-count').text(response.count);
                }
            });
        }

        // Apply filters
        function applyFilters() {
            currentFilters = {
                type: $('#filter-type').val(),
                is_read: $('#filter-read').val(),
                is_emergency: $('#filter-emergency').val(),
                date_from: $('#filter-date-from').val(),
                date_to: $('#filter-date-to').val()
            };
            loadNotifications(1);
        }

        // Clear filters
        function clearFilters() {
            $('#filter-type').val('');
            $('#filter-read').val('');
            $('#filter-emergency').val('');
            $('#filter-date-from').val('');
            $('#filter-date-to').val('');
            currentFilters = {};
            loadNotifications(1);
        }

        // Send notification (admin only)
        function sendNotification() {
            // Hide validation errors
            $('#validation-errors').hide();

            // Get form values
            const userIds = $('#notificationUserId').val() || [];
            const title = $('#notification-title').val().trim();
            const message = $('#notification-message').val().trim();
            const targetUser = $('input[name="targetUser"]:checked').val();
            const isEmergency = $('#is-emergency').is(':checked') ? 1 : 0;
            const sendEmail = $('#send-email').is(':checked') ? 1 : 0;

            // Validate
            const errors = [];

            if (!title) {
                errors.push('Title is required');
            }

            if (!message) {
                errors.push('Message is required');
            }

            if (!targetUser) {
                errors.push('Please select target audience');
            }

            if (targetUser === 'specific' && userIds.length === 0) {
                errors.push('Please select at least one user');
            }

            // Show errors if any
            if (errors.length > 0) {
                $('#validation-errors').html('<ul style="margin-bottom: 0;">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>').show();
                return;
            }

            // Show loading state
            $(".sndButton").hide();
            $("#loading-button").css('display', 'block');

            // Send AJAX request
            $.ajax({
                url: '/notifications/send',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user_ids: userIds,
                    title: title,
                    message: message,
                    targetUser: targetUser,
                    is_emergency: isEmergency,
                    send_email: sendEmail
                },
                success: function(response) {
                    // Show success message
                    alert(response.message + '\n\nRecipients: ' + response.recipient_count + ' users');

                    // Close modal and reload
                    $('#exampleModalToggle').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    // Hide loading state
                    $(".sndButton").show();
                    $("#loading-button").hide();

                    // Show error
                    let errorMsg = 'Error sending notification';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = Object.values(xhr.responseJSON.errors).flat();
                        errorMsg = errors.join('<br>');
                    }

                    $('#validation-errors').html(errorMsg).show();
                }
            });
        }

        // Setup Pusher for real-time updates
        function setupPusher() {
            // Pusher setup would go here
            // For now, we'll just poll every 30 seconds
            setInterval(function() {
                updateUnreadCount();
            }, 30000);
        }
    </script>
</body>

</html>
