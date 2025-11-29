@extends('layout.app')
@section('title', 'Teacher Dashboard | Notifications')

@push('styles')
    <style>
        .notification-item {
            transition: all 0.3s ease;
            margin-bottom: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notification-item.unread {
            background-color: #f0f7ff;
            border-left: 4px solid #007bff;
        }

        .notification-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
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
            padding: 40px;
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
            margin-top: 8px;
            font-size: 12px;
            color: #666;
            flex-wrap: wrap;
        }

        .notification-type {
            display: inline-block;
            padding: 3px 10px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
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
    </style>
@endpush

@section('content')
    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row dash-notification">
            <div class="col-md-12">
                <div class="dash">
                    <div class="row">
                        <div class="col-md-12">
                            <x-breadcrumbs :items="[
                                ['label' => 'Dashboard', 'url' => '/teacher-dashboard'],
                                ['label' => 'Notifications', 'url' => '#'],
                            ]" />
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
                                <label>Notification Type:</label>
                                <select id="filter-type">
                                    <option value="">All Types</option>
                                    <option value="order">Order Updates</option>
                                    <option value="order_cancelled">Cancellations</option>
                                    <option value="order_delivered">Delivered</option>
                                    <option value="order_completed">Completed</option>
                                    <option value="class_reminder">Class Reminders</option>
                                    <option value="class_started">Class Started</option>
                                    <option value="class_ended">Class Ended</option>
                                    <option value="review_received">Reviews</option>
                                    <option value="zoom_connected">Zoom Connected</option>
                                    <option value="zoom_token_expired">Zoom Issues</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label>Status:</label>
                                <select id="filter-read">
                                    <option value="">All</option>
                                    <option value="0">Unread Only</option>
                                    <option value="1">Read Only</option>
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
                                <label>From Date:</label>
                                <input type="date" id="filter-date-from">
                            </div>
                            <div class="filter-group">
                                <label>To Date:</label>
                                <input type="date" id="filter-date-to">
                            </div>
                            <div class="filter-group">
                                <button class="btn-filter" onclick="applyFilters()">
                                    <i class="bx bx-filter"></i> Apply Filters
                                </button>
                                <button class="btn-filter" style="background-color: #6c757d; margin-left: 5px;"
                                    onclick="clearFilters()">
                                    <i class="bx bx-x"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="send-notify" style="margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn" style="background-color: #28a745;"
                                    onclick="markAllAsRead()">
                                    <i class="bx bx-check-double"></i> Mark All as Read
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Loading State -->
                    <div id="loading" class="loading">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p style="margin-top: 15px;">Loading your notifications...</p>
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

@endsection

