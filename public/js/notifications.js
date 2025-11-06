// notifications.js - Complete Push Notification System
// Include this file in all pages where you want notifications

(function () {
    'use strict';

    // Configuration
    const CONFIG = {
        pusherKey: 'cf6b96e5efc265f6c172', // Replace with your Pusher key
        pusherCluster: 'ap2', // Replace with your cluster (e.g., 'ap2')
        apiBaseUrl: '/notifications', // Adjust based on your routes
        userId: null, // Will be set from data attribute
        autoMarkReadDelay: 5000, // Auto mark as read after 5 seconds
        notificationDuration: 5000, // Show notification for 5 seconds
        userRole: null,
    };

    // Notification Manager Class
    class NotificationManager {
        constructor() {

            this.userId = document.querySelector('.authUserId')?.getAttribute('data-user-id');
            this.userRole = document.querySelector('.authUserId')?.getAttribute('data-user-role');
            this.notifications = [];
            this.unreadCount = 0;
            this.pusher = null;
            this.channel = null;

            if (this.userId) {
                this.init();
            }
        }

        init() {
            this.setupPusher();
            this.createNotificationUI();
            this.loadUnreadCount();
            this.loadRecentNotifications();
            this.attachEventListeners();
            // Don't request permission automatically - let user trigger it
            // this.requestNotificationPermission();
            this.loadMessageCount();
        }

        async loadMessageCount() {
            try {
                const response = await fetch(`/messages/unread-count/${this.userId}`);
                const data = await response.json();
                this.updateMessageCount(data.count);
            } catch (error) {
                console.error('Error loading message count:', error);
            }
        }

        // Setup Pusher Connection
        setupPusher() {
            try {
                this.pusher = new Pusher(CONFIG.pusherKey, {
                    cluster: CONFIG.pusherCluster,
                    encrypted: true
                });

                this.channel = this.pusher.subscribe('user.' + this.userId);
                // Message Channel Subscribe
                this.messageChannel = this.pusher.subscribe('message.' + this.userId);



                this.channel.bind('notification', (data) => {
                    this.handleNewNotification(data);
                });

                this.messageChannel.bind('message', (data) => {

                    this.updateMessageCount(data.count);
                });

                console.log('Pusher connected successfully');
            } catch (error) {
                console.error('Pusher connection error:', error);
            }
        }

        // Create Notification UI Elements
        createNotificationUI() {
            // Check if UI already exists
            // if (document.getElementById('notification-bell')) return;

            const notificationHTML = `
                <div id="notification-container">
                    <!-- Notification Bell Icon -->
                    <div id="notification-bell" style="position: relative; cursor: pointer; width: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                             <svg class="" width="28" height="32" viewBox="0 0 28 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.7941 30.9716H12.1954C11.9877 31.1215 11.7432 31.2005 11.4948 31.2005C11.2464 31.2005 11.0018 31.1215 10.7941 30.9716Z"
                                    stroke="#181818" stroke-width="1.6"/>
                                <path
                                    d="M22.2 27.4289V28.5315H0.8V27.4289L0.802222 27.4268L0.802275 27.4269L0.810426 27.4192C1.59587 26.6807 2.2818 25.8374 2.8504 24.9121L2.86979 24.8805L2.88618 24.8473C3.5233 23.5564 3.90462 22.1478 4.00867 20.7041L4.01074 20.6754V20.6466L4.01074 16.696L4.01074 16.6944C4.00703 14.7892 4.67005 12.9512 5.8708 11.5203C7.07099 10.0902 8.7256 9.16464 10.5252 8.90693L11.2117 8.80861V8.11501V7.06738C11.2117 6.98741 11.2427 6.91619 11.2892 6.86801C11.3347 6.82079 11.3904 6.79976 11.4421 6.79976C11.4939 6.79976 11.5495 6.82079 11.5951 6.86801C11.6416 6.91619 11.6725 6.98741 11.6725 7.06738V8.09902V8.80009L12.3675 8.8921C14.1832 9.13246 15.8579 10.0523 17.074 11.4872C18.2907 12.9228 18.963 14.7742 18.9584 16.694V16.696V20.6466V20.6754L18.9605 20.7041C19.0645 22.1478 19.4458 23.5564 20.083 24.8473L20.1005 24.8829L20.1215 24.9166C20.7002 25.8444 21.3974 26.688 22.1949 27.4242L22.1978 27.4268L22.2 27.4289Z"
                                    stroke="#181818" stroke-width="1.6"/>


                            </svg>
                        <span id="notification-badge" style="position: absolute;
                                right: 7px;
                                color: #fff;
                                font-size: 10px;
                                background: #0072B1;
                                min-width: 18px;
                                height: 19px;
                                padding: 2px;
                                border-radius: 50%;
                                top: 0px;
                                text-align: center;">0</span>
                    </div>


                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" style="z-index: 99999; display: none; position: absolute; top: 60px; right: 0; width: 350px; max-height: 500px; background: white; border-radius: 8px; box-shadow: 0 8px 16px rgba(0,0,0,0.15); overflow: hidden;">
                        <div style="padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="margin: 0; font-size: 16px; font-weight: bold;">Notifications</h3>
                            <button id="mark-all-read" style="background: none; border: none; color: #4CAF50; cursor: pointer; font-size: 13px;">Mark all read</button>
                        </div>
                        <div id="notification-list" style="max-height: 400px; overflow-y: auto; text-align: left;">
                            <div style="padding: 40px 20px; text-align: center; color: #999;">
                                Loading notifications...
                            </div>
                        </div>
                    </div>

                    <!-- Toast Notification -->
                    <div id="notification-toast" style="display: none; position: fixed; top: 80px; right: 20px; width: 350px; background: white; border-radius: 8px; box-shadow: 0 8px 16px rgba(0,0,0,0.2); padding: 15px; animation: slideIn 0.3s ease;">
                        <div style="display: flex; align-items: start; gap: 10px;">
                            <div style="flex: 1;">
                                <h4 id="toast-title" style="margin: 0 0 5px 0; font-size: 14px; font-weight: bold;"></h4>
                                <p id="toast-message" style="margin: 0; font-size: 13px; color: #666;"></p>
                            </div>
                            <button id="toast-close" style="background: none; border: none; cursor: pointer; font-size: 18px; color: #999;">&times;</button>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes slideIn {
                        from { transform: translateX(400px); opacity: 0; }
                        to { transform: translateX(0); opacity: 1; }
                    }
                    @keyframes slideOut {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(400px); opacity: 0; }
                    }
                    .notification-item {
                        padding: 15px;
                        border-bottom: 1px solid #eee;
                        cursor: pointer;
                        transition: background 0.2s;
                    }
                    .notification-item:hover {
                        background: #f5f5f5;
                    }
                    .notification-item.unread {
                        background: #f0f8ff;
                    }
                    .notification-item h4 {
                        margin: 0 0 5px 0;
                        font-size: 14px;
                        font-weight: bold;
                    }
                    .notification-item p {
                        margin: 0 0 5px 0;
                        font-size: 13px;
                        color: #666;
                    }
                    .notification-item small {
                        font-size: 11px;
                        color: #999;
                    }
                    .notification-item .delete-btn {
                        float: right;
                        background: none;
                        border: none;
                        color: #f44336;
                        cursor: pointer;
                        font-size: 18px;
                        padding: 0;
                        margin-left: 10px;
                    }
                </style>
            `;
            // Message Icon + Count
            const messageHTML = `
                    <div id="message-container" style="position: relative; cursor: pointer; width: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                         <svg class="me-2" width="40" height="32" viewBox="0 0 40 32" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M30.5 13.9218V13.0474L29.7464 13.4908L16.2548 21.4306C16.2547 21.4306 16.2547 21.4307 16.2546 21.4307C16.1909 21.4681 16.1197 21.4909 16.0461 21.4974C15.978 21.5035 15.9095 21.4955 15.8447 21.4741L15.7244 21.4184L2.2535 13.4948L1.5 13.0516V13.9258V26.9998C1.5 27.928 1.86875 28.8183 2.52513 29.4746C3.1815 30.131 4.07174 30.4998 5 30.4998H27C27.9283 30.4998 28.8185 30.131 29.4749 29.4746C30.1312 28.8183 30.5 27.928 30.5 26.9998V13.9218ZM1.5 11.6038V11.8897L1.74647 12.0347L15.7465 20.2707L16.0001 20.4199L16.2536 20.2707L30.2536 12.0307L30.5 11.8856V11.5998V10.9998C30.5 10.0715 30.1312 9.18126 29.4749 8.52488C28.8185 7.8685 27.9283 7.49976 27 7.49976H5C4.07174 7.49976 3.1815 7.8685 2.52513 8.52488C1.86875 9.18126 1.5 10.0715 1.5 10.9998V11.6038ZM27 6.49976C28.1935 6.49976 29.3381 6.97386 30.182 7.81778C31.0259 8.66169 31.5 9.80628 31.5 10.9998V26.9998C31.5 28.1932 31.0259 29.3378 30.182 30.1817C29.3381 31.0257 28.1935 31.4998 27 31.4998H5C3.80653 31.4998 2.66193 31.0257 1.81802 30.1817C0.974106 29.3378 0.5 28.1932 0.5 26.9998V10.9998C0.5 9.80628 0.974106 8.66169 1.81802 7.81778C2.66193 6.97386 3.80653 6.49976 5 6.49976H27Z"
                                    stroke="#181818"/>
                           
                            </svg>
                        <span id="message-badge" style="position: absolute;
                            right: 7px;
                            color: #fff;
                            font-size: 10px;
                            background: #0072B1;
                            min-width: 18px;
                            height: 19px;
                            padding: 2px;
                            border-radius: 50%;
                            top: 0px;
                            text-align: center;
                            display: none;">0</span>
                    </div>
                `;
            document.getElementsByClassName('notificationSectionAz')[0].innerHTML = notificationHTML;
            document.getElementsByClassName('messageSectionAz')[0].innerHTML = messageHTML;

            // document.body.insertAdjacentHTML('beforeend', notificationHTML);
        }

        // Attach Event Listeners
        attachEventListeners() {
            const bell = document.getElementById('notification-bell');
            const dropdown = document.getElementById('notification-dropdown');
            const markAllRead = document.getElementById('mark-all-read');
            const toastClose = document.getElementById('toast-close');
            const messageIcon = document.getElementById('message-container');


            // Toggle dropdown
            bell.addEventListener('click', () => {
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

                // Request notification permission on first interaction
                if ('Notification' in window && Notification.permission === 'default') {
                    Notification.requestPermission();
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });

            // Mark all as read
            markAllRead.addEventListener('click', () => {
                this.markAllAsRead();
            });

            // Close toast
            toastClose.addEventListener('click', () => {
                this.hideToast();
            });

            messageIcon.addEventListener('click', () => {
                const role = String(this.userRole);
                const messageUrl = role === '2' ? '/admin-messages' : (role === '1' ? '/teacher-messages' : '/user-messages');
                window.location.href = messageUrl;
            });

        }

        // Request Browser Notification Permission
        requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        // Handle New Notification
        handleNewNotification(data) {
            this.notifications.unshift(data);
            this.unreadCount++;
            this.updateBadge();
            this.showToast(data);
            this.showBrowserNotification(data);
            this.addNotificationToList(data);
        }

        // Show Toast Notification
        showToast(notification) {
            const toast = document.getElementById('notification-toast');
            const title = document.getElementById('toast-title');
            const message = document.getElementById('toast-message');

            title.textContent = notification.title;
            message.textContent = notification.message;

            toast.style.display = 'block';

            setTimeout(() => {
                this.hideToast();
            }, CONFIG.notificationDuration);
        }

        hideToast() {
            const toast = document.getElementById('notification-toast');
            toast.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                toast.style.display = 'none';
                toast.style.animation = 'slideIn 0.3s ease';
            }, 300);
        }

        // Show Browser Notification
        showBrowserNotification(notification) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(notification.title, {
                    body: notification.message,
                    icon: '/path/to/icon.png', // Add your icon path
                    badge: '/path/to/badge.png'
                });
            }
        }

        // Load Unread Count
        async loadUnreadCount() {
            try {
                const response = await fetch(`${CONFIG.apiBaseUrl}/unread-count`);
                const data = await response.json();
                this.unreadCount = data.count;
                this.updateBadge();
            } catch (error) {
                console.error('Error loading unread count:', error);
            }
        }

        // Load Recent Notifications
        async loadRecentNotifications() {
            try {
                const response = await fetch(`${CONFIG.apiBaseUrl}`);
                const data = await response.json();
                this.notifications = data.data || [];
                this.renderNotifications();
            } catch (error) {
                console.error('Error loading notifications:', error);
                this.showError('Failed to load notifications');
            }
        }

        // Render Notifications
        renderNotifications() {
            const list = document.getElementById('notification-list');

            if (this.notifications.length === 0) {
                list.innerHTML = '<div style="padding: 40px 20px; text-align: center; color: #999;">No notifications yet</div>';
                return;
            }

            list.innerHTML = this.notifications.map(notif => this.createNotificationHTML(notif)).join('');
            this.attachNotificationListeners();
        }

        // Create Notification HTML
        createNotificationHTML(notification) {
            const isUnread = !notification.is_read;
            const date = this.formatDate(notification.created_at);

            return `
                <div class="notification-item ${isUnread ? 'unread' : ''}" data-id="${notification.id}">
                    <button class="delete-btn" data-id="${notification.id}">&times;</button>
                    <h4>${this.escapeHtml(notification.title)}</h4>
                    <p>${this.escapeHtml(notification.message)}</p>
                    <small>${date}</small>
                </div>
            `;
        }

        // Add New Notification to List
        addNotificationToList(notification) {
            const list = document.getElementById('notification-list');
            if (list.querySelector('div[style*="No notifications"]')) {
                list.innerHTML = '';
            }
            list.insertAdjacentHTML('afterbegin', this.createNotificationHTML(notification));
            this.attachNotificationListeners();
        }

        // Attach Notification Item Listeners
        attachNotificationListeners() {
            const items = document.querySelectorAll('.notification-item');
            items.forEach(item => {
                item.addEventListener('click', (e) => {
                    if (!e.target.classList.contains('delete-btn')) {
                        this.markAsRead(item.dataset.id);
                    }
                });
            });

            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.deleteNotification(btn.dataset.id);
                });
            });
        }

        // Mark Notification as Read
        async markAsRead(id) {
            try {
                const response = await fetch(`${CONFIG.apiBaseUrl}/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    }
                });

                if (response.ok) {
                    const item = document.querySelector(`.notification-item[data-id="${id}"]`);
                    if (item && item.classList.contains('unread')) {
                        item.classList.remove('unread');
                        this.unreadCount--;
                        this.updateBadge();
                    }
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        }

        // Mark All as Read
        async markAllAsRead() {
            try {
                const response = await fetch(`${CONFIG.apiBaseUrl}/mark-all-read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    }
                });

                if (response.ok) {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                    });
                    this.unreadCount = 0;
                    this.updateBadge();
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }

        // Delete Notification
        async deleteNotification(id) {
            try {
                const response = await fetch(`${CONFIG.apiBaseUrl}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.getCSRFToken()
                    }
                });

                if (response.ok) {
                    const item = document.querySelector(`.notification-item[data-id="${id}"]`);
                    if (item) {
                        if (item.classList.contains('unread')) {
                            this.unreadCount--;
                            this.updateBadge();
                        }
                        item.remove();

                        // Update notifications array
                        this.notifications = this.notifications.filter(n => n.id != id);

                        // Show empty state if no notifications
                        if (this.notifications.length === 0) {
                            this.renderNotifications();
                        }
                    }
                }
            } catch (error) {
                console.error('Error deleting notification:', error);
            }
        }

        // Update Badge Count
        updateBadge() {
            const badge = document.getElementById('notification-badge');
            if (this.unreadCount > 0) {
                badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }

        // Helper Functions
        getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        }

        formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000); // seconds

            if (diff < 60) return 'Just now';
            if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
            if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
            if (diff < 604800) return `${Math.floor(diff / 86400)} days ago`;

            return date.toLocaleDateString();
        }

        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        showError(message) {
            const list = document.getElementById('notification-list');
            list.innerHTML = `<div style="padding: 20px; text-align: center; color: #f44336;">${message}</div>`;
        }

        // Public method to send notification programmatically
        static async sendNotification(userId, type, title, message, data = {}, sendEmail = false) {
            // This would be called from your backend
            console.log('Use NotificationService in your controller to send notifications');
        }

        updateMessageCount(count) {
            const badge = document.getElementById('message-badge');
            if (!badge) return;

            if (count > 0) {

                const current = parseInt(String(badge.textContent).replace(/\D/g, ''), 10) || 0;
                let finalCount = current + count;

                if (window.location.pathname.includes('user-messages') || 
                    window.location.pathname.includes('teacher-messages') || 
                    window.location.pathname.includes('admin-messages')) {
                    finalCount = 0;
                    badge.style.display = 'none';

                } else {
                    finalCount = current + count;
                    badge.textContent = finalCount > 99 ? '99+' : String(finalCount);
                    badge.style.display = 'block';
                }
                
          
            } else {
                badge.style.display = 'none';
            }
        }
    }


    // 🧩 Prevent multiple initialization globally
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.notificationManager) {
                window.notificationManager = new NotificationManager();
            }
        });
    } else {
        if (!window.notificationManager) {
            window.notificationManager = new NotificationManager();
        }
    }

    // Make NotificationManager globally accessible
    window.NotificationManager = NotificationManager;

})();