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
        <link rel="shortcut icon" href="/assets/public-site/asset/img/{{$home->fav_icon}}" type="image/x-icon">
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
        .btn-delete {
            background-color: #dc3545;
            color: white;
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
    </style>
</head>
<body>
    {{-- ===========Admin Sidebar Start==================== --}}
    <x-admin-sidebar/>
    {{-- ===========Admin Sidebar End==================== --}}

    <section class="home-section">
        {{-- ===========Admin NavBar Start==================== --}}
        <x-admin-nav/>
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

                        <!-- Blue MESSAGES section -->
                        <div class="user-notification">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="notify">
                                        <i class="bx bx-bell-minus"></i>
                                        <h2>All Notifications (<span id="total-count">0</span>)</h2>
                                        <span style="margin-left: 15px; color: #007bff;">Unread: <strong id="unread-count">0</strong></span>
                                    </div>
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
                                    <label>Date From:</label>
                                    <input type="date" id="filter-date-from">
                                </div>
                                <div class="filter-group">
                                    <label>Date To:</label>
                                    <input type="date" id="filter-date-to">
                                </div>
                                <div class="filter-group">
                                    <button class="btn-filter" onclick="applyFilters()">Apply Filters</button>
                                    <button class="btn-filter" style="background-color: #6c757d; margin-left: 5px;" onclick="clearFilters()">Clear</button>
                                </div>
                            </div>
                        </div>

                        <!-- Send Notification Button -->
                        <div class="send-notify">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                                        Send new notification
                                    </button>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn" style="background-color: #28a745;" onclick="markAllAsRead()">
                                        Mark All as Read
                                    </button>
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

    <!-- Send Notification Modal -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Send New Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="send-notification-form">
                        <div class="mb-3">
                            <label>User ID:</label>
                            <input type="number" class="form-control" id="notification-user-id" required>
                        </div>
                        <div class="mb-3">
                            <label>Type:</label>
                            <input type="text" class="form-control" id="notification-type" required>
                        </div>
                        <div class="mb-3">
                            <label>Title:</label>
                            <input type="text" class="form-control" id="notification-title" required>
                        </div>
                        <div class="mb-3">
                            <label>Message:</label>
                            <textarea class="form-control" id="notification-message" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="sendNotification()">Send</button>
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

    <script>
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
            alert('Error: jQuery library failed to load. Please refresh the page or check your internet connection.');
        }

        let currentPage = 1;
        let currentFilters = {};

        // Load notifications on page load
        $(document).ready(function() {
            loadNotifications(1);
            updateUnreadCount();

            // Setup Pusher real-time updates
            setupPusher();
        });

        // Load notifications with pagination
        function loadNotifications(page = 1) {
            currentPage = page;
            $('#loading').show();
            $('#notifications-container').hide();

            let url = '/notifications?page=' + page;

            // Add filters
            if (currentFilters.type) url += '&type=' + currentFilters.type;
            if (currentFilters.is_read) url += '&is_read=' + currentFilters.is_read;
            if (currentFilters.date_from) url += '&date_from=' + currentFilters.date_from;
            if (currentFilters.date_to) url += '&date_to=' + currentFilters.date_to;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $('#loading').hide();
                    $('#notifications-container').show();
                    renderNotifications(response.data);
                    renderPagination(response);
                    $('#total-count').text(response.total);
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
                container.html('<div class="empty-state"><i class="bx bx-bell-off" style="font-size: 48px;"></i><p>No notifications found</p></div>');
                return;
            }

            notifications.forEach(function(notification) {
                const isUnread = !notification.is_read;
                const createdAt = new Date(notification.created_at).toLocaleString();
                const userName = notification.user ? (notification.user.first_name + ' ' + notification.user.last_name) : 'N/A';

                const html = `
                    <div class="manu-notification notification-item ${isUnread ? 'unread' : ''}" id="notification-${notification.id}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="notify-1">
                                    <div class="bel-icon">
                                        <i class="${isUnread ? 'fa-solid' : 'fa-regular'} fa-bell"></i>
                                    </div>
                                    <div style="flex: 1;">
                                        <h5 style="margin-bottom: 5px;">${notification.title}</h5>
                                        <p style="margin-bottom: 5px;">${notification.message}</p>
                                        <div class="notification-meta">
                                            <span class="notification-type">${notification.type}</span>
                                            <span><i class="bx bx-user"></i> User: ${userName}</span>
                                            <span><i class="bx bx-time"></i> ${createdAt}</span>
                                            ${notification.read_at ? '<span style="color: #28a745;"><i class="bx bx-check"></i> Read</span>' : '<span style="color: #dc3545;"><i class="bx bx-x"></i> Unread</span>'}
                                        </div>
                                        <div class="notification-actions">
                                            ${isUnread ? '<button class="btn-mark-read" onclick="markAsRead(' + notification.id + ')">Mark as Read</button>' : ''}
                                            <button class="btn-delete" onclick="deleteNotification(${notification.id})">Delete</button>
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
                date_from: $('#filter-date-from').val(),
                date_to: $('#filter-date-to').val()
            };
            loadNotifications(1);
        }

        // Clear filters
        function clearFilters() {
            $('#filter-type').val('');
            $('#filter-read').val('');
            $('#filter-date-from').val('');
            $('#filter-date-to').val('');
            currentFilters = {};
            loadNotifications(1);
        }

        // Send notification (admin only)
        function sendNotification() {
            const userId = $('#notification-user-id').val();
            const type = $('#notification-type').val();
            const title = $('#notification-title').val();
            const message = $('#notification-message').val();

            if (!userId || !type || !title || !message) {
                alert('Please fill all fields');
                return;
            }

            // This would need a backend endpoint to create notifications
            alert('Send notification feature requires backend implementation');
            $('#exampleModalToggle').modal('hide');
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