@push('scripts')
    <script>
        let currentPage = 1;
        let currentFilters = {};

        // Load notifications on page load
        $(document).ready(function() {
            loadNotifications(1);
            updateUnreadCount();

            // Auto-refresh every 30 seconds
            setInterval(function() {
                updateUnreadCount();
            }, 30000);

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
            if (currentFilters.is_read !== undefined && currentFilters.is_read !== '') url += '&is_read=' + currentFilters
                .is_read;
            if (currentFilters.is_emergency !== undefined && currentFilters.is_emergency !== '') url += '&is_emergency=' +
                currentFilters.is_emergency;
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

                    // Update statistics
                    if (response.statistics) {
                        updateStatistics(response.statistics);
                    }
                },
                error: function(xhr) {
                    $('#loading').hide();
                    $('#notifications-container').html(
                        '<div class="empty-state">' +
                        '<i class="bx bx-error-circle"></i>' +
                        '<p>Error loading notifications. Please try again.</p>' +
                        '</div>'
                    );
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
                    '<div class="empty-state">' +
                    '<i class="bx bx-bell-off"></i>' +
                    '<p>No notifications found</p>' +
                    '<small>You will be notified about orders, classes, and other important updates here.</small>' +
                    '</div>'
                );
                return;
            }

            notifications.forEach(function(notification) {
                const isUnread = !notification.is_read;
                const createdAt = new Date(notification.created_at).toLocaleString();
                const timeAgo = getTimeAgo(notification.created_at);

                // Build actor → target display - WITH ARROW →
                let actorTargetDisplay = '';
                if (notification.actor && notification.target) {
                    const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
                    const targetName = (notification.target.first_name + ' ' + notification.target.last_name)
                        .trim();

                    // Short format: "Shaki A → Gabriel A"
                    const actorShort = actorName.split(' ')[0] + ' ' + (actorName.split(' ')[1]?.[0] || '');
                    const targetShort = targetName.split(' ')[0] + ' ' + (targetName.split(' ')[1]?.[0] || '');

                    actorTargetDisplay =
                        `<span><i class="bx bx-transfer"></i> ${actorShort} → ${targetShort}</span>`;
                } else if (notification.actor) {
                    const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
                    actorTargetDisplay = `<span><i class="bx bx-user"></i> From: ${actorName}</span>`;
                } else if (notification.target) {
                    const targetName = (notification.target.first_name + ' ' + notification.target.last_name)
                        .trim();
                    actorTargetDisplay = `<span><i class="bx bx-user"></i> To: ${targetName}</span>`;
                }

                // Emergency badge
                const emergencyBadge = notification.is_emergency ?
                    '<span class="badge bg-danger" style="margin-left: 8px;"><i class="bx bx-error-circle"></i> EMERGENCY</span>' :
                    '';

                // Email sent indicator
                const emailIndicator = notification.sent_email ?
                    '<span title="Email sent"><i class="bx bx-envelope text-success"></i></span>' :
                    '<span title="Website only"><i class="bx bx-globe text-primary"></i></span>';

                // Service information
                let serviceInfo = '';
                if (notification.service && notification.service.title) {
                    const serviceTitle = notification.service.title.length > 50 ?
                        notification.service.title.substring(0, 50) + '...' :
                        notification.service.title;
                    serviceInfo = `<span><i class="bx bx-book-content"></i> ${serviceTitle}</span>`;
                }

                // Order information
                let orderInfo = '';
                if (notification.order && notification.order.order_number) {
                    orderInfo =
                        `<span><i class="bx bx-receipt"></i> Order #${notification.order.order_number}</span>`;
                }

                // View Order Details button
                let viewOrderBtn = '';
                if (notification.order_id && notification.order && notification.order.order_number) {
                    viewOrderBtn =
                        `<a href="/teacher/order-details/${notification.order_id}" class="btn btn-sm" style="background-color: #007bff; color: white; margin-top: 8px; padding: 5px 15px; border-radius: 4px; text-decoration: none; display: inline-block;"><i class="bx bx-show"></i> View Order Details</a>`;
                }

                const html = `
                    <div class="notification-item ${isUnread ? 'unread' : ''}" id="notification-${notification.id}">
                        <div class="d-flex align-items-start">
                            <div class="me-3" style="font-size: 24px; color: ${isUnread ? '#007bff' : '#999'};">
                                <i class="${isUnread ? 'fa-solid' : 'fa-regular'} fa-bell"></i>
                            </div>
                            <div style="flex: 1;">
                                <h5 style="margin-bottom: 5px; font-size: 16px;">
                                    ${notification.title}
                                    ${emergencyBadge}
                                </h5>
                                <p style="margin-bottom: 8px; color: #555;">${notification.message}</p>
                                <div class="notification-meta">
                                    <span class="notification-type">${notification.type.replace(/_/g, ' ')}</span>
                                    ${actorTargetDisplay}
                                    ${serviceInfo}
                                    ${orderInfo}
                                    ${emailIndicator}
                                    <span><i class="bx bx-time"></i> ${timeAgo}</span>
                                    <span title="${createdAt}"><i class="bx bx-calendar"></i> ${createdAt}</span>
                                    ${notification.read_at ?
                                        '<span style="color: #28a745;"><i class="bx bx-check-circle"></i> Read</span>' :
                                        '<span style="color: #dc3545;"><i class="bx bx-x-circle"></i> Unread</span>'}
                                </div>
                                ${viewOrderBtn}
                                <div class="notification-actions">
                                    ${isUnread ?
                                        '<button class="btn-mark-read" onclick="markAsRead(' + notification.id + ')"><i class="bx bx-check"></i> Mark as Read</button>' : ''}
                                    <button class="btn-delete" onclick="deleteNotification(${notification.id})"><i class="bx bx-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                container.append(html);
            });
        }

        // Get time ago string
        function getTimeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);

            if (seconds < 60) return 'Just now';
            if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
            if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
            if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';
            return date.toLocaleDateString();
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
                        <a href="javascript:void(0)" class="page-link" onclick="loadNotifications(${response.current_page - 1})">
                            <i class="bx bx-chevron-left"></i>
                        </a>
                    </li>
                `);
            }

            // Page numbers (show max 5 pages)
            let startPage = Math.max(1, response.current_page - 2);
            let endPage = Math.min(response.last_page, response.current_page + 2);

            for (let i = startPage; i <= endPage; i++) {
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
                        <a href="javascript:void(0)" class="page-link" onclick="loadNotifications(${response.current_page + 1})">
                            <i class="bx bx-chevron-right"></i>
                        </a>
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
                    $('#notification-' + notificationId).removeClass('unread');
                    $('#notification-' + notificationId).find('.btn-mark-read').fadeOut(200, function() {
                        $(this).remove();
                    });
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

                        // Check if container is empty
                        if ($('#notifications-container .notification-item').length === 0) {
                            loadNotifications(currentPage);
                        }
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
                    $('.btn-mark-read').fadeOut(200, function() {
                        $(this).remove();
                    });
                    updateUnreadCount();

                    // Show success message
                    showToast('Success', 'All notifications marked as read', 'success');
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

        // Update today count
        function updateTodayCount() {
            const today = new Date().toISOString().split('T')[0];
            $.ajax({
                url: '/notifications?date_from=' + today + '&date_to=' + today,
                method: 'GET',
                success: function(response) {
                    $('#today-count').text(response.total);
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

        // Show toast notification (optional)
        function showToast(title, message, type) {
            // Simple alert for now - can be replaced with a toast library
            alert(title + ': ' + message);
        }
    </script>
@endpush
